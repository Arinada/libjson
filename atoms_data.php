<?php
class AtomData
{
    private $atom_sys_id, $element_id, $filename, $link, $file;

    function __construct($filename, $element_abbr, $ionization, $ionization_potential, $link) {
      require_once("open_connection.php");
      $this->filename = $filename;
      $this->link = $link;
      $this->getAtomSystemIds($element_abbr, $ionization, $ionization_potential);
    }

    function StartWrite() {
        $this->file = fopen($this->filename, 'wb');
        fwrite($this->file, '{');
    }

    function EndWrite() {
        fwrite($this->file, '}');
        fclose($this->file);
        mysqli_close($this->link);
    }

    function GetData()
    {
        $query ="SELECT * FROM atoms where id=1";
        $result = mysqli_query($this->link, $query) or die("Ошибка " . mysqli_error($this->link));
        if($result)
        {
           // echo "Выполнение запроса прошло успешно";
        }
        $this->writeDataInFile($result);
    }

    function writeDataInFileOneRow($result)
    {
        $fields_count = $result->field_count;
        $counter = 0;
        while ($row  = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            foreach ($row as $key => $val) {
                $val = addslashes($val);
                //$val = preg_replace("\n", "\\n", $val);
                //$val = preg_replace("\n", "\r\n", $val);
                if( $val == NULL )
                    fwrite( $this->file,'"' . $key . '": "NULL"');
                else
                    fwrite( $this->file,'"' . $key . '": "' . $val . '"');
                if($counter != $fields_count-1)
                    fwrite($this->file,  ", ");
                $counter++;
            }
        }
    }

    function writeDataInFileManyRows($result)
    {
        $fields_count = $result->field_count;
        $rows_number = $result->num_rows;
        //echo $rows_number;
        $counter_fields = 0;
        $counter_rows = 0;
        while ($row  = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            fwrite($this->file,  "{");
            foreach ($row as $key => $val) {
              //  $val = JSON.stringify(addslashes($val));
                if( $val == null )
                    fwrite( $this->file,'"' . $key . '": "NULL"');
                else
                fwrite( $this->file,'"' . $key . '": "' . $val . '"');
                if($counter_fields != $fields_count-1)
                    fwrite($this->file,  ", ");
                $counter_fields++;
            }
            $counter_fields = 0;
            fwrite($this->file,  "}");
            if($counter_rows != $rows_number-1)
                fwrite($this->file,  ", ");
            $counter_rows++;
        }
    }

    private function GetAtomSystemIds($element_abbr, $ionization, $ionization_potencial){
        $query = 'Select distinct ATOMS.id, id_element from PERIODICTABLE Inner join ATOMS on PERIODICTABLE.id=ATOMS.ID_ELEMENT AND abbr="'.$element_abbr.'"'.
                    ' AND ionization="'.$ionization.'"'.' AND ionization_potencial="'.$ionization_potencial.'"';
        //print $query.'               ';
        $result = mysqli_query($this->link, $query) or die("Ошибка " . mysqli_error($this->link));
//        if($result)
//        {
//          //  echo "Выполнение запроса прошло успешно";
//        }

        while($row = mysqli_fetch_assoc($result))
        {
            //echo " ID ".$row['id'].', ELEMENT_ID '.$row['id_element'];
            $this->atom_sys_id = $row['id'];
            $this->element_id = $row['id_element'];
        }
    }

    function GetDataAboutAtomSystem(){
        $query = 'SELECT * FROM ATOMS WHERE id="'.$this->atom_sys_id.'"';
        $result = mysqli_query($this->link, $query) or die("Ошибка " . mysqli_error($this->link));

//        if($result)
//          //  echo "Выполнение запроса прошло успешно (atoms) \n";
//        else die("Ошибка привыполнении запроса");

        $this->writeDataInFileOneRow($result);
        return $result;
    }

    function GetDataAboutPeriodicTable(){
        $query = 'SELECT * FROM PERIODICTABLE WHERE id="'.$this->element_id.'"';
        $result = mysqli_query($this->link, $query) or die("Ошибка " . mysqli_error($this->link));

//        if($result)
//          //  echo "Выполнение запроса прошло успешно (periodictable) \n";
//        else die("Ошибка привыполнении запроса");

        fwrite($this->file,  ', "periodictable": {');
        $this->writeDataInFileOneRow($result);
        fwrite($this->file, '} ');
    }

    function GetDataAboutLevels()
    {
        $query = 'SELECT * FROM LEVELS WHERE id_atom="' . $this->atom_sys_id . '"';
        $result = mysqli_query($this->link, $query) or die("Ошибка " . mysqli_error($this->link));

//        if ($result)
//          //  echo "Выполнение запроса прошло успешно (levels)";
//        else die("Ошибка привыполнении запроса");

        if ($result->num_rows == 1){
            fwrite($this->file, ', "levels": {');
            $this->writeDataInFileOneRow($result);
            fwrite($this->file, '} ');
        }
        else {
            fwrite($this->file,  ', "levels": [');
            $this->writeDataInFileManyRows($result);
            fwrite($this->file, '] ');
        }
    }

    function GetDataAboutTransitions(){
        $query = 'SELECT * FROM TRANSITIONS WHERE id_atom="'.$this->atom_sys_id.'"';
        $result = mysqli_query($this->link, $query) or die("Ошибка " . mysqli_error($this->link));

//        if($result)
//          //  echo "Выполнение запроса прошло успешно (levels)";
//        else die("Ошибка привыполнении запроса");

        if ($result->num_rows == 1){
            fwrite($this->file, ', "transitions": {');
            $this->writeDataInFileOneRow($result);
            fwrite($this->file, '} ');
        }
        else {
            fwrite($this->file,  ', "transitions": [');
            $this->writeDataInFileManyRows($result);
            fwrite($this->file, '] ');
        }
    }

    function GetDataAboutInterfaceContent(){
        $query = 'SELECT * FROM INTERFACE_CONTENT WHERE id="'.$this->atom_sys_id.'"';
        $result = mysqli_query($this->link, $query) or die("Ошибка " . mysqli_error($this->link));

//        if($result)
//           // echo "Выполнение запроса прошло успешно (interface_content), строк - ".$result->num_rows;
//        else die("Ошибка привыполнении запроса");

        if ($result->num_rows == 1){
            fwrite($this->file, ', "interface_content": {');
            $this->writeDataInFileOneRow($result);
            fwrite($this->file, '} ');
        }
        else {
            fwrite($this->file,  ', "interface_content": [');
            $this->writeDataInFileManyRows($result);
            fwrite($this->file, '] ');
        }
    }
}
