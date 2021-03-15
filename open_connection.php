<?php
    $host = 'localhost'; // адрес сервера
    $database = 'grotrian_v2_dev'; // имя базы данных
    $user = 'root'; // имя пользователя
    $password = ''; // пароль
    // подключаемся к серверу
    $link = mysqli_connect($host, $user, $password, $database)
    or die("Ошибка " . mysqli_error($link));
    //mysqli_query($link,"SET NAMES 'utf8");
    //mysqli_query($link,"SET CHARACTER SET 'utf8'");
?>