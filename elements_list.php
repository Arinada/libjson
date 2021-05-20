<?php
    $connection = new Connection();
    $connection->OpenConnection();

    print "<option>".'Elements:'."</option>";
    $res = mysqli_query($connection->link, "SELECT distinct abbr FROM PERIODICTABLE ORDER BY abbr")  or die("Ошибка " . mysqli_error($connection->link));

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
    close_connection($connection->link);
?>