<?php
/* Smarty version 3.1.39, created on 2021-02-20 19:28:18
  from 'Z:\home\localhost\www\libjson\templates\main.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_6030f252a69f73_40352400',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e36be19cf4b6dedb4df58cae000b789739214f8f' => 
    array (
      0 => 'Z:\\home\\localhost\\www\\libjson\\templates\\main.tpl',
      1 => 1613820482,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6030f252a69f73_40352400 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="//www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head>
<body>
<form name="form" action="download_file.php" enctype="multipart/form-data" method="post">
 <input type="file" name="upload_file" title="Выберите файл"/> </br></br>
 <input type="submit" name="load_file" value = "Загрузить файл"  />
 <input type="submit" name="download_file" value = "Cкачать файл" name="button" /></br>
</form>
</body>
</html><?php }
}
