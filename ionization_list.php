<?php
    require_once("open_connection.php");

    $element_abbr = $_POST['element_abbr'];
    $res = mysqli_query($link, "SELECT distinct ionization FROM atoms inner join periodictable on atoms.id_element=periodictable.id where abbr=\"".$element_abbr."\" ORDER BY ionization")  or die("Ошибка " . mysqli_error($this->link));
    $maxn = $res->num_rows;
    $ionization_list = array();
    $r=mysqli_fetch_array($res);

    for($i=0;$i<$maxn;$i++)
    {
        $r=mysqli_fetch_array($res);
        $ionization_list[$i] = $r['ionization'];
    }
    require_once("close_connection.php");
    return $ionization_list;