<?php
    require_once("atoms_data.php");
    function createFileWithData()
    {
        $el_abbr = $_POST['elements'];
        $ionization = $_POST['ionization'];
        $filename = '/uploads/' . $el_abbr . '_' . $ionization . '.json';
        $atomsData = new AtomData($filename, $el_abbr, $ionization, $_POST['ionization_potencial']);

        $atomsData->StartWrite();
        $atomsData->WriteMetaData();
        $atomsData->GetDataAboutAtomSystem();
        $atomsData->GetDataAboutPeriodicTable();
        $atomsData->GetDataAboutLevels();
        $atomsData->GetDataAboutTransitions();
        $atomsData->GetDataAboutInterfaceContent();
        $atomsData->EndWrite();
    }

