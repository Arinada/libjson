<?php
require_once 'spectrum.php';

class ParseDataForModules
{
    //$query = "SELECT SPECTRUM_IMG, MASS_NUMBER, IONIZATION,Z,ATOM_MASS,IONIZATION_POTENCIAL,
    //ENERGY_DIMENSION,ABBR,TABLEPERIOD,TABLEGROUP,NAME_EN,NAME_RU,NAME_RU_ALT,PERIODICTABLE.[TYPE] AS ELEMENT_TYPE,
    //PERIODICTABLE.ID AS ELEMENT_ID, INTERFACE_CONTENT.* FROM  ATOMS,PERIODICTABLE,INTERFACE_CONTENT WHERE
    // ATOMS.ID='$element_id' AND ATOMS.ID_ELEMENT = PERIODICTABLE.ID AND INTERFACE_CONTENT.ID=ATOMS.DESCRIPTION";
    //function get_atoms
    private $data;
    //transitions
    //$query = "SELECT TRANSITIONS.*,lower_level.ID AS lower_level_id,lower_level.energy AS lower_level_energy,lower_level.termmultiply AS lower_level_termmultiply, lower_level.CONFIG AS lower_level_config,lower_level.J AS lower_level_j,lower_level.TERMPREFIX AS lower_level_termprefix,lower_level.TERMMULTIPLY AS lower_level_termmultiply,lower_level.TERMFIRSTPART AS lower_level_termfirstpart,lower_level.TERMSECONDPART AS lower_level_termsecondpart,
    //upper_level.ID AS upper_level_id,upper_level.energy AS upper_level_energy, upper_level.termmultiply as upper_level_termmultiply, upper_level.CONFIG AS upper_level_config,upper_level.J AS upper_level_j,upper_level.TERMPREFIX AS upper_level_termprefix,upper_level.TERMMULTIPLY AS upper_level_termmultiply,upper_level.TERMFIRSTPART AS upper_level_termfirstpart,upper_level.TERMSECONDPART AS upper_level_termsecondpart,
    //[dbo].GetCfgType(upper_level.CONFIG) AS upper_level_config_type, dbo.ConcatSourcesID(TRANSITIONS.ID,'T') AS SOURCE_IDS
    //FROM TRANSITIONS LEFT JOIN LEVELS AS lower_level ON TRANSITIONS.ID_LOWER_LEVEL=lower_level.ID LEFT JOIN LEVELS AS upper_level ON TRANSITIONS.ID_UPPER_LEVEL=upper_level.ID
    //WHERE TRANSITIONS.ID_ATOM='$element_id' ORDER BY WAVELENGTH";

    function __construct() {
       // $dataFileName = '/uploads/data.json';
        $dataFileName = '/uploads/'.$_POST['elements'].'_'.$_POST['ionization'].'.json';
        $this->data = file_get_contents($dataFileName);
        $this->data = json_decode($this->data, true);
        if (json_last_error() !== JSON_ERROR_NONE)
            die('Incorrect json format');
    }

    //для одного элемента (без вложенных элементов)
    public function WriteDataForOneElement($type_name, $fields, $file)
    {
        //open file
        //get data and write
        $fields_count = count($fields);
        $counter = 0;
        foreach ($fields as $field_name) {
            $val = $this->data['atom_system'][$type_name][$field_name];
            $val = addslashes($val);
            $val = str_replace(PHP_EOL, '</br>', $val);
            $val = str_replace(' ', '\u0020', $val);
            $val = preg_replace('[\t]', '\u0445', $val); //u0445
            if ($type_name == 'periodictable' && $field_name == 'ID')
                $field_name = 'ELEMENT_ID';
            if ($type_name == 'periodictable' && $field_name == 'TYPE')
                $field_name = 'ELEMENT_TYPE';
            if ($val == null || $val == "NULL")
                fwrite($file, '"' . $field_name . '": "NULL"');
            else
                fwrite($file, '"' . $field_name . '": "' . $val . '"');
            if ($counter != $fields_count - 1)
                fwrite($file, ", ");
            $counter++;
        }
    }

    public function WriteDataAboutLevels($fields, $file)
    {
        $fields_count = count($fields);
        $elements_number = count($this->data['atom_system']['levels']);
        $config = null;
        $counter = 0;
        //print $fields_count;
        if ($elements_number > 1)
            fwrite($file, '[');
        for ($element_number = 0; $element_number < $elements_number; $element_number++) {
            fwrite($file, '{');
            foreach ($fields as $field_name) {
                $val = $this->data['atom_system']['levels'][$element_number][$field_name];
                $val = addslashes($val);
                $val = str_replace(PHP_EOL, '</br>', $val);
                $val = str_replace(' ', '\u0020', $val);
                $val = preg_replace('[\t]', '\u0445', $val); //u0445
                $val = preg_replace('[\n]', '</br>', $val);
                if ($field_name == 'CONFIG')
                    $config = $val;
                if ($val == null || $val == "NULL")
                    fwrite($file, '"' . $field_name . '": null');
                else
                    fwrite($file, '"' . $field_name . '": "' . $val . '"');
                if ($counter != $fields_count - 1)
                    fwrite($file, ", ");
                $counter++;
            }
            $counter = 0;
            $config_type = $this->GetConfigType($config);
            fwrite($file, ', "SOURCE_IDS": null,"config_type": "' . $config_type . '" ');
            fwrite($file, '}');
            if ($elements_number > 1 && $element_number != $elements_number - 1)
                fwrite($file, ',');
        }
        if ($elements_number > 1)
            fwrite($file, ']');
    }

    //для массива вложенных элементов
    public function WriteLevelValues($id, $file, $fields, $type)
    {
        $fields_count = count($fields);
        $elements_number = count($this->data['atom_system']['levels']);
        $config = null;
        $counter = 0;
        //print '</br>' . $elements_number;
        $element_number = 0;
        for ($element_number; $element_number < $elements_number; $element_number++) {
            $val = $this->data['atom_system']['levels'][$element_number]['ID'];
            //print '</br>' . $val;
            if ($val == $id) {
                fwrite($file, ',');
                foreach ($fields as $field_name) {
                    $val = $this->data['atom_system']['levels'][$element_number][$field_name];
                    $val = addslashes($val);
                    $val = str_replace(PHP_EOL, '</br>', $val);
                    $val = str_replace(' ', '\u0020', $val);
                    $val = preg_replace('[\t]', '\u0445', $val); //u0445
                    $val = preg_replace('[\n]', '</br>', $val);
                    //print '</br>' . $val;
                    if ($field_name == 'CONFIG')
                        $config = $val;
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
                if ($type == 'upper_level') {
                    $config_type = $this->GetConfigType($config);
                    fwrite($file, ', "upper_level_config_type": "' . $config_type . '" ');
                }
                break;
            }
        }

    }

    public function WriteDataAboutTransitionsWithLevels($fields, $file, $levels_fields)
    {
        $fields_count = count($fields);
        $elements_number = count($this->data['atom_system']['transitions']);
        $lower_level_id = 0;
        $upper_level_id = 0;
        $transition_id = 0;
        $wavelength = 0;
        $counter = 0;
        //print $fields_count;
        if ($elements_number > 1)
            fwrite($file, '[');
        for ($element_number = 0; $element_number < $elements_number; $element_number++) {
            fwrite($file, '{');
            foreach ($fields as $field_name) {
                $val = $this->data['atom_system']['transitions'][$element_number][$field_name];
                $val = addslashes($val);
                $val = str_replace(PHP_EOL, '</br>', $val);
                $val = str_replace(' ', '\u0020', $val);
                $val = preg_replace('[\t]', '\u0445', $val); //u0445
                $val = preg_replace('[\n]', '</br>', $val);
                if ($field_name == 'WAVELENGTH')
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
//                    if ($lower_level_id == 'NULL')
//                        print 'LOWER LEVEL IS NULL transition_id=' . $transition_id;
//                    else {
                    if($lower_level_id != 'NULL'){
                        $this->WriteLevelValues($lower_level_id, $file, $levels_fields, 'lower_level');
                    }
//                    if ($upper_level_id == 'NULL')
//                        print 'UPPER LEVEL IS NULL transition_id=' . $transition_id;
//                    else {
                    if($upper_level_id != 'NULL'){
                        $this->WriteLevelValues($upper_level_id, $file, $levels_fields, 'upper_level');
                    }
                }
                $counter++;
            }
            $counter = 0;
            fwrite($file, ', "SOURCE_IDS": "null", ');
            $spectrum = new Spectrum();
          //  print '</br>' . $wavelength / 10;
//        $rgb = $spectrum->wavelength2RGB($wavelength/10);
//        fwrite($file, ', "color": { "R" : "'.$rgb['R'].'", "G" : "'.$rgb['G'].'", "B" : "'.$rgb['B'].'" }');
            fwrite($file, '"color": ' . json_encode($spectrum->wavelength2RGB($wavelength / 10)) . '');
            // fwrite($file,', "color":{"R":255,"G":255,"B":255}');
            fwrite($file, '}');
            if ($elements_number > 1 && $element_number != $elements_number - 1)
                fwrite($file, ',');
        }
        if ($elements_number > 1)
            fwrite($file, ']');
    }

    private function GetFieldsValueUpperLevel($fileName, $fields, $type_name)
    {
        $values = array();
        $ar_size = count($fields);
        $i = 0;
        for ($i; $i < $ar_size; $i++) {
            $val = $this->data['atom_system'][$type_name][$fields[$i]];
            if ($type_name == 'periodictable' and $fields[$i] == 'ID')
                $fields[$i] = 'ELEMENT_ID';
            if ($type_name == 'periodictable' and $fields[$i] == 'TYPE')
                $fields[$i] = 'ELEMENT_TYPE';
            $values[$fields[$i]] = $val;
            //print $fields[$i].' : '.$values[$fields[$i]].'</br>';
        }

//    foreach($values as $key => $value) {
//        echo  $key . " : " . $value.'</br>';
//    }
        return $values;
    }

    private function GetFieldsValue($dataFileName, $fields, $type_name, $fileToWrite)
    {
        $values = array();
        $ar_size = count($fields);
        $i = 0;
        for ($i; $i < $ar_size; $i++) {
            $val = $this->data['atom_system'][$type_name][$fields[$i]];
            fwrite($fileToWrite, '"' . $fields[$i] . '": "' . $val . '", ');
            if ($type_name == 'periodictable' && $fields[$i] == 'ID')
                $fields[$i] = 'ELEMENT_ID';
            if ($type_name == 'periodictable' && $fields[$i] == 'TYPE')
                $fields[$i] = 'ELEMENT_TYPE';
          //  print $fields[$i];
            $values[$fields[$i]] = $val;
            //print $fields[$i].' : '.$values[$fields[$i]].'</br>';
        }

//        foreach ($values as $key => $value) {
//            echo $key . " : " . $value . '</br>';
//        }

        return $values;
    }

    public function GetConfigType($config)
    {
//        $items = $this->GetItemsArray();
        $config_type = null;
        if ($config == "(?)") $config = "?";

        //убираем с конца конфигурации, j и терма незначащие символы, такие как '?', ', "
        $config = preg_replace('/^(.*?)([^a-zA-Z\}\)]*)$/', '$1', $config);

        //убираем ~{...} c конца конфигурации
        $config = preg_replace('/^(.*)(~\{[^\{\}]*\})$/', '$1', $config);
        //убираем последнюю букву из конфигурации, если их там две
        $config = preg_replace('/^(.*[a-zA-Z])[a-zA-Z]$/', '$1', $config);

        //если заканчивается на @{число}, то в CELLCONFIG копируем CONFIG %@{%}
        //если не заканчивается на @{число}, то в CELLCONFIG заносим CONFIG с заменой последнего числа на 'n'
        $config_type = $config;

        if (!preg_match('/^(.*@\{.*\})$/', $config)) {
            if (preg_match('/^(.*?)(\d+)([a-z])$/', $config))
                $config_type = preg_replace('/^(.*?)(\d+)([a-z])$/', '$1n$3', $config);
        }
        if ($config == null || $config == '')
            $config_type = $config = '?';
        return $config_type;
    }

    public function WriteAtomsValue($fields, $fileToWrite)
    {
        $ar_size = count($fields);
        $i = 0;
        for ($i; $i < $ar_size; $i++) {
            $val = $this->data['atom_system'][$fields[$i]];
            $val = addslashes($val);
            $val = str_replace(PHP_EOL, '</br>', $val);
            $val = str_replace(' ', '\u0020', $val);
            $val = preg_replace('[\t]', '\u0445', $val); //u0445
            fwrite($fileToWrite, '"' . $fields[$i] . '": "' . $val . '"');
            if ($i != $ar_size - 1)
                fwrite($fileToWrite, ", ");
        }

    }
}