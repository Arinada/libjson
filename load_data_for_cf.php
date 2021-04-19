<?php
//$query = "SELECT SPECTRUM_IMG, MASS_NUMBER, IONIZATION,Z,ATOM_MASS,IONIZATION_POTENCIAL,
//ENERGY_DIMENSION,ABBR,TABLEPERIOD,TABLEGROUP,NAME_EN,NAME_RU,NAME_RU_ALT,PERIODICTABLE.[TYPE] AS ELEMENT_TYPE,
//PERIODICTABLE.ID AS ELEMENT_ID, INTERFACE_CONTENT.* FROM  ATOMS,PERIODICTABLE,INTERFACE_CONTENT WHERE
// ATOMS.ID='$element_id' AND ATOMS.ID_ELEMENT = PERIODICTABLE.ID AND INTERFACE_CONTENT.ID=ATOMS.DESCRIPTION";
//function get_atoms
$atoms_fields = array('MASS_NUMBER', 'IONIZATION' , 'LIMITS', 'BREAKS', 'IONIZATION_POTENCIAL', 'ENERGY_DIMENSION');
$periodictable_fields = array('ID', 'ABBR', 'TABLEPERIOD', 'TABLEGROUP', 'NAME_EN', 'NAME_RU', 'NAME_RU_ALT', 'TYPE', 'Z','ATOM_MASS'); //all fields
$levels_fields = array('ID', 'ENERGY', 'TERMMULTIPLY', 'CONFIG', 'J', 'TERMPREFIX', 'TERMFIRSTPART', 'TERMSECONDPART');
//transitions
//$query = "SELECT TRANSITIONS.*,lower_level.ID AS lower_level_id,lower_level.energy AS lower_level_energy,lower_level.termmultiply AS lower_level_termmultiply, lower_level.CONFIG AS lower_level_config,lower_level.J AS lower_level_j,lower_level.TERMPREFIX AS lower_level_termprefix,lower_level.TERMMULTIPLY AS lower_level_termmultiply,lower_level.TERMFIRSTPART AS lower_level_termfirstpart,lower_level.TERMSECONDPART AS lower_level_termsecondpart,
//upper_level.ID AS upper_level_id,upper_level.energy AS upper_level_energy, upper_level.termmultiply as upper_level_termmultiply, upper_level.CONFIG AS upper_level_config,upper_level.J AS upper_level_j,upper_level.TERMPREFIX AS upper_level_termprefix,upper_level.TERMMULTIPLY AS upper_level_termmultiply,upper_level.TERMFIRSTPART AS upper_level_termfirstpart,upper_level.TERMSECONDPART AS upper_level_termsecondpart,
//[dbo].GetCfgType(upper_level.CONFIG) AS upper_level_config_type, dbo.ConcatSourcesID(TRANSITIONS.ID,'T') AS SOURCE_IDS
//FROM TRANSITIONS LEFT JOIN LEVELS AS lower_level ON TRANSITIONS.ID_LOWER_LEVEL=lower_level.ID LEFT JOIN LEVELS AS upper_level ON TRANSITIONS.ID_UPPER_LEVEL=upper_level.ID
//WHERE TRANSITIONS.ID_ATOM='$element_id' ORDER BY WAVELENGTH";
$all_transitions_fields = array();
$all_levels_fields = array();
require_once 'open_connection.php';
require_once 'load_data_from_file.php';

$load = new LoadData();
$all_interface_content_fields = $load->GetFields('INTERFACE_CONTENT', $link);
$all_transitions_fields = $load->GetFields('TRANSITIONS', $link);
$all_levels_fields = $load->GetFields('LEVELS', $link);
require_once 'close_connection.php';
require_once 'spectrum.php';

$dataFileName = '/uploads/data.json';
$fileToWrite = fopen('/uploads/atoms1.json', 'wb');

$data = file_get_contents($dataFileName);
$data = json_decode($data, true);
if (json_last_error() !== JSON_ERROR_NONE)
    die('Incorrect json format');
//atoms.json
//function getAtomsDataFile(){
fwrite($fileToWrite, '{');
getAtomsValue($data, $atoms_fields, $fileToWrite);
fwrite($fileToWrite,  ", ");
writeDataForOneElement('periodictable', $data, $periodictable_fields, $fileToWrite);
fwrite($fileToWrite,  ", ");
writeDataForOneElement('interface_content', $data, $all_interface_content_fields, $fileToWrite);
fwrite($fileToWrite, '}');
fclose($fileToWrite);
//transitions.json
//function getTransitionsDataFile
$fileToWriteTransitions = fopen('/uploads/transitions1.json', 'wb');
writeDataAboutTransitionsWithLevels($data, $all_transitions_fields, $fileToWriteTransitions, $levels_fields);
fclose($fileToWriteTransitions);

//$ar_periodictable = getAtomsValue($dataFileName, $atoms_fields, $fileToWrite);
//$ar_atoms = getDataAboutAtoms($atoms_fields, $periodictable_fields, $dataFileName);
//$atom_sys = array_merge($ar_atoms, $ar_periodictable);
//unset($atom_sys['SPECTRUM_IMG']);
//foreach (array_keys($atom_sys) as $key) {
//    $atom_sys[$key] = iconv("Windows-1251", "UTF-8", $atom_sys[$key]);
//}

//require_once 'initialize_smarty.php';
//$smarty->assign('atom_json', json_encode($atom_sys, 256));
//
//$atom_sys = file_get_contents('Z:\uploads\atoms.json');
//$smarty->assign('atom_json', $atom_sys);
////
//$transitions = file_get_contents('Z:\uploads\transitions.json');
//$smarty->assign('transitions_json',$transitions);
////
//$levels = file_get_contents('Z:\uploads\levels.json');
//$smarty->assign('levels_json',$levels);
////
//$smarty->display('view_cf.tpl');


function getDataAboutAtoms($atoms_fields, $periodictable_fields, $fileName){
      //  getFieldsValue($fileName, $periodictable_fields, 'periodictable');
}

//для одного элемента (без вложенных элементов)
function writeDataForOneElement($type_name, $data, $fields, $file){
    //open file
    //get data and write
    $fields_count = count($fields);
    $counter = 0;
    foreach ($fields as $field_name) {
        $val = $data['atom_system'][$type_name][$field_name];
        $val = addslashes($val);
        $val = str_replace(PHP_EOL, '</br>', $val);
        $val = str_replace(' ', '\u0020', $val);
        $val = preg_replace('[\t]', '\u0445', $val); //u0445
        if($type_name=='periodictable' && $field_name=='ID')
            $field_name = 'ELEMENT_ID';
        if($type_name=='periodictable' && $field_name=='TYPE')
            $field_name = 'ELEMENT_TYPE';
        if ($val == null || $val == "NULL")
            fwrite( $file,'"'. $field_name .'": "NULL"');
        else
            fwrite( $file,'"'. $field_name .'": "'.$val.'"');
        if($counter != $fields_count-1)
            fwrite($file,  ", ");
        $counter++;
    }
}

function writeDataAboutTransitionsWithLevels($data, $fields, $file, $levels_fields){
    $fields_count = count($fields);
    $elements_number = count($data['atom_system']['transitions']);
    $lower_level_id = 0;
    $upper_level_id = 0;
    $transition_id = 0;
    $wavelength = 0;
    $counter = 0;
    print $fields_count;
    if($elements_number >  1)
        fwrite($file, '[');
    for($element_number=0; $element_number < $elements_number; $element_number++) {
        fwrite($file, '{');
        foreach ($fields as $field_name) {
            $val = $data['atom_system']['transitions'][$element_number][$field_name];
            $val = addslashes($val);
            $val = str_replace(PHP_EOL, '</br>', $val);
            $val = str_replace(' ', '\u0020', $val);
            $val = preg_replace('[\t]', '\u0445', $val); //u0445
            if($field_name == 'WAVELENGTH')
                $wavelength = $val;
            if ($field_name == 'ID_UPPER_LEVEL')
                $upper_level_id = $val;
            if ($field_name == 'ID_LOWER_LEVEL')
                $lower_level_id = $val;
            if ($field_name == 'ID')
                $transition_id = $val;
            if ($val == null || $val == "NULL")
                fwrite($file, '"' . $field_name . '": null');
            else
                fwrite($file, '"' . $field_name . '": "' . $val . '"');
            if ($counter != $fields_count - 1)
                fwrite($file, ", ");

            if ($counter == $fields_count - 1) {
                if ($lower_level_id == 'NULL')
                    print 'LOWER LEVEL IS NULL transition_id=' . $transition_id;
                else {
                    writeLevelValues($data, $lower_level_id, $file, $levels_fields, 'lower_level');
                }
                if ($upper_level_id == 'NULL')
                    print 'UPPER LEVEL IS NULL transition_id=' . $transition_id;
                else {
                    writeLevelValues($data, $upper_level_id, $file, $levels_fields, 'upper_level');
                }
            }
            $counter++;
        }
        $counter = 0;
        fwrite($file, ', "SOURCE_IDS": "null", ');
        $spectrum = new Spectrum();
        print '</br>'.$wavelength/10;
//        $rgb = $spectrum->wavelength2RGB($wavelength/10);
//        fwrite($file, ', "color": { "R" : "'.$rgb['R'].'", "G" : "'.$rgb['G'].'", "B" : "'.$rgb['B'].'" }');
        fwrite($file, '"color": '.json_encode($spectrum->wavelength2RGB($wavelength/10)).'');
        // fwrite($file,', "color":{"R":255,"G":255,"B":255}');
        fwrite($file, '}');
        if($elements_number >  1 && $element_number != $elements_number-1)
            fwrite($file, ',');
    }
    if($elements_number >  1)
        fwrite($file, ']');
}

//для массива вложенных элементов

function writeLevelValues($data, $id, $file, $fields, $type)
{
    $fields_count = count($fields);
    $elements_number = count($data['atom_system']['levels']);
    $wavelength = null;
    $counter = 0;
    //print '</br>' . $elements_number;
    $element_number = 0;
    for ($element_number; $element_number < $elements_number; $element_number++) {
        $val = $data['atom_system']['levels'][$element_number]['ID'];
        //print '</br>' . $val;
        if ($val == $id) {
            fwrite($file, ',');
            foreach ($fields as $field_name) {
                $val = $data['atom_system']['levels'][$element_number][$field_name];
                $val = addslashes($val);
                $val = str_replace(PHP_EOL, '</br>', $val);
                $val = str_replace(' ', '\u0020', $val);
                $val = preg_replace('[\t]', '\u0445', $val); //u0445
                //print '</br>' . $val;
                if ($type == 'upper_level')
                    $field_name = 'upper_level_' . strtolower($field_name);
                if ($type == 'lower_level')
                    $field_name = 'lower_level_' . strtolower($field_name);
                if ($val == null || $val == "NULL")
                    fwrite($file, '"' . $field_name . '": null');
                else
                    fwrite($file, '"' . $field_name . '": "' . $val . '"');
                if ($counter != $fields_count - 1)
                    fwrite($file, ", ");
                $counter++;
            }
            if($type == 'upper_level')
                fwrite($file, ', "upper_level_config_type": "np"');
            break;
        }
    }

}

function getFieldsValueUpperLevel($fileName, $fields, $type_name){
    $values = array();
    $data = file_get_contents($fileName);
    $data = json_decode($data, true);
    $ar_size = count($fields);
    $i = 0;
    for ($i; $i < $ar_size; $i++) {
        $val = $data['atom_system'][$type_name][$fields[$i]];
        if($type_name=='periodictable' and $fields[$i]=='ID')
            $fields[$i] = 'ELEMENT_ID';
        if($type_name=='periodictable' and $fields[$i]=='TYPE')
            $fields[$i] = 'ELEMENT_TYPE';
        $values[$fields[$i]] = $val;
        //print $fields[$i].' : '.$values[$fields[$i]].'</br>';
    }

//    foreach($values as $key => $value) {
//        echo  $key . " : " . $value.'</br>';
//    }

    return $values;
}

function getFieldsValue($dataFileName, $fields, $type_name, $fileToWrite){
    $values = array();
    $data = file_get_contents($dataFileName);
    $data = json_decode($data, true);
    $ar_size = count($fields);
    $i = 0;
    for ($i; $i < $ar_size; $i++) {
        $val = $data['atom_system'][$type_name][$fields[$i]];
        fwrite( $fileToWrite,'"' . $fields[$i] .'": "'.$val.'", ');
        if($type_name=='periodictable' && $fields[$i]=='ID')
            $fields[$i] = 'ELEMENT_ID';
        if($type_name=='periodictable' && $fields[$i]=='TYPE')
            $fields[$i] = 'ELEMENT_TYPE';
        print $fields[$i];
         $values[$fields[$i]] = $val;
        //print $fields[$i].' : '.$values[$fields[$i]].'</br>';
    }

    foreach($values as $key => $value) {
        echo  $key . " : " . $value.'</br>';
    }

    return $values;
}

function getAtomsValue($data, $fields, $fileToWrite){
    $ar_size = count($fields);
    $i = 0;
    for ($i; $i < $ar_size; $i++) {
        $val = $data['atom_system'][$fields[$i]];
        $val = addslashes($val);
        $val = str_replace(PHP_EOL, '</br>', $val);
        $val = str_replace(' ', '\u0020', $val);
        $val = preg_replace('[\t]', '\u0445', $val); //u0445
        fwrite( $fileToWrite,'"' . $fields[$i] .'": "'.$val.'"');
        if($i != $ar_size-1)
            fwrite($fileToWrite,  ", ");
    }

}