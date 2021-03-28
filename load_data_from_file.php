<?php
    $atoms_fields = array('ID_ELEMENT', 'IONIZATION', 'IONIZATION_POTENCIAL');
    $periodictable_fields = array('Z', 'ABBR', 'TABLEPERIOD', 'TABLEGROUP', 'NAME_EN');
    $levels_fields = array('ID_ATOM', 'CONFIG', 'ENERGY', 'LIFETIME', 'J', 'TERMPREFIX', 'TERMMULTIPLY', 'TERMFIRSTPART', 'TERMSECONDPART');
    $transitions_fields = array('ID_ATOM', 'ID_UPPER_LEVEL', 'ID_LOWER_LEVEL', 'WAVELENGTH', 'PROBABILITY', 'OSCILLATOR_F', 'CROSSECTION', 'INTENSITY');
    $interface_content_fields = array();
    $tables = array('ATOMS', 'PERIODICTABLE', 'LEVELS', 'TRANSITIONS', 'INTERFACE_CONTENT');
    require_once 'open_connection.php';

    $data = file_get_contents('/uploads/data.json');
    $data = json_decode($data, true);


    echo 'periodic '.count($data['atom_system']['periodictable']).' ';
    echo 'levels '.count($data['atom_system']['levels']).' ';
    echo 'tran '.count($data['atom_system']['transitions']).' ';
    echo ' interface '.count($data['atom_system']['interface_content']).' <br/>';

    $atom_id = get_max_id('ATOMS', $link)+1;
    $periodictable_id = get_max_id('PERIODICTABLE', $link) + 1;
    //echo 'atom_id '.$atom_id.'</br>';
    //echo $periodictable_id.'</br>';
    //periodictable
    load_data($database, $data, $tables[1], $link, $periodictable_fields, $periodictable_id);
    //////atoms
    load_data_about_atom_system($database, $tables[0], $data, $link, $atoms_fields, $periodictable_id, $atom_id);
    //levels
    load_data($database, $data, $tables[2], $link, $levels_fields, $atom_id);
    //transitions
    load_data($database, $data, $tables[3], $link, $transitions_fields, $atom_id);

    function load_data ($database, $data, $table, $link, $fields_array, $id)
    {
        $has_nested_elements = check_if_has_nested_elements($data, strtolower($table));

        if ($has_nested_elements) {
            $elements_counter = count_elements($data, strtolower($table));
            //echo 'elements counter '.$elements_counter;
            for ($element_number = 0; $element_number < $elements_counter; $element_number++) {
                $condition = get_condition_for_select2($fields_array, $data, $table, $element_number, $id);
                $is_exist = check_if_row_exist($table, $condition, $link);
                if ($is_exist == true) {
                    echo '<p><font color=red>Data for this atom system is exists!(atoms)<font/></p>';
                    return;
                } else {
                    $query = get_query2($database, $table, $data, $link, $element_number, $id);
                    insert_row($link, $query);
                }
            }
        } else {
            $table_name = strtolower($table);
            $condition = get_condition_for_select($fields_array, $data, $table_name, $id);
            $is_exist = check_if_row_exist($table_name, $condition, $link);
            if ($is_exist == true) {
                echo '<p><font color=red>Data for this atom system is exists!(atoms)<font/></p>';
                return;
            } else {
                $query = get_query($database, $table, $link, $data, $id);
                //echo $query.'</br>';
                insert_row($link, $query);
            }
        }
    }

    function load_data_about_atom_system($database, $table_name, $data, $link, $atoms_fields, $periodictable_id, $atom_id)
    {
        $condition = get_condition_for_select_atoms($atoms_fields, $data, $periodictable_id);
        //echo $condition;
        $is_exist = check_if_row_exist($table_name, $condition, $link);
        if ($is_exist == true) {
            echo '<p><font color=red>Data for this atom system is exists!(atoms)<font/></p>';
            return;
        } else {
            $fields = get_fields($database, $table_name, $link);
            $condition_fields = get_condition_for_insert_fields($table_name, $fields);
            $condition_values = get_condition_for_insert_atoms($fields, $data, $periodictable_id, $atom_id);
            $query = 'INSERT INTO' . $condition_fields . $condition_values;
            echo $query.'</br>';
            insert_row($link, $query);
        }
    }

    //for nested elements
    function get_query2($database, $table_name, $data, $link, $element_number, $id){
        $fields = get_fields($database, $table_name, $link);
        $condition_fields = get_condition_for_insert_fields($table_name, $fields);
        $condition_values = get_condition_for_insert2($fields, $data, strtolower($table_name), $element_number, $link, $id);
        $query = 'INSERT INTO' . $condition_fields . $condition_values;
        echo $query.'</br>';
        return $query;
    }

    function get_query($database, $table_name, $link, $data, $id){
        $fields = get_fields($database, $table_name, $link);
        $condition_fields = get_condition_for_insert_fields($table_name, $fields);
        $condition_values = get_condition_for_insert($fields, $data, strtolower($table_name), $link, $id);
        $query = 'INSERT INTO'.$condition_fields.$condition_values;
        echo $query.'</br>';
        return $query;
    }

    function insert_row($link, $query) {
        if (mysqli_query($link, $query)) {
            echo '</br>Data has been saved sucessfully!</br>';
        } else {
            echo "Ошибка: " . $query . "<br>" . mysqli_error($link);
        }
    }

    function get_condition_for_select_atoms($fields, $json_a, $id_periodictable)
    {
        $ar_size = count($fields);
        $counter_fields = 0;
        $condition = '';
        //echo 'arr_size'.$ar_size;
        foreach ($fields as $field_name) {
            if($json_a[$field_name] == 'NULL')
                $condition = $condition.' '.$field_name . ' is ' . $json_a['atom_system'][$field_name];
            else if($field_name == 'ID_ELEMENT')
                $condition = $condition . ' ' . $field_name . '=\'' . $id_periodictable . '\'';
            else
                $condition = $condition . ' ' . $field_name . '=\'' . $json_a['atom_system'][$field_name] . '\'';
            if($counter_fields != $ar_size-1)
                $condition = $condition. ' AND ';
            $counter_fields++;
        }
        return $condition;
    }

    function get_condition_for_insert_atoms($fields, $json_a, $periodictable_id, $atom_id)
    {
        $ar_size = count($fields);
        $counter_fields = 0;
        $condition = ' VALUES( ';
        //echo 'arr_size'.$ar_size;
        foreach ($fields as $field_name) {
            $val = $json_a['atom_system'][$field_name];
            if($val == 'NULL')
                $condition = $condition.' NULL';
            else {
                if($field_name == 'SPECTRUM_IMG') {
                    $val = base64_decode($val);
                    $val = addslashes($val);
                }
                else if($field_name == 'ID_ELEMENT')
                    $val = $periodictable_id;
                else if($field_name == 'ID')
                    $val = $atom_id;
                else {
                    $val = $val = str_replace('</br>', PHP_EOL, $val);
                    $val = str_replace('\u0020', ' ', $val);
                }
                    $condition = $condition . ' \'' . $val . '\'';
            }
            if($counter_fields != $ar_size-1)
                $condition = $condition. ' , ';
            $counter_fields++;
        }
        $condition = $condition. ' )';
        return $condition;
    }

    function get_condition_for_select($fields, $json_a, $table_name, $id_atom)
    {
        $ar_size = count($fields);
        $counter_fields = 0;
        $condition = '';
        //echo 'arr_size'.$ar_size;
        foreach ($fields as $field_name) {
            if($json_a['atom_system'][$table_name][$field_name] == 'NULL')
                $condition = $condition.' '.$field_name . ' is ' . $json_a['atom_system'][$table_name][$field_name];
            else if($field_name == 'ID_ATOM' AND $table_name!='periodictable')
                $condition = $condition.' '.$field_name . '=' . $id_atom;
            else
                $condition = $condition.' '.$field_name . '=\'' . $json_a['atom_system'][$table_name][$field_name].'\'';
            if($counter_fields != $ar_size-1)
                $condition = $condition. ' AND ';
            $counter_fields++;
        }
        return $condition;
    }

    //this function for nested elements
    function get_condition_for_select2($fields, $json_a, $table_name, $element_number, $id_atom)
    {
        $ar_size = count($fields);
        $counter_fields = 0;
        $condition = '';
        //echo 'arr_size'.$ar_size;
        foreach ($fields as $field_name) {
            if($json_a['atom_system'][$table_name][$element_number][$field_name] == 'NULL')
                $condition = $condition.' '.$field_name . ' is ' . $json_a['atom_system'][$table_name][$element_number][$field_name];
            else if($field_name == 'ID_ATOM' AND $table_name!='periodictable')
                $condition = $condition.' '.$field_name . '=' . $id_atom;
            else
                $condition = $condition.' '.$field_name . '=\'' . $json_a['atom_system'][$table_name][$element_number][$field_name].'\'';
            if($counter_fields != $ar_size-1)
                $condition = $condition. ' AND ';
            $counter_fields++;
        }
        return $condition;
    }

    function get_condition_for_insert($fields, $json_a, $table_name, $link, $id)
    {
        $ar_size = count($fields);
        $counter_fields = 0;
        $condition = ' VALUES( ';
        //echo 'arr_size'.$ar_size;
        foreach ($fields as $field_name) {
            $val = $json_a['atom_system'][$table_name][$field_name];
            if($val == 'NULL')
                $condition = $condition.' NULL';
            else {
                if (($table_name == 'periodictable' and $field_name == 'ID') || ($table_name != 'periodictable' and $field_name == 'ID_ATOM'))
                    $val = $id;
                else if ($table_name != 'periodictable' and $field_name == 'ID')
                    $val = get_max_id($table_name, $link)+1;
                else {
                    $val = str_replace('</br>', PHP_EOL, $val);
                    $val = str_replace('\u0020', ' ', $val);
                }
                $condition = $condition . ' \'' . $val . '\'';
            }
            if($counter_fields != $ar_size-1)
                $condition = $condition. ' , ';
            $counter_fields++;
        }
        $condition = $condition. ' )';
        return $condition;
    }

    //для вложенных элементов
    function get_condition_for_insert2($fields, $json_a, $table_name, $el_number, $link, $id)
    {
        $ar_size = count($fields);
        $counter_fields = 0;
        $condition = ' VALUES( ';
        //echo 'arr_size'.$ar_size;
        foreach ($fields as $field_name) {
            $val = $json_a['atom_system'][$table_name][$el_number][$field_name];
            if($val == 'NULL')
                $condition = $condition.' NULL';
            else {
                if (($table_name == 'periodictable' and $field_name == 'ID') || ($table_name != 'periodictable' and $field_name == 'ID_ATOM'))
                    $val = $id;
                else if ($table_name != 'periodictable' and $field_name == 'ID')
                    $val = get_max_id($table_name, $link)+1 ;
                else {
                    $val = str_replace('</br>', PHP_EOL, $val);
                    $val = str_replace('\u0020', ' ', $val);
                }
                $condition = $condition . ' \'' . $val . '\'';
            }
            if($counter_fields != $ar_size-1)
                $condition = $condition. ' , ';
            $counter_fields++;
        }
        $condition = $condition. ' )';
        return $condition;
    }

    function get_condition_for_insert_fields( $table_name, $fields)
    {
        $ar_size = count($fields);
        $counter_fields = 0;
        $condition = ' '.$table_name.'(';
        foreach ($fields as $field_name) {
                $condition = $condition.' '.$field_name;
            if($counter_fields != $ar_size-1)
                $condition = $condition. ' , ';
            $counter_fields++;
        }
        $condition = $condition. ' )';
        return $condition;
    }

    function check_if_row_exist($table_name, $condition, $link)
    {
        $query_check = 'Select count(*) from '.$table_name.' where '.$condition;
        $result = mysqli_query($link, $query_check) or die("Ошибка " . mysqli_error($link));
        $row = mysqli_fetch_array($result);
        //echo 'existion '.$row[0];
        if( $row[0] > 0 )
            return true;
        else
            return false;
    }

    function check_if_has_nested_elements($data, $table_name)
    {
        $elements_counter = count($data['atom_system'][$table_name][0]);
        if($elements_counter > 0)
            return true;
        else
            return false;
    }
    function count_elements($data, $table_name)
    {
        $elements_counter = count($data['atom_system'][$table_name]);
        return $elements_counter;
    }

    function get_fields($database, $table_name, $link){
        //$fields = mysqli_list_fields($database, $table_name, $link); don't work
       // $columns = mysqli_num_fields($fields);

        $query = "SHOW COLUMNS FROM ".$table_name;
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        $fields_names = array();
        $counter = 0;

        while ($row  = mysqli_fetch_array($result,MYSQLI_ASSOC)) {

            $fields_names[$counter] = $row['Field'];
            //echo $row['Field'].'  ';
            $counter++;
        }

//        for ($i = 0; $i < $columns; $i++) {
//            $fields_names[$i] = mysqli_field_name($fields, $i);
//            echo mysqli_field_name($fields, $i) . "\n";
//        }
        return $fields_names;
    }

    function get_max_id($table_name, $link){
        $query = 'SELECT MAX(ID) as id FROM '.$table_name;
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        $row  = mysqli_fetch_array($result,MYSQLI_ASSOC);
        //echo 'id  '.$row['id'].'  </br>';
        return $row['id'];
    }

    require_once 'close_connection.php';