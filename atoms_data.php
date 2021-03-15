<?php
class AtomData
{
    function GetData($link)
    {
        $query ="SELECT * FROM atoms where id=1";
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        if($result)
        {
            echo "Выполнение запроса прошло успешно";
        }
        $this->writeDataInFile($result);
    }

    function writeDataInFile($file, $result)
    {
        $fields_count = $result->field_count;
        $counter = 0;
        while ($row  = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
            foreach ($row as $key => $val) {
                fwrite( $file,'"' . $key . '": "' . $val . '"');
                if($counter != $fields_count-1)
                    fwrite($file,  ", ");
                $counter++;
            }
        }
    }

    function GetAtomSystemId($element_abbr, $ionization, $ionization_potencial, $link){
        $query = 'Select distinct ATOMS.id, id_element from PERIODICTABLE Inner join ATOMS on PERIODICTABLE.id=ATOMS.ID_ELEMENT AND abbr="'.$element_abbr.'"'.
                    ' AND ionization="'.$ionization.'"'.' AND ionization_potencial="'.$ionization_potencial.'"';
        //print $query.'               ';
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        if($result)
        {
            echo "Выполнение запроса прошло успешно";
        }
        return $result;
    }

    function GetDataAboutAtomSystem($atom_sys_id, $link){
        $query = 'SELECT * FROM ATOMS WHERE id="'.$atom_sys_id.'"';
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        if($result)
        {
            echo "Выполнение запроса прошло успешно";
        }
        return $result;
    }

    function GetDataAboutPeriodicTable($element_id, $link){
        $query = 'SELECT * FROM Periodictable WHERE id="'.$element_id.'"';
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        if($result)
        {
            echo "Выполнение запроса прошло успешно";
        }
        return $result;
    }
}
