<?php
require_once 'parse_data_for_modules.php';

class GetDataForModules{
    private $atoms_fields = array('MASS_NUMBER', 'IONIZATION', 'LIMITS', 'BREAKS', 'IONIZATION_POTENCIAL', 'ENERGY_DIMENSION');
    private $periodictable_fields = array('ID', 'ABBR', 'TABLEPERIOD', 'TABLEGROUP', 'NAME_EN', 'NAME_RU', 'NAME_RU_ALT', 'TYPE', 'Z', 'ATOM_MASS'); //all fields
    private $levels_fields = array('ID', 'ENERGY', 'TERMMULTIPLY', 'CONFIG', 'J', 'TERMPREFIX', 'TERMFIRSTPART', 'TERMSECONDPART');
    private $all_transitions_fields = array();
    private $all_levels_fields = array();
    private $data, $parse_data_for_modules;

    function __construct() {
        $conn = new Connection();
        $conn->OpenConnection();
        $link = $conn->link;
        $load = new LoadData();
        $this->all_interface_content_fields = $load->GetFields('INTERFACE_CONTENT', $link);
        $this->all_transitions_fields = $load->GetFields('TRANSITIONS', $link);
        $this->all_levels_fields = $load->GetFields('LEVELS', $link);
        close_connection($link);
        $this->parse_data_for_modules = new ParseDataForModules();
    }

    public function GetDataAboutAtoms(){
        $this->GetAtomsDataFile();
        return file_get_contents('Z:\uploads\atoms.json');
    }

    public function GetDataAboutLevels(){
        $this->GetLevelsDataFile();
        return file_get_contents('Z:\uploads\levels.json');
    }

    public function GetDataAboutTransitionsWithLevels(){
        $this->GetTransitionsWithLevelsDataFile();
        return file_get_contents('Z:\uploads\transitions.json');
    }
    //atoms.json
    public function GetAtomsDataFile()
    {
        $fileToWrite = fopen('/uploads/atoms.json', 'wb');
        fwrite($fileToWrite, '{');
        $this->parse_data_for_modules->WriteAtomsValue($this->atoms_fields, $fileToWrite);
        fwrite($fileToWrite, ", ");
        $this->parse_data_for_modules->WriteDataForOneElement('periodictable', $this->periodictable_fields, $fileToWrite);
        fwrite($fileToWrite, ", ");
        $this->parse_data_for_modules->WriteDataForOneElement('interface_content', $this->all_interface_content_fields, $fileToWrite);
        fwrite($fileToWrite, '}');
        fclose($fileToWrite);
    }

    //transitions.json
    public function GetTransitionsWithLevelsDataFile()
    {
        $fileToWriteTransitions = fopen('/uploads/transitions.json', 'wb');
        $this->parse_data_for_modules->WriteDataAboutTransitionsWithLevels($this->all_transitions_fields, $fileToWriteTransitions, $this->levels_fields);
        fclose($fileToWriteTransitions);
    }

    //levels.json
    public function GetLevelsDataFile()
    {
        //$query = "SELECT LEVELS.* , dbo.ConcatSourcesID(ID,'L') AS SOURCE_IDS FROM LEVELS WHERE  ID_ATOM='$element_id' ORDER BY ENERGY asc";
        $fileToWriteLevels = fopen('/uploads/levels.json', 'wb');
        $this->parse_data_for_modules->WriteDataAboutLevels($this->all_levels_fields, $fileToWriteLevels);
        fclose($fileToWriteLevels);
    }

}