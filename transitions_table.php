<?php
require_once 'initialize_smarty.php';
$transitions = file_get_contents('Z:\uploads\transitions.json');
$transitions = json_decode($transitions, MYSQL_ASSOC);
//print_r($transitions);
//exit();
$smarty->assign('transition_list', $transitions);
$smarty->display('view_transitions.tpl');
//echo  $transitions[1]['ID_ATOM'];
//$level_list->Load($element_id);
