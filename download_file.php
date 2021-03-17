<?php

    if(isset($_POST['show_kvantogram'])) {
        require_once 'cf.php';
    }

    if(isset($_POST['download_file']) && isset($_POST['elements']) && isset($_POST['ionization']) && isset($_POST['ionization_potencial']))
    {
        require_once ('take_file_with_one_atom_system_data.php');
        $fileName = '/uploads/data.json';
        if (file_exists($fileName)) {
            $content = file_get_contents($fileName);
            $ctype = 'application/json';
            header('Content-Type: '.$ctype.'; charset=utf-8');
            header("Content-Disposition: attachment; filename=data.json");
            ob_clean();
            readfile($fileName);
            exit();
        } else {
            echo "Файл не найден.";
            exit();
        }
    }

    if (isset($_POST['load_file']) && isset($_FILES['upload_file']) && $_FILES['upload_file']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['upload_file']['name'];
        $fileFullName = '/uploads/' . $_FILES['upload_file']['name'];
        $fileSize = $_FILES['upload_file']['size'];
        $fileTmpPath = $_FILES['upload_file']['tmp_name'];
        $fileNameCmps = explode(".", $fileFullName);
        $fileExtension = strtolower(end($fileNameCmps));
        if ($fileExtension == "json") {
            //проверка на валидность json файла
            if (move_uploaded_file($fileTmpPath, $fileFullName)) {
                echo "Загруженный файл: " . $fileName . "</br>";
                echo "Размер: " . $fileSize . "байт";
            } else {
                echo 'Возникла ошибка при загрузке файла';
            }
        } else {
            echo 'Некорректный формат файла';
        }
    }

?>
