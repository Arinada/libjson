<?php
class Connection{
    public $link;
//    public $connection;
//
//    public function __construct() {
//        $connection = new Connection();
//    }

    public function OpenConnection() {
        $host = 'localhost'; // адрес сервера
        $database = 'grotrian_v2_dev'; // имя базы данных
        $user = 'root'; // имя пользователя
        $password = ''; // пароль
        // подключаемся к серверу
        $this->link = mysqli_connect($host, $user, $password, $database)
        or die("Ошибка " . mysqli_error($this->link));
        //mysqli_query($link,"SET NAMES 'utf8");
        //mysqli_query($link,"SET CHARACTER SET 'utf8'");
    }

}
?>