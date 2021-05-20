<?php
require_once 'initialize_smarty.php';
require_once 'get_data_for_modules.php';
$get_data_for_modules = new GetDataForModules();

$smarty->assign('atom_json', $get_data_for_modules->GetDataAboutAtoms());
$smarty->assign('transitions_json', $get_data_for_modules->GetDataAboutTransitionsWithLevels());
$smarty->assign('levels_json', $get_data_for_modules->GetDataAboutLevels());

$smarty->display('view_cf.tpl');

unlink('Z:\uploads\atoms.json');
unlink('Z:\uploads\transitions.json');
unlink('Z:\uploads\levels.json');
