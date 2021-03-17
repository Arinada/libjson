<?php
    require_once("open_connection.php");
    print "<option>".'Elements:'."</option>";
    $res = mysqli_query($link, "SELECT distinct abbr FROM PERIODICTABLE ORDER BY abbr")  or die("Ошибка " . mysqli_error($this->link));

    $maxn = $res->num_rows;
    print "<select name='elements' id=\"univer\">";
    print "<option>"."Выберите элемент:"."</option>";
    $r=mysqli_fetch_array($res);
    for($i=0;$i<$maxn;$i++)
    {
        $r=mysqli_fetch_array($res);
        print "<option>".$r['abbr']."</option>";
    }
    print "</select><br>";
    require_once("close_connection.php");
?>