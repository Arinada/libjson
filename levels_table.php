<?php
//require_once 'initialize_smarty.php';
require_once 'get_data_for_modules.php';

$get_data_for_modules = new GetDataForModules();
$levels = $get_data_for_modules->GetDataAboutLevels();
$smarty->assign('level_list', json_decode($levels, MYSQL_ASSOC));
$smarty->display('view_levels.tpl');
unlink('Z:\uploads\levels.json');