<?php
class LoadData
{
    private $atoms_fields = array('ID_ELEMENT', 'IONIZATION', 'IONIZATION_POTENCIAL');
    private $periodictable_fields = array('Z', 'ABBR', 'TABLEPERIOD', 'TABLEGROUP', 'NAME_EN');
    private $levels_fields = array('ID_ATOM', 'CONFIG', 'ENERGY', 'LIFETIME', 'J', 'TERMPREFIX', 'TERMMULTIPLY', 'TERMFIRSTPART', 'TERMSECONDPART');
    private $transitions_fields = array('ID_ATOM', 'ID_UPPER_LEVEL', 'ID_LOWER_LEVEL', 'WAVELENGTH', 'PROBABILITY', 'OSCILLATOR_F', 'CROSSECTION', 'INTENSITY');
    private $interface_content_fields = array();
    private $tables = array('ATOMS', 'PERIODICTABLE', 'LEVELS', 'TRANSITIONS', 'INTERFACE_CONTENT');
    private $data;

    public function LoadDataForOneAtomSystem($fileName)
    {
        $this->data = file_get_contents($fileName);
        $this->DataIsJson();
//    echo 'levels '.count($this->data['atom_system']['levels']).' ';
//    echo 'tran '.count($this->data['atom_system']['transitions']).' ';
//    echo 'tran2 '.count($this->data['atom_system']).' '.' <br/>';

        require_once 'open_connection.php';
        $atom_id = $this->GetMaxId('ATOMS', $link) + 1;
        $periodictable_id = $this->GetMaxId('PERIODICTABLE', $link) + 1;
        if($this->CountElements(strtolower($this->tables[1]))>0 AND count($this->data['atom_system'])>0) {
            //periodictable
            $this->ParseAndLoadData($this->tables[1], $link, $this->periodictable_fields, $periodictable_id);
            //////atoms
            $this->ParseAndLoadDataAboutAtomSystem($this->tables[0], $link, $this->atoms_fields, $periodictable_id, $atom_id);
            //levels
            if ($this->CountElements(strtolower($this->tables[2])) > 0)
                $this->ParseAndLoadData($this->tables[2], $link, $this->levels_fields, $atom_id);
            //transitions
            if ($this->CountElements(strtolower($this->tables[3])) > 0)
                $this->ParseAndLoadData($this->tables[3], $link, $this->transitions_fields, $atom_id);
        }else
            echo 'Invalid structure of file!';
        require_once 'close_connection.php';
    }

    private function DataIsJson(){
        $this->data = json_decode($this->data, true);
        if (json_last_error() !== JSON_ERROR_NONE)
            die('Incorrect json format');
    }

    private function ParseAndLoadData( $table, $link, $fields_array, $id)
    {
        $has_nested_elements = $this->CheckIfHasNestedElements(strtolower($table));

        if ($has_nested_elements) {
            $elements_counter = $this->CountElements(strtolower($table));
            //echo 'elements counter '.$elements_counter;
            for ($element_number = 0; $element_number < $elements_counter; $element_number++) {
                $condition = $this->GetConditionForSelect2($fields_array, $table, $element_number, $id);
                $this->CheckIfRowExist($table, $condition, $link);
                $query = $this->GetQuery2($table, $link, $element_number, $id);
                $this->ExecuteQuery($link, $query);
            }
        } else {
            $table_name = strtolower($table);
            $condition = $this->GetConditionForSelect($fields_array, $table_name, $id);
            $this->CheckIfRowExist($table_name, $condition, $link);
            $query = $this->GetQuery($table, $link, $id);
            //echo $query.'</br>';
            $this->ExecuteQuery($link, $query);

        }
    }

    private function ParseAndLoadDataAboutAtomSystem($table_name, $link, $atoms_fields, $periodictable_id, $atom_id)
    {
        $condition = $this->GetConditionForSelectAtoms($atoms_fields, $periodictable_id);
        //echo $condition;
        $this->CheckIfRowExist($table_name, $condition, $link);
        $fields = $this->GetFields($table_name, $link);
        $condition_fields = $this->GetConditionForInsertFields($table_name, $fields);
        $condition_values = $this->GetConditionForInsertAtoms($fields, $periodictable_id, $atom_id);
        $query = 'INSERT INTO' . $condition_fields . $condition_values;
        echo $query . '</br>';
        $this->ExecuteQuery($link, $query);
    }

    //for nested elements
    private function GetQuery2($table_name, $link, $element_number, $id)
    {
        $fields = $this->GetFields($table_name, $link);
        $condition_fields =$this->GetConditionForInsertFields($table_name, $fields);
        $condition_values = $this->GetConditionForInsert2($fields, strtolower($table_name), $element_number, $link, $id);
        $query = 'INSERT INTO' . $condition_fields . $condition_values;
        echo $query . '</br>';
        return $query;
    }

    private function GetQuery($table_name, $link, $id)
    {
        $fields = $this->GetFields($table_name, $link);
        $condition_fields = $this->GetConditionForInsertFields($table_name, $fields);
        $condition_values = $this->GetConditionForInsert($fields, strtolower($table_name), $link, $id);
        $query = 'INSERT INTO' . $condition_fields . $condition_values;
        echo $query . '</br>';
        return $query;
    }

    private function ExecuteQuery($link, $query)
    {
//        if (mysqli_query($link, $query)) {
//            echo '</br>Data has been saved sucessfully!</br>';
//        } else {
//            echo "Ошибка: " . $query . "<br>" . mysqli_error($link);
//        }
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        return $result;
    }

    private function GetConditionForSelectAtoms($fields, $id_periodictable)
    {
        $ar_size = count($fields);
        $counter_fields = 0;
        $condition = '';
        //echo 'arr_size'.$ar_size;
        foreach ($fields as $field_name) {
            if ($this->data[$field_name] == 'NULL')
                $condition = $condition . ' ' . $field_name . ' is ' . $this->data['atom_system'][$field_name];
            else if ($field_name == 'ID_ELEMENT')
                $condition = $condition . ' ' . $field_name . '=\'' . $id_periodictable . '\'';
            else
                $condition = $condition . ' ' . $field_name . '=\'' . $this->data['atom_system'][$field_name] . '\'';
            if ($counter_fields != $ar_size - 1)
                $condition = $condition . ' AND ';
            $counter_fields++;
        }
        return $condition;
    }

    private function GetConditionForInsertAtoms($fields, $periodictable_id, $atom_id)
    {
        $ar_size = count($fields);
        $counter_fields = 0;
        $condition = ' VALUES( ';
        //echo 'arr_size'.$ar_size;
        foreach ($fields as $field_name) {
            $val = $this->data['atom_system'][$field_name];
            if ($val == 'NULL')
                $condition = $condition . ' NULL';
            else {
                if ($field_name == 'SPECTRUM_IMG') {
                    $val = base64_decode($val);
                    $val = addslashes($val);
                } else if ($field_name == 'ID_ELEMENT')
                    $val = $periodictable_id;
                else if ($field_name == 'ID')
                    $val = $atom_id;
                else {
                    $val = $val = str_replace('</br>', PHP_EOL, $val);
                    $val = str_replace('\u0020', ' ', $val);
                    //$val = preg_replace('\u0445', ' ',  $val);
                    $val = preg_replace('\u0445', '\t',  $val);
                }
                $condition = $condition . ' \'' . $val . '\'';
            }
            if ($counter_fields != $ar_size - 1)
                $condition = $condition . ' , ';
            $counter_fields++;
        }
        $condition = $condition . ' )';
        return $condition;
    }

    private function GetConditionForSelect($fields, $table_name, $id_atom)
    {
        $ar_size = count($fields);
        $counter_fields = 0;
        $condition = '';
        //echo 'arr_size'.$ar_size;
        foreach ($fields as $field_name) {
            if ($this->data['atom_system'][$table_name][$field_name] == 'NULL')
                $condition = $condition . ' ' . $field_name . ' is ' . $this->data['atom_system'][$table_name][$field_name];
            else if ($field_name == 'ID_ATOM' and $table_name != 'periodictable')
                $condition = $condition . ' ' . $field_name . '=' . $id_atom;
            else
                $condition = $condition . ' ' . $field_name . '=\'' . $this->data['atom_system'][$table_name][$field_name] . '\'';
            if ($counter_fields != $ar_size - 1)
                $condition = $condition . ' AND ';
            $counter_fields++;
        }
        return $condition;
    }

    //this function for nested elements
    private function GetConditionForSelect2($fields, $table_name, $element_number, $id_atom)
    {
        $ar_size = count($fields);
        $counter_fields = 0;
        $condition = '';
        //echo 'arr_size'.$ar_size;
        foreach ($fields as $field_name) {
            if ($this->data['atom_system'][$table_name][$element_number][$field_name] == 'NULL')
                $condition = $condition . ' ' . $field_name . ' is ' . $this->data['atom_system'][$table_name][$element_number][$field_name];
            else if ($field_name == 'ID_ATOM' and $table_name != 'periodictable')
                $condition = $condition . ' ' . $field_name . '=' . $id_atom;
            else
                $condition = $condition . ' ' . $field_name . '=\'' . $this->data['atom_system'][$table_name][$element_number][$field_name] . '\'';
            if ($counter_fields != $ar_size - 1)
                $condition = $condition . ' AND ';
            $counter_fields++;
        }
        return $condition;
    }

    private function GetConditionForInsert($fields, $table_name, $link, $id)
    {
        $ar_size = count($fields);
        $counter_fields = 0;
        $condition = ' VALUES( ';
        //echo 'arr_size'.$ar_size;
        foreach ($fields as $field_name) {
            $val = $this->data['atom_system'][$table_name][$field_name];
            if ($val == 'NULL')
                $condition = $condition . ' NULL';
            else {
                if (($table_name == 'periodictable' and $field_name == 'ID') || ($table_name != 'periodictable' and $field_name == 'ID_ATOM'))
                    $val = $id;
                else if ($table_name != 'periodictable' and $field_name == 'ID')
                    $val = $this->GetMaxId($table_name, $link) + 1;
                else {
                    $val = str_replace('</br>', PHP_EOL, $val);
                    $val = str_replace('\u0020', ' ', $val);
                    //$val = preg_replace('\u0445', ' ',  $val);
                    $val = preg_replace('\u0445', '\t',  $val);
                }
                $condition = $condition . ' \'' . $val . '\'';
            }
            if ($counter_fields != $ar_size - 1)
                $condition = $condition . ' , ';
            $counter_fields++;
        }
        $condition = $condition . ' )';
        return $condition;
    }

    //для вложенных элементов
    private function GetConditionForInsert2($fields, $table_name, $el_number, $link, $id)
    {
        $ar_size = count($fields);
        $counter_fields = 0;
        $condition = ' VALUES( ';
        //echo 'arr_size'.$ar_size;
        foreach ($fields as $field_name) {
            $val = $this->data['atom_system'][$table_name][$el_number][$field_name];
            if ($val == 'NULL')
                $condition = $condition . ' NULL';
            else {
                if (($table_name == 'periodictable' and $field_name == 'ID') || ($table_name != 'periodictable' and $field_name == 'ID_ATOM'))
                    $val = $id;
                else if ($table_name != 'periodictable' and $field_name == 'ID')
                    $val = $this->GetMaxId($table_name, $link) + 1;
                else {
                    $val = str_replace('</br>', PHP_EOL, $val);
                    $val = str_replace('\u0020', ' ', $val);
                    //$val = preg_replace('\u0445', ' ',  $val);
                    $val = preg_replace('\u0445', '\t',  $val);
                }
                $condition = $condition . ' \'' . $val . '\'';
            }
            if ($counter_fields != $ar_size - 1)
                $condition = $condition . ' , ';
            $counter_fields++;
        }
        $condition = $condition . ' )';
        return $condition;
    }

    private function GetConditionForInsertFields($table_name, $fields)
    {
        $ar_size = count($fields);
        $counter_fields = 0;
        $condition = ' ' . $table_name . '(';
        foreach ($fields as $field_name) {
            $condition = $condition . ' ' . $field_name;
            if ($counter_fields != $ar_size - 1)
                $condition = $condition . ' , ';
            $counter_fields++;
        }
        $condition = $condition . ' )';
        return $condition;
    }

    private function CheckIfRowExist($table_name, $condition, $link)
    {
        $query_check = 'Select count(*) from ' . $table_name . ' where ' . $condition;
        $result = $this->ExecuteQuery($link, $query_check);
        $row = mysqli_fetch_array($result);
        //echo 'existion '.$row[0];
        if ($row[0] > 0)
            //echo 'Data for this atom system is exists!(atoms)';
            die('Data for this atom system is exists!(' .$table_name.') </br>'. $query_check);
        else
            return false;
    }

    public function CheckIfHasNestedElements($table_name)
    {
        $elements_counter = count($this->data['atom_system'][$table_name][0]);
        if ($elements_counter > 0)
            return true;
        else
            return false;
    }

    public function CountElements($table_name)
    {
        $elements_counter = count($this->data['atom_system'][$table_name]);
        return $elements_counter;
    }

    public function GetFields($table_name, $link)
    {
        $query = "SHOW COLUMNS FROM " . $table_name;
        $result = $this->ExecuteQuery($link, $query);
        $fields_names = array();
        $counter = 0;

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $fields_names[$counter] = $row['Field'];
            $counter++;
        }

        return $fields_names;
    }

    private function GetMaxId($table_name, $link)
    {
        $query = 'SELECT MAX(ID) as id FROM ' . $table_name;
        $result = $this->ExecuteQuery($link, $query);
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        //echo 'id  '.$row['id'].'  </br>';
        return $row['id'];
    }
}
