<?php
    require_once("open_connection.php");

    $element_abbr = $_GET['element_abbr'];
    $ionization = $_GET['ionization'];
    //print 'ion'.$ionization;'
    $res = mysqli_query($link, "SELECT ionization_potencial FROM atoms inner join periodictable on atoms.id_element=periodictable.id where abbr=\"".$element_abbr."\" and ionization=\"".$ionization."\" ORDER BY ionization_potencial")  or die("Ошибка " . mysqli_error($this->link));
    $maxn = $res->num_rows;
    $ionization_list = array();

    for($i=0;$i<$maxn;$i++)
    {
        $r=mysqli_fetch_array($res);
        $ionization_list[$i] = $r['ionization_potencial'];
    }
    require_once("close_connection.php");
    echo json_encode($ionization_list);
