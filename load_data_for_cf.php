<?php
//$query = "SELECT SPECTRUM_IMG, MASS_NUMBER, IONIZATION,Z,ATOM_MASS,IONIZATION_POTENCIAL,
//ENERGY_DIMENSION,ABBR,TABLEPERIOD,TABLEGROUP,NAME_EN,NAME_RU,NAME_RU_ALT,PERIODICTABLE.[TYPE] AS ELEMENT_TYPE,
//PERIODICTABLE.ID AS ELEMENT_ID, INTERFACE_CONTENT.* FROM  ATOMS,PERIODICTABLE,INTERFACE_CONTENT WHERE
// ATOMS.ID='$element_id' AND ATOMS.ID_ELEMENT = PERIODICTABLE.ID AND INTERFACE_CONTENT.ID=ATOMS.DESCRIPTION";
//function get_atoms
$atoms_fields = array('MASS_NUMBER', 'IONIZATION' , 'LIMITS', 'BREAKS', 'IONIZATION_POTENCIAL', 'ENERGY_DIMENSION');
$periodictable_fields = array('ID', 'ABBR', 'TABLEPERIOD', 'TABLEGROUP', 'NAME_EN', 'NAME_RU', 'NAME_RU_ALT', 'TYPE', 'Z','ATOM_MASS'); //all fields
$fileName = '/uploads/data.json';
$ar_periodictable = getAtomsValue($fileName, $atoms_fields);
$ar_atoms = getDataAboutAtoms($atoms_fields, $periodictable_fields, $fileName);
//$atom_sys = array_merge($ar_atoms, $ar_periodictable);
//unset($atom_sys['SPECTRUM_IMG']);
//foreach (array_keys($atom_sys) as $key) {
//    $atom_sys[$key] = iconv("Windows-1251", "UTF-8", $atom_sys[$key]);
//}

require_once 'initialize_smarty.php';
$smarty->assign('atom_json', json_encode($atom_sys, 256));

$atom_sys = file_get_contents('Z:\uploads\atoms.json');
$smarty->assign('atom_json', $atom_sys);
$transitions = file_get_contents('Z:\uploads\transitions.json');
$smarty->assign('transitions_json',$transitions);

$levels = file_get_contents('Z:\uploads\levels.json');
$smarty->assign('levels_json',$levels);

$smarty->display('view_cf.tpl');


function getDataAboutAtoms($atoms_fields, $periodictable_fields, $fileName){
        getFieldsValue($fileName, $periodictable_fields, 'periodictable');

}


function getFieldsValue($fileName, $fields, $type_name){
    $values = array();
    $data = file_get_contents($fileName);
    $data = json_decode($data, true);
    $ar_size = count($fields);
    $i = 0;
    for ($i; $i < $ar_size; $i++) {
        $val = $data['atom_system'][$type_name][$fields[$i]];
        $values[$fields[$i]] = $val;
        //print $fields[$i].' : '.$values[$fields[$i]].'</br>';
    }

    foreach($values as $key => $value) {
        echo  $key . " : " . $value.'</br>';
    }

    return $values;
}

function getAtomsValue($fileName, $fields){
    $values = array();
    $data = file_get_contents($fileName);
    $data = json_decode($data, true);
    $ar_size = count($fields);
    $i = 0;
    for ($i; $i < $ar_size; $i++) {
        $val = $data['atom_system'][$fields[$i]];
        $values[$i] = $val;
        //print $fields[$i].' : '.$values[$i].'</br>';
    }

    foreach($values as $key => $value) {
        echo  $key . " : " . $value.'</br>';
    }

    return $values;
}