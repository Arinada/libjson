<?php

    require_once("atoms_data.php");
    $filename = '/uploads/data.json';
    $atomsData = new AtomData($filename, "H", '0', '109678.7',  $link);

    $atomsData->StartWrite();
    $atomsData->GetDataAboutAtomSystem();
    $atomsData->GetDataAboutPeriodicTable();
    $atomsData->GetDataAboutLevels();
    $atomsData->GetDataAboutTransitions();
    $atomsData->GetDataAboutInterfaceContent();
    $atomsData->EndWrite();

