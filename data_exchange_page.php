<html> <head>
    <title> Страница для обмена данными </title>
</head> <body>

<form name="form" action="data_exchange_page_logic.php" enctype="multipart/form-data" method="post">
    <input type="file" name="upload_file" title="Выберите файл"/> </br></br>
    <input type="submit" name="load_file" value = "Загрузить файл"/></br></br></br>

    <?php
        require_once("open_connection.php");
        require_once("close_connection.php");
        $conn = new Connection();
        $conn->OpenConnection();
        $res = mysqli_query($conn->link, "SELECT distinct abbr FROM PERIODICTABLE ORDER BY abbr")  or die("Ошибка " . mysqli_error($conn->link));

        $maxn = $res->num_rows;
        print "<select name='elements' id='elements'>";
        print "<option>"."Choose element:"."</option>";
        $r=mysqli_fetch_array($res);
        for($i=0;$i<$maxn;$i++)
        {
            $r=mysqli_fetch_array($res);
            print "<option>".$r['abbr']."</option>";
        }
        close_connection($conn->link);
        print "</select></br></br>";

        print "<select name=\"ionization\" id='ionization'>";
        print "<option>"."Choose ionization:"."</option>";
        print "</select></br></br>";

        print "<select name=\"ionization_potencial\" id=\"ionization_potencial\">";
        print "<option>"."Choose ionization potencial:"."</option>";
        print "</select></br></br>";
    ?>
    <input type="submit" name="download_file" value = "Cкачать файл" /></br></br></br>
    <input type="submit" name="show_kvantogram" value = "Показать квантограмму" /></br></br>
    <input type="submit" name="levels_table" value = " Показать таблицу уровней " /></br></br>
    <input type="submit" name="transitions_table" value = "Показать таблицу переходов" /></br></br>
</form>
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/data_exchange_page.js"></script>
</body> </html>