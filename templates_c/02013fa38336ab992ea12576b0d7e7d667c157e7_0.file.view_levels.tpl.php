<?php
/* Smarty version 3.1.39, created on 2021-05-17 21:28:21
  from 'Z:\home\localhost\www\libjson\templates\view_levels.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_60a26f750c6318_28751726',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '02013fa38336ab992ea12576b0d7e7d667c157e7' => 
    array (
      0 => 'Z:\\home\\localhost\\www\\libjson\\templates\\view_levels.tpl',
      1 => 1621258099,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60a26f750c6318_28751726 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=Windows-1251" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Atomic levels — H</title>
	<link rel="shortcut icon" type="image/x-icon" href="images/icon_blue.ico" />
	<link rel="stylesheet" type="text/css" href="css/reset.css" />
	<link rel="stylesheet" type="text/css" href="css/text.css" />
	<link rel="stylesheet" type="text/css" href="css/960.css?v2" />
	<link rel="stylesheet" type="text/css" href="css/main.css?v2" />
	<link rel="stylesheet" type="text/css" href="css/dropdown/dropdown.css" media="screen"  />
	<link rel="stylesheet" type="text/css" href="css/dropdown/themes/grotrian/default.advanced.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="js/fancybox/jquery.fancybox.css" media="screen" />
	<?php echo '<script'; ?>
 type="text/javascript" src="js/jquery-1.11.2.min.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="js/fancybox/jquery.mousewheel-3.0.6.pack.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="js/fancybox/jquery.fancybox.pack.js"><?php echo '</script'; ?>
>
	<!--[if IE 7]><?php echo '<script'; ?>
 type="text/javascript" src="js/jquery.dropdown.js"><?php echo '</script'; ?>
><![endif]-->
	<!--[if IE 6]><?php echo '<script'; ?>
 type="text/javascript" src="js/jquery.dropdown.js"><?php echo '</script'; ?>
><![endif]-->
	<?php echo '<script'; ?>
 type="text/javascript" src="js/jquery.dataTables.min.js"><?php echo '</script'; ?>
>
	<link rel="stylesheet" type="text/css" href="css/table.css" />
	<?php echo '<script'; ?>
 type="text/javascript" src="js/tablexport.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" src="js/bibtex_js.js"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" charset="windows-1251">var locale="en";<?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 type="text/javascript" charset="windows-1251" src="js/levels.js?v5"><?php echo '</script'; ?>
>
</head>
<body>
			<div id="tab">
				<div id="panel" >
		    		<div class="container_12">
						<div class="grid_7">
            				<h4><?php echo $_smarty_tpl->tpl_vars['l10n']->value['Table_lookup'];?>
:</h4>
	               			<table class="search_form">
								<tbody>
				                	<tr>
				                    	  <td></td>
                                          <td align="center"><div class="froam"><?php echo $_smarty_tpl->tpl_vars['l10n']->value['from'];?>
</div><div class="froam" ><?php echo $_smarty_tpl->tpl_vars['l10n']->value['to'];?>
</div></td>
					                </tr>
									<tr>
										<td class="name"><?php echo $_smarty_tpl->tpl_vars['l10n']->value['Energy'];?>
:</td>
										<td>
				                        	<input size="12" id="min_3" name="min_3"  type="text"/>
											<input size="12" id="max_3" name="max_3"  type="text"/>
										</td>

									</tr>

									<tr>
										<td class="name"><?php echo $_smarty_tpl->tpl_vars['l10n']->value['ConfigurationType'];?>
:</td>
										<td>
											<select id="configurationType" name="configurationType" style="width: 210px">
												<option>&nbsp;</option>
											</select>
										</td>

									</tr>
									<tr>
										<td class="name"><?php echo $_smarty_tpl->tpl_vars['l10n']->value['Configuration'];?>
:</td>
										<td>
											<select id="configurationSelect" name="configurationSelect" style="width: 210px">
												<option>&nbsp;</option>
											</select>
										</td>

									</tr>
									<tr>
										<td class="name"><?php echo $_smarty_tpl->tpl_vars['l10n']->value['Term'];?>
:</td>
										<td>
											<select id="termSelect" name="termSelect" style="width: 210px">
												<option>&nbsp;</option>
											</select>
										</td>

									</tr>
									<tr>
										<td class="name"> <?php echo $_smarty_tpl->tpl_vars['l10n']->value['Jvalue'];?>
:</td>
										<td>
											<select id="jvalueSelect" name="jvalueSelect" style="width: 210px">
												<option>&nbsp;</option>
											</select>
										</td>
									</tr>

								</tbody>
							</table>
			 			</div>
					</div>

			        <div class="clear">  </div>
				</div>
<!--END of Panel-->

                <div class="slide">
					<a href="#" class="btn-slide"></a>
				</div>
<!--End of Slide-->
			</div>
<!--End of Tab-->
				<div id="main" class="container_12" >
					<table cellpadding="0" cellspacing="0" border="0" class="display view" id="levels_table">
						<thead>
							<tr>
								<th>Configuration Type</th>
								<th>Configuration</th>
								<th>Term</th>
		                        <th>J  </th>
								<th>F  </th>
								<?php if ($_smarty_tpl->tpl_vars['atom']->value['ENERGY_DIMENSION'] == "MHz") {?>
								<th>Energy (MHz)</th>
								<?php } else { ?>
								<th>Energy ( cm <sup>-1</sup>)</th>
								<?php }?>
								<th>Lifetime <br/>(ns)</th>
								<th>Source</th>
							</tr>
						</thead>

                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['level_list']->value, 'level');
$_smarty_tpl->tpl_vars['level']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['level']->value) {
$_smarty_tpl->tpl_vars['level']->do_else = false;
?>
					<tr class="selectable">
						<!-- <td><input type="checkbox" name="selected_tbl[]" value="aliases" /></td>  -->
						<td><?php if ($_smarty_tpl->tpl_vars['level']->value['config_type']) {?> <?php echo $_smarty_tpl->tpl_vars['level']->value['config_type'];?>
 <?php } else { ?> (?) <?php }?></td>
					 	<td><?php if ($_smarty_tpl->tpl_vars['level']->value['CONFIG'] == NULL || $_smarty_tpl->tpl_vars['level']->value['CONFIG'] == '') {?> (?) <?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['level']->value['CONFIG'];?>
 <?php }?> </td>
				        <td>
				        <?php if ($_smarty_tpl->tpl_vars['level']->value['TERMSECONDPART'] != "NULL") {?><span><?php echo $_smarty_tpl->tpl_vars['level']->value['TERMSECONDPART'];?>
</span><?php }?>
						<?php if ($_smarty_tpl->tpl_vars['level']->value['TERMPREFIX'] != '') {?><sup><?php echo $_smarty_tpl->tpl_vars['level']->value['TERMPREFIX'];?>
</sup><?php }?>
				        <?php if ($_smarty_tpl->tpl_vars['level']->value['TERMFIRSTPART'] == '' || $_smarty_tpl->tpl_vars['level']->value['TERMFIRSTPART'] == " ") {?>(?)<?php } else { ?><span><?php echo $_smarty_tpl->tpl_vars['level']->value['TERMFIRSTPART'];?>
</span><?php }?>
				        <?php if ($_smarty_tpl->tpl_vars['level']->value['TERMMULTIPLY'] == TRUE) {?><sup>o</sup><?php }?>

				        </td>
                        <td><?php echo $_smarty_tpl->tpl_vars['level']->value['J'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['level']->value['F'];?>
</td>
                        <?php if ($_smarty_tpl->tpl_vars['atom']->value['ENERGY_DIMENSION'] == "MHz") {?>
						<td><?php echo $_smarty_tpl->tpl_vars['level']->value['ENERGY_MHZ'];?>
</td>
                        <?php } else { ?>
						<td><?php echo $_smarty_tpl->tpl_vars['level']->value['ENERGY'];?>
</td>
                        <?php }?>
                        <td><?php echo $_smarty_tpl->tpl_vars['level']->value['LIFETIME'];?>
</td>
                        <td class="source">
                        <?php if ($_smarty_tpl->tpl_vars['level']->value['SOURCE_IDS'] != '') {?>
							<span class="links">
							<?php $_smarty_tpl->_assignInScope('sources', explode(",",$_smarty_tpl->tpl_vars['level']->value['SOURCE_IDS']));?>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['sources']->value, 'source');
$_smarty_tpl->tpl_vars['source']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['source']->value) {
$_smarty_tpl->tpl_vars['source']->do_else = false;
?>
								<?php if ($_smarty_tpl->tpl_vars['source']->value != '') {?>
									<a class="source_link various fancybox.ajax" href="../bibliography/<?php echo $_smarty_tpl->tpl_vars['source']->value;?>
" ><?php echo $_smarty_tpl->tpl_vars['source']->value;?>
</a>
								<?php }?>
							<?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							</span>
						<?php }?>
                       	</td>
                    </tr>
                    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		    		</table>
			</div>
</body>
</html><?php }
}
