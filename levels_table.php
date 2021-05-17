<?php
require_once 'initialize_smarty.php';
$levels = file_get_contents('Z:\uploads\levels.json');
//$level_list->Load($element_id);
$smarty->assign('level_list', json_decode($levels, MYSQL_ASSOC));
$smarty->display('view_levels.tpl');