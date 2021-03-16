<html> <head>
    <title> Страница для обмена данными </title>
</head> <body>

<form name="form" action="download_file.php" enctype="multipart/form-data" method="post">
    <input type="file" name="upload_file" title="Выберите файл"/> </br></br>
    <input type="submit" name="load_file" value = "Загрузить файл"/></br></br></br>

    <?php
        require_once("open_connection.php");
        $res = mysqli_query($link, "SELECT distinct abbr FROM PERIODICTABLE ORDER BY abbr")  or die("Ошибка " . mysqli_error($this->link));

        $maxn = $res->num_rows;
        print "<select name=\"elements\" id='elements'>";
        print "<option>"."Choose element:"."</option>";
        $r=mysqli_fetch_array($res);
        for($i=0;$i<$maxn;$i++)
        {
            $r=mysqli_fetch_array($res);
            print "<option>".$r['abbr']."</option>";
        }
        require_once("close_connection.php");
        print "</select></br></br>";

        print "<select name=\"ionization\" id='ionization'>";
        print "<option>"."Choose ionization:"."</option>";
        print "</select></br></br>";

        print "<select name=\"ionization_potential\">";
        print "<option>"."Choose ionization potencial:"."</option>";
        print "</select></br></br>";

        require_once("close_connection.php");
        print "</select>";
    ?>
    <input type="submit" name="download_file" value = "Cкачать файл" /></br></br></br>
    <input type="submit" name="show_kvantofram" value = "Показать квантограмму" /></br></br></br>
</form>
<script src="js/data_exchange_page.js"></script>
</body> </html>