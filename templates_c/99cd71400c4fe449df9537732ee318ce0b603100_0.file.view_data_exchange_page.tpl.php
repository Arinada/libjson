<?php
/* Smarty version 3.1.39, created on 2021-03-11 14:00:25
  from 'Z:\home\localhost\www\libjson\templates\view_data_exchange_page.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_6049b1f9d4bee7_18188290',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '99cd71400c4fe449df9537732ee318ce0b603100' => 
    array (
      0 => 'Z:\\home\\localhost\\www\\libjson\\templates\\view_data_exchange_page.tpl',
      1 => 1615442424,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6049b1f9d4bee7_18188290 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="//www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head>
<body>
<form name="form" action="download_file.php" enctype="multipart/form-data" method="post">
 <input type="file" name="upload_file" title="Выберите файл"/> </br></br>
 <input type="submit" name="load_file" value = "Загрузить файл"  />
 <input type="submit" name="download_file" value = "Cкачать файл" /></br></br>
 <input type="submit" name="show_kvantogram" value = "Показать квантограмму" /></br></br>
 <p>Elements</p>
 <select name="Element name's" value="Elements"/>
 <p>Ionization</p>
 <select name="Ionization list" value="Ionization"/>
</form>
</body>
</html><?php }
}
