<?php
require_once("open_connection.php");
require_once ("close_connection.php");

class AtomData
{
    private $atom_sys_id, $element_id, $filename, $link, $file;

    function __construct($filename, $element_abbr, $ionization, $ionization_potential) {
      $connection = new Connection();
      $connection->OpenConnection();
      $this->filename = $filename;
      $this->link = $connection->link;
      $this->GetAtomSystemIds($element_abbr, $ionization, $ionization_potential);
    }

    function StartWrite() {
        $this->file = fopen($this->filename, 'wb');
        if ( $this->file==false && !file_exists($this->file)){
            die ('File open failed.');
        }
        if(!is_writable($this->filename))
            die ('File is not writable');
        fwrite($this->file, '{');
    }

    function WriteMetaData(){
        fwrite($this->file, '"metadata_common": {');
        fwrite($this->file, '"inf_system": "Electronic structure of atoms",');
        $today = date("d/m/Y");
        fwrite($this->file, ' "create_file_date": "'.$today.'",');
        fwrite($this->file, ' "data_type": "all atom system"}');
    }

    function EndWrite() {
        fwrite($this->file, '} }');
        fclose($this->file);
        mysqli_close($this->link);
    }

    function getResourceIdentificator($query) {
        $result = mysqli_query($this->link, $query) or die("Ошибка " . mysqli_error($this->link));
        return $result;
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

    function writeDataInFileOneRow($result , $data_about)
    {
        $fields_count = $result->field_count;
        $counter = 0;
        fwrite($this->file, ', "'.$data_about.'": {');
       // if (mysqli_fetch_array($result,MYSQLI_ASSOC) == null)
         //   die('This data havent\'t enough data for this atom system');
        while ($row  = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            foreach ($row as $key => $val) {
                $this->writeRow($val, $key, $counter, $fields_count);
                $counter++;

            }
        }
        if($data_about != 'atom_system')
        fwrite($this->file, '} ');
//        else if($result->num_rows > 0)
//            fwrite($this->file, ', ');
    }

    function writeRow ($val, $key, $counter, $fields_count){
        $val = addslashes($val);
        $val = str_replace(PHP_EOL, '</br>', $val);
        $val = str_replace(' ', '\u0020', $val);
        $val = preg_replace('[\t]', '\u0445', $val); //u0445
        $val = preg_replace('[\n]', '</br>', $val);
        if($key == 'SPECTRUM_IMG')
            $val = base64_encode($val);

        if( $val == NULL )
            fwrite( $this->file,'"' . $key . '": "NULL"');
        else
            fwrite( $this->file,'"' . $key . '": "' . $val . '"');
        if($counter != $fields_count-1)
            fwrite($this->file,  ", ");
    }

    function writeDataInFileManyRows($result, $data_about)
    {
        $fields_count = $result->field_count;
        $rows_number = $result->num_rows;
        //echo $rows_number. 'Rows number </br>';
        $counter_fields = 0;
        $counter_rows = 0;
        fwrite($this->file, ', "'.$data_about.'": [');
      //  if (mysqli_fetch_array($result,MYSQLI_ASSOC) == null)
          //  die('This data havent\'t enough data for this atom system');
        while ($row  = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            fwrite($this->file,  "{");
            foreach ($row as $key => $val) {
              //  $val = JSON.stringify(addslashes($val));
                $this->writeRow($val, $key, $counter_fields, $fields_count);
                $counter_fields++;
            }
            $counter_fields = 0;
            fwrite($this->file,  "}");
            if($counter_rows != $rows_number-1)
                fwrite($this->file,  ", ");
            $counter_rows++;
        }
        fwrite($this->file, '] ');
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
        $this->writeDataInFileOneRow($result, 'atom_system');
        return $result;
    }

    function GetDataAboutPeriodicTable(){
        $query = 'SELECT * FROM PERIODICTABLE WHERE id="'.$this->element_id.'"';
        $result = $this->getResourceIdentificator($query);

//        if($result)
//          //  echo "Выполнение запроса прошло успешно (periodictable) \n";
//        else die("Ошибка привыполнении запроса");

        $data_about = 'periodictable';
        $this->writeDataInFileOneRow($result, $data_about);

    }

    function GetDataAboutLevels()
    {
        $query = 'SELECT * FROM LEVELS WHERE id_atom="' . $this->atom_sys_id . '"';
        $result = $this->getResourceIdentificator($query);

//        if ($result)
//          //  echo "Выполнение запроса прошло успешно (levels)";
//        else die("Ошибка привыполнении запроса");
        $data_about = 'levels';
        if ($result->num_rows == 1)
            $this->writeDataInFileOneRow($result, $data_about);
        else
            $this->writeDataInFileManyRows($result, $data_about);

    }

    function GetDataAboutTransitions(){
        $query = 'SELECT * FROM TRANSITIONS WHERE id_atom="'.$this->atom_sys_id.'"';
        $result = $this->getResourceIdentificator($query);

//        if($result)
//          //  echo "Выполнение запроса прошло успешно (levels)";
//        else die("Ошибка привыполнении запроса");
        $data_about = 'transitions';
        if ($result->num_rows == 1)
            $this->writeDataInFileOneRow($result, $data_about);
        else
            $this->writeDataInFileManyRows($result, $data_about);
    }

    function GetDataAboutInterfaceContent(){
        $query = 'SELECT * FROM INTERFACE_CONTENT WHERE id="'.$this->atom_sys_id.'"';
        $result = $this->getResourceIdentificator($query);

//        if($result)
//           // echo "Выполнение запроса прошло успешно (interface_content), строк - ".$result->num_rows;
//        else die("Ошибка привыполнении запроса");
        $data_about = "interface_content";
        if ($result->num_rows == 1)
            $this->writeDataInFileOneRow($result, $data_about);
        else
            $this->writeDataInFileManyRows($result, $data_about);

    }
}
