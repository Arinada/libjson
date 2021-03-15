<?php
require_once 'initialize_smarty.php';

$atom_sys = file_get_contents('Z:\uploads\atoms.json');
$smarty->assign('atom_json', $atom_sys);
$transitions = file_get_contents('Z:\uploads\transitions.json');
$smarty->assign('transitions_json',$transitions);

$levels = file_get_contents('Z:\uploads\levels.json');
$smarty->assign('levels_json',$levels);

$smarty->display('view_cf.tpl');
