<?
    //require_once("open_connection.php");
   // require_once ("close_connection.php");
    require_once ("initialize_smarty.php");
    require_once 'load_data_from_file.php';
    require_once('get_file_with_one_atom_system_data.php');
   // $connection= new Connection();

    if(isset($_POST['show_kvantogram']) && isset($_POST['elements']) && isset($_POST['ionization']) && isset($_POST['ionization_potencial'])) {
        createFileWithData();
        require_once 'cf.php';
        deleteFile();
    }

    if(isset($_POST['levels_table']) && isset($_POST['elements']) && isset($_POST['ionization']) && isset($_POST['ionization_potencial'])) {
        createFileWithData();
        require_once 'levels_table.php';
        deleteFile();
    }

    if(isset($_POST['transitions_table']) && isset($_POST['elements']) && isset($_POST['ionization']) && isset($_POST['ionization_potencial'])) {
        createFileWithData();
        require_once 'transitions_table.php';
        deleteFile();
    }

    if(isset($_POST['download_file']) && isset($_POST['elements']) && isset($_POST['ionization']) && isset($_POST['ionization_potencial']))
    {
        createFileWithData();
        $fileName = $_POST['elements'].'_'.$_POST['ionization'].'.json';
        $filePath = '/uploads/'.$fileName;
        if (file_exists($filePath)) {
            $content = file_get_contents($filePath);
            isJson($content);
            $ctype = 'application/json';
            header('Content-Type: '.$ctype.'; charset=utf-8');
            header("Content-Disposition: attachment; filename=".$fileName);
            ob_clean();
            readfile($filePath);
            unlink($filePath);
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
                $load= new LoadData();
                $load->LoadDataForOneAtomSystem($fileFullName);
                echo "Загруженный файл: " . $fileName . "</br>";
                echo "Размер: " . $fileSize . "байт";
            } else {
                echo 'Возникла ошибка при загрузке файла';
            }
        } else {
            echo 'Некорректный формат файла';
        }
    }

    function deleteFile(){
        unlink('/uploads/'.$_POST['elements'].'_'.$_POST['ionization'].'.json');
    }

     function isJson($data){
        $data = json_decode($data, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            switch (json_last_error()) {
                case JSON_ERROR_DEPTH:
                    echo ' - Достигнута максимальная глубина стека';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    echo ' - Некорректные разряды или несоответствие режимов';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    echo ' - Некорректный управляющий символ';
                    break;
                case JSON_ERROR_SYNTAX:
                    echo ' - Синтаксическая ошибка, некорректный JSON';
                    break;
                case JSON_ERROR_UTF8:
                    echo ' - Некорректные символы UTF-8, возможно неверно закодирован';
                    break;
                default:
                    echo ' - Неизвестная ошибка';
                    break;
            }
            die('. Incorrect json format');
        }
    }

?>
