<?php

    require_once("atoms_data.php");
    $filename = '/uploads/data.json';
    //print $_GET['el_abbr'];
    $atomsData = new AtomData($filename, $_POST['elements'], $_POST['ionization'], $_POST['ionization_potencial'],  $link);

    $atomsData->StartWrite();
    $atomsData->GetDataAboutAtomSystem();
    $atomsData->GetDataAboutPeriodicTable();
    $atomsData->GetDataAboutLevels();
    $atomsData->GetDataAboutTransitions();
    $atomsData->GetDataAboutInterfaceContent();
    $atomsData->EndWrite();

