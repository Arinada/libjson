<?php
    require_once("open_connection.php");

    $element_abbr = $_GET['element_abbr'];
    $res = mysqli_query($link, "SELECT distinct ionization FROM ATOMS inner join PERIODICTABLE on ATOMS.id_element=PERIODICTABLE.id where abbr=\"".$element_abbr."\" ORDER BY ionization")  or die("Ошибка " . mysqli_error($this->link));
    $maxn = $res->num_rows;
    $ionization_list = array();

    for($i=0;$i<$maxn;$i++)
    {
        $r=mysqli_fetch_array($res);
        $ionization_list[$i] = $r['ionization'];
        //echo $r['ionization'];
    }

    require_once("close_connection.php");
    echo json_encode($ionization_list);
