<?php
    require_once("open_connection.php");
    require_once("atoms_data.php");
    $atomsData = new AtomData();
    $res = $atomsData->getAtomSystemId("H", '0', '109678.7',  $link);
    while($row = mysqli_fetch_assoc($res))
    {
        echo " ID ".$row['id'].', ELEMENT_ID '.$row['id_element'];
        $atom_sys_id = $row['id'];
        $element_id = $row['id_element'];
    }

    $filename = '/uploads/data.json';
    // Открываем файл, флаг W означает - файл открыт на запись
     $file = fopen($filename, 'wb');
    fwrite($file, '{');
    $result = $atomsData->GetDataAboutAtomSystem($atom_sys_id, $link);
    $atomsData->writeDataInFile($file, $result); //write data about atom system
    fwrite($file,  ', "periodictable": {');
    $result = $atomsData->GetDataAboutPeriodicTable($element_id, $link);
    $atomsData->writeDataInFile($file, $result); //write data about atom system
    fwrite($file, '} ');
    //about levels
    fwrite($file,  ', "levels": [');
    fwrite($file, '] ');
    fwrite($file, '}');
    require_once ('close_connection.php');
    // Записываем в файл $text
    //fwrite($f_hdl, $text);
    // Закрывает открытый файл
    fclose($file);