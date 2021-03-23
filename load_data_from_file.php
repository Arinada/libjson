<?php
    $atoms_fields = array('ID', 'ID_ELEMENT', 'IONIZATION', 'IONIZATION_POTENCIAL');
    $periodictable_fields = array('Z', 'ABBR', 'TABLEPERIOD', 'TABLEGROUP', 'NAME_EN');
    $levels_fields = array();
    $transitions_fields = array();
    $interface_content_fields = array();
    $tables = array('ATOMS', 'PERIODICTABLE', 'LEVELS', 'TRANSITIONS', 'INTERFACE_CONTENT');
    require_once 'open_connection.php';

    //$atoms_fields = get_fields($database, $tables[0], $link);
   // $periodictable_fields = get_fields($database, $tables[1], $link);
   // $levels_fields = get_fields($database, $tables[2], $link);
   // $transitions_fields = get_fields($database, $tables[3], $link);
   // $interface_content_fields = get_fields($database, $tables[4], $link);

    $data = file_get_contents('/uploads/data.json');
    $data = json_decode($data, true);

    echo 'periodic '.count($data['periodictable'][0]).' ';
    echo 'levels '.count($data['levels'][0]).' ';
    echo 'tran '.count($data['transitions'][0]).' ';
    echo ' interface '.count($data['interface_content'][0]).' ';
    //echo $data['LIMITS'];

    ///periodictable
    $condition = get_condition_for_select_periodictable($periodictable_fields, $data);
    echo $condition;
    $is_exist = check_if_row_exist($tables[1], $condition, $link);
    if ($is_exist == true)
    {
        echo '<p><font color=red>Data for this atom system is exists!(periodictable)<font/></p>';
    }
    else
    {
        $fields = get_fields($database, $tables[1], $link);
        $condition_fields = get_condition_for_insert_fields($tables[1], $fields);
        $condition_values = get_condition_for_insert_periodictable($fields, $data);
        $query = 'INSERT INTO'.$condition_fields.$condition_values;
        //echo $query.'</br>';
        if (mysqli_query($link, $query)) {
            echo 'Data has been saved sucessfully!'.'</br>';
        } else {
            echo "Ошибка: " . $query . "<br>" . mysqli_error($link);
        }
    }
    //////atoms
    $condition = get_condition_for_select_atoms($atoms_fields, $data);
    //echo $condition;
    $is_exist = check_if_row_exist($tables[0], $condition, $link);
    if ($is_exist == true)
    {
        echo '<p><font color=red>Data for this atom system is exists!(atoms)<font/></p>';
    }
    else
    {
        $fields = get_fields($database, $tables[0], $link);
        $condition_fields = get_condition_for_insert_fields($tables[0], $fields);
        $condition_values = get_condition_for_insert_atoms($fields, $data);
        $query = 'INSERT INTO'.$condition_fields.$condition_values;
        //echo $query.'</br>';
        if (mysqli_query($link, $query)) {
            echo 'Data has been saved sucessfully!';
        } else {
            echo "Ошибка: " . $query . "<br>" . mysqli_error($link);
        }
    }

    function get_condition_for_select_atoms($fields, $json_a)
    {
        $ar_size = count($fields);
        $counter_fields = 0;
        $condition = '';
        //echo 'arr_size'.$ar_size;
        foreach ($fields as $field_name) {
            if($json_a[$field_name] == 'NULL')
                $condition = $condition.' '.$field_name . ' is ' . $json_a[$field_name];
            else
                $condition = $condition.' '.$field_name . '=\'' . $json_a[$field_name].'\'';
            if($counter_fields != $ar_size-1)
                $condition = $condition. ' AND ';
            $counter_fields++;
        }
        return $condition;
    }

    function get_condition_for_insert_atoms($fields, $json_a)
    {
        $ar_size = count($fields);
        $counter_fields = 0;
        $condition = ' VALUES( ';
        //echo 'arr_size'.$ar_size;
        foreach ($fields as $field_name) {
            $val = $json_a[$field_name];
            if($val == 'NULL')
                $condition = $condition.' '.$val;
            else {
                if($field_name == 'SPECTRUM_IMG') {
                    $val = base64_decode($val);
                    $val = addslashes($val);
                }
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

    function get_condition_for_select_periodictable($fields, $json_a)
    {
        $ar_size = count($fields);
        $counter_fields = 0;
        $condition = '';
        //echo 'arr_size'.$ar_size;
        foreach ($fields as $field_name) {
            if($json_a['periodictable'][$field_name] == 'NULL')
                $condition = $condition.' '.$field_name . ' is ' . $json_a['periodictable'][$field_name];
            else
                $condition = $condition.' '.$field_name . '=\'' . $json_a['periodictable'][$field_name].'\'';
            if($counter_fields != $ar_size-1)
                $condition = $condition. ' AND ';
            $counter_fields++;
        }
        return $condition;
    }

    function get_condition_for_insert_periodictable($fields, $json_a)
    {
        $ar_size = count($fields);
        $counter_fields = 0;
        $condition = ' VALUES( ';
        //echo 'arr_size'.$ar_size;
        foreach ($fields as $field_name) {
            $val = $json_a['periodictable'][$field_name];
            if($val == 'NULL')
                $condition = $condition.' '.$val;
            else {
                $val = str_replace( '</br>', PHP_EOL, $val);
                $val = str_replace('\u0020', ' ', $val);
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

    require_once 'close_connection.php';