<?php
/* Smarty version 3.1.39, created on 2021-05-17 21:57:14
  from 'Z:\home\localhost\www\libjson\templates\view_transitions.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_60a2763a297149_00078124',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f6be3d909323795edd19f018ee034646fc591acb' => 
    array (
      0 => 'Z:\\home\\localhost\\www\\libjson\\templates\\view_transitions.tpl',
      1 => 1621259831,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60a2763a297149_00078124 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=Windows-1251" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Atomic transitions — H</title>
	<link rel="shortcut icon" type="image/x-icon" href="/images/icon_blue.ico" />
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
 type="text/javascript" src="js/transitions.js?v3"><?php echo '</script'; ?>
>
</head>
<body>
<div id="tab" >
				<div id="panel">
    				<div class="container_12">
						<div class="grid_7">
            				<h4>Table_lookup:</h4>
	                		<table class="search_form">
								<tbody>

                                    <tr>
	                    	 			<td></td>
                                        <td align="center"><div class="froam">от</div><div class="froam" >до</div></td>
                                        <td></td>
		                			</tr>

                                    <tr>
										<td class="name">Wavelength:</td>
										<td>
				                        	<input size="12" id="min_2" name="min_2"  type="text"/>
											<input size="12" id="max_2" name="max_2"  type="text"/>
										</td>

                                        <td class="dimension">
	                        				[&#197;]
	                      				 </td>
									</tr>

            						<tr>
										<td  class="name">Intensity:</td>
										<td>
				                            <input size="12" id="min_3" name="min_3"  type="text"/>
											<input size="12" id="max_3" name="max_3"  type="text"/>
										</td>
										<td class="dimension"></td>
									</tr>

                                    <tr>
										<td class="name"><i>f<sub>ik</sub></i>:</td>
										<td>
	                            			<input size="12" id="min_4" name="min_4"  type="text"/>
											<input size="12" id="max_4" name="max_4"  type="text"/>
										</td>
										<td class="dimension"></td>
									</tr>

                                    <tr>
										<td class="name">A<sub><i>ki</i></sub>:</td>
										<td>
	                           				<input size="12" id="min_5" name="min_5"  type="text"/>
											<input size="12" id="max_5" name="max_5"  type="text"/></td>
										<td class="dimension">
	                        				[<i>10<sup>8</sup>sec<sup>-1</sup></i>]
										</td>

									</tr>

									<tr>
										<td class="name">The_excitation_cross_section:</td>
										<td>
	                            			<input size="12" id="min_6" name="min_6"  type="text"/>
											<input size="12" id="max_6" name="max_6"  type="text"/>
										</td>
										<td class="dimension"></td>
									</tr>
									<tr>
										<td class="name"> Serie:</td>
										<td>
											<select id="serieSelect" name="serieSelect" style="width: 210px">
												<option>&nbsp;</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="name"> Lower Level:</td>
										<td>
											<select id="lowerLevelSelect" name="lowerLevelSelect" style="width: 210px">
												<option>&nbsp;</option>
											</select>
										</td>
									</tr>
									<tr>
										<td class="name"> Upper Level:</td>
										<td>
											<select id="upperLevelSelect" name="upperLevelSelect" style="width: 210px">
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
			<div id="main" class="container_12" >

					<table cellpadding="0" cellspacing="0" border="0"  class="display view" id="transitions_table">
						<thead>
							<tr>
								<th>Serie</th>
								<th>Lower Level</th>
								<th>Upper Level</th>
                                <?php if (($_smarty_tpl->tpl_vars['atom']->value['ENERGY_DIMENSION'] == 'MHz')) {?>
								<th>Wavelength [MHz]</th>
                                <?php } else { ?>
								<th>Wavelength [<i>&#197;</i>]</th>
                                <?php }?>
								<th>Intensity</th>
								<th><i>f<sub>ik</sub></i></th>
					            <th>A<sub><i>ki</i></sub><br/>[<i>10<sup>8</sup>сек<sup>-1</sup></i>]</th>
					            <th>Excitation cross section <br/> Q<sub>max</sub>* 10<sup>18</sup>, <i><?php echo $_smarty_tpl->tpl_vars['l10n']->value['cm'];?>
<sup>2</sup></i></th>
								<th>Source</th>
							</tr>
						</thead>

                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['transition_list']->value, 'transition');
$_smarty_tpl->tpl_vars['transition']->do_else = true;
if ($_from !== null) foreach ($_from as $_smarty_tpl->tpl_vars['transition']->value) {
$_smarty_tpl->tpl_vars['transition']->do_else = false;
?>
                             <tr>
                             <td>
                            	<?php if (($_smarty_tpl->tpl_vars['transition']->value['lower_level_config'] == '' || $_smarty_tpl->tpl_vars['transition']->value['lower_level_config'] == " ")) {?>(?)
                            	<?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['transition']->value['lower_level_config'];?>

						 			<?php if ($_smarty_tpl->tpl_vars['transition']->value['upper_level_config_type']) {?> - <?php echo $_smarty_tpl->tpl_vars['transition']->value['upper_level_config_type'];?>
 <?php }?>
								<?php }?>
                             </td>
					 			<td>
					 			<?php if ($_smarty_tpl->tpl_vars['transition']->value['lower_level_config'] == '' || $_smarty_tpl->tpl_vars['transition']->value['lower_level_config'] == " " || $_smarty_tpl->tpl_vars['transition']->value['lower_level_config'] == "(?)") {?>
            						<?php if ($_smarty_tpl->tpl_vars['transition']->value['lower_level_config'] != '') {
echo $_smarty_tpl->tpl_vars['transition']->value['lower_level_energy'];
} else { ?>(?)<?php }?>
									<?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['transition']->value['lower_level_config'];?>

								<?php }?>:

					 			<?php if (($_smarty_tpl->tpl_vars['transition']->value['lower_level_termsecondpart'] != "NULL")) {
echo $_smarty_tpl->tpl_vars['transition']->value['lower_level_termsecondpart'];
}?>

					 			<?php if ($_smarty_tpl->tpl_vars['transition']->value['lower_level_termprefix'] != '') {?><sup><?php echo $_smarty_tpl->tpl_vars['transition']->value['lower_level_termprefix'];?>
</sup><?php }?>

					 			<?php if ($_smarty_tpl->tpl_vars['transition']->value['lower_level_termfirstpart'] == '' || $_smarty_tpl->tpl_vars['transition']->value['lower_level_termfirstpart'] == " ") {?> (?) <?php } else { ?><span><?php echo $_smarty_tpl->tpl_vars['transition']->value['lower_level_termfirstpart'];?>
</span><?php }?>

					 			<?php if ($_smarty_tpl->tpl_vars['transition']->value['lower_level_termmultiply'] == 1) {?><span>&deg;</span><?php }?>

					 			<?php if ($_smarty_tpl->tpl_vars['transition']->value['lower_level_j'] != '') {?><sub><?php echo $_smarty_tpl->tpl_vars['transition']->value['lower_level_j'];?>
</sub><?php }?>
					 			</td>

                                <td>
                                <?php if ($_smarty_tpl->tpl_vars['transition']->value['upper_level_config'] == '' || $_smarty_tpl->tpl_vars['transition']->value['upper_level_config'] == " " || $_smarty_tpl->tpl_vars['transition']->value['upper_level_config'] == "(?)") {?>
                                    <?php if ($_smarty_tpl->tpl_vars['transition']->value['upper_level_config'] != '') {
echo $_smarty_tpl->tpl_vars['transition']->value['upper_level_energy'];
} else { ?>(?)<?php }?>
                                    <?php } else { ?> <?php echo $_smarty_tpl->tpl_vars['transition']->value['upper_level_config'];?>

								<?php }?>:

                                <?php if ($_smarty_tpl->tpl_vars['transition']->value['upper_level_termsecondpart'] != "NULL") {
echo $_smarty_tpl->tpl_vars['transition']->value['upper_level_termsecondpart'];
}?>

                                <?php if ($_smarty_tpl->tpl_vars['transition']->value['upper_level_termprefix'] != '') {?><sup><?php echo $_smarty_tpl->tpl_vars['transition']->value['upper_level_termprefix'];?>
</sup><?php }?>

                                <?php if ($_smarty_tpl->tpl_vars['transition']->value['upper_level_termfirstpart'] == '' || $_smarty_tpl->tpl_vars['transition']->value['upper_level_termfirstpart'] == " ") {?> (?) <?php } else { ?><span><?php echo $_smarty_tpl->tpl_vars['transition']->value['upper_level_termfirstpart'];?>
</span><?php }?>

                                <?php if ($_smarty_tpl->tpl_vars['transition']->value['upper_level_termmultiply'] == 1) {?><span>&deg;</span><?php }?>

                                <?php if ($_smarty_tpl->tpl_vars['transition']->value['upper_level_j'] != '') {?><sub><?php echo $_smarty_tpl->tpl_vars['transition']->value['upper_level_j'];?>
</sub><?php }?>

                                </td>
								<?php if ($_smarty_tpl->tpl_vars['atom']->value['ENERGY_DIMENSION'] == "MHz") {?>
								<td><?php echo $_smarty_tpl->tpl_vars['transition']->value['WAVELENGTH_MHZ'];?>
</td>
								<?php } else { ?>
								<td><?php echo $_smarty_tpl->tpl_vars['transition']->value['WAVELENGTH'];?>
</td>
								<?php }?>
						        <td><?php echo $_smarty_tpl->tpl_vars['transition']->value['INTENSITY'];?>
</td>
						        <td><?php echo $_smarty_tpl->tpl_vars['transition']->value['OSCILLATOR_F'];?>
</td>
				        		<td>
				        			<?php if ($_smarty_tpl->tpl_vars['transition']->value['PROBABILITY'] != '') {?>
				        				<?php echo $_smarty_tpl->tpl_vars['transition']->value['PROBABILITY']/100000000;?>

				        			<?php }?>
				        		</td>
        		                <td><?php echo $_smarty_tpl->tpl_vars['transition']->value['CROSSECTION'];?>
</td>

								<td class="source">
                        		<?php if ($_smarty_tpl->tpl_vars['transition']->value['SOURCE_IDS'] != '') {?>
									<span class="links">
									<?php $_smarty_tpl->_assignInScope('sources', explode(",",$_smarty_tpl->tpl_vars['transition']->value['SOURCE_IDS']));?>
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
</body></html><?php }
}
