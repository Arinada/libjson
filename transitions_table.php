<?php
require_once 'get_data_for_modules.php';
$get_data_for_modules = new GetDataForModules();
$transitions = $get_data_for_modules->GetDataAboutTransitionsWithLevels();
$smarty->assign('transition_list', json_decode($transitions, MYSQL_ASSOC));
$smarty->display('view_transitions.tpl');
unlink('Z:\uploads\transitions.json');
