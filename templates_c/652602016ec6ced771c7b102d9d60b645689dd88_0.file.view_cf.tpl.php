<?php
/* Smarty version 3.1.39, created on 2021-02-25 22:28:25
  from 'Z:\home\localhost\www\libjson\templates\view_cf.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.39',
  'unifunc' => 'content_6037b409434604_50310439',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '652602016ec6ced771c7b102d9d60b645689dd88' => 
    array (
      0 => 'Z:\\home\\localhost\\www\\libjson\\templates\\view_cf.tpl',
      1 => 1614263297,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6037b409434604_50310439 (Smarty_Internal_Template $_smarty_tpl) {
?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo '<script'; ?>
 type="text/javascript" src="js/jquery-1.11.2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="js/fancybox/jquery.mousewheel-3.0.6.pack.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" src="js/fancybox/jquery.fancybox.pack.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/cf/chart.js/dist/Chart.bundle.js?v2"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/cf/hammer.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="js/cf/chartzoom/chartjs-plugin-zoom.js"><?php echo '</script'; ?>
>

</head>
<body>

<div class="container_12">

	<div class="grid_12" id="main">
		<div class="brake"></div>
		<div>
			<div id='toolbar'>
				<div id='range'>
					<div id='min_container'>
						<b>Min Length (&#8491;)</b><br>
						<input type='text' id='min' value='<?php if ($_smarty_tpl->tpl_vars['auto']->value == true) {?>3000<?php } else { ?>0<?php }?>'>
					</div>
					<div id='max_container'>
						<b>Max Length (&#8491;)</b><br>
						<input type='text' id='max' value='<?php if ($_smarty_tpl->tpl_vars['auto']->value == true) {?>8000<?php } else { ?>30000<?php }?>'>
					</div>
					<div class='top_div'>
						<input type='button' id='filter' value='OK' class="bluebtn" onclick="show_selected()">
					</div>
					<div id='visible_container' style="clear:both; margin-top: 10px;">
						<input type='button' id='visible' value='Visible Spectrum' class='bluebtn'  onclick="show_visible()"><span style="width: 20px"></span>
						<input type='button' id='all_spectrum' value='All Spectrum' class='bluebtn' onclick="show_all()">
					</div>

				</div>
				<div id='zoom_container' style="display:none">
					<b>Scale</b><br>
					<input type='button' id='x1' value='1' class='bluebtn base active'>
					<input type='button' value='10' class='bluebtn base'>
					<input type='button' value='100' class='bluebtn base'>
					<br><br>
					<input type='button' id='x2' value='x2' class="bluebtn <?php if ($_smarty_tpl->tpl_vars['auto']->value == true) {?>active<?php }?>">
					<input type='button' value='x5' class="bluebtn">
				</div>
				<div>
					<input type='button' id='barchart' style="display:none" value='BarChart' class="bluebtn <?php if ($_smarty_tpl->tpl_vars['auto']->value == true) {?>active<?php }?>"><br><br>
					<div id="series"></div>
				</div>
			</div>

		</div>
	</div>
</div>
<div class="clear"> </div>
<div id="chartCont" class="chartCont">
	<canvas id="canvas" width="600" height="600"></canvas>
</div>

<div class="tools">
	<div class="nav">
		<div id="chartZoom" class="chartZoom" >
			<canvas id="zoom_chart" width="250" height="200"></canvas>
		</div>
	</div>
	<div class="nav">
		<table border="0">
			<tbody>
			<tr>
				<td><b>lower level: </b></td>
				<td id="low_l"></td>
			</tr>
			<tr>
				<td><b>upper level: </b></td>
				<td id="up_l"></td>
			</tr>
			</tbody>
		</table>
	</div>
	<div id="first_cont">
		<div class="nav">
			<input type='button' id="resetZoom" value="Reset Zoom" >
		</div>
		<div class="nav">
			<input type='button' id="fullScreen" value="Full screen" onclick="resize(1)">
		</div>
		<div class="nav">
			<input type="radio" name="myRadios"  value="1" checked/>[1/cm]
			<input type="radio" name="myRadios"  value="2" />[eV]
		</div>
	</div>
	<div id="second_cont">
		<div class="nav">
			<div class="radio_buttons">
				<div>
					<input type="radio" name="option" id="eUp" checked>
					<label for="eUp" >y=E<sub>up</sub>, x=E<sub>l</sub></label>
				</div>
				<div>
					<input type="radio" name="option" id="parity"/>
					<label for="parity">Parity of term</label>
				</div>
				<div>
					<input type="radio" name="option" id="eUp_eD"/>
					<label for="eUp_eD">y=E<sub>up</sub> - E<sub>l</sub>, x=E<sub>l</sub></label>
				</div>
			</div>
		</div>
	</div>
	<div class="nav">
		<input type="checkbox"  id="intens" value=1 onclick="click_intens()" checked>display intensity by transparency
	</div>
	<div class="nav">
		<input type="checkbox"  id="random" value=1 onclick="click_random()"> display multiplets
	</div>
	<div class="nav">
		<table>
			<tr>
				<td>
					Show Width:
				</td>
				<td>
					<input type="radio" name="width" value="1"/>configuration<br>
					<input type="radio" name="width" value="2"/>
					configurations with atomic residues<br>
					<input type="radio" name="width" value="3"/>terms<br>
					<input type="radio" name="width" value="4" checked/>---<br>
				</td>
			</tr>
		</table>
	</div>
</div>



<div id="canvas-holder" style="width: 300px;">
	<div id="chartjs-tooltip">
		<table></table>
	</div>
</div>

<div id="canvas-holder1" style="width: 300px;">
	<div id="zoom-tooltip">
		<table></table>
	</div>
</div>

<?php echo '<script'; ?>
>
	var atom = {} ;
	<?php if (($_smarty_tpl->tpl_vars['atom_json']->value)) {?>
	var atom_json = <?php echo $_smarty_tpl->tpl_vars['atom_json']->value;?>
;
	atom.atom = atom_json;
	<?php }?>
	<?php if (($_smarty_tpl->tpl_vars['transitions_json']->value)) {?>
	var transitions_json = <?php echo $_smarty_tpl->tpl_vars['transitions_json']->value;?>
;
	atom.transitions = transitions_json;
	<?php }?>
	<?php if (($_smarty_tpl->tpl_vars['levels_json']->value)) {?>
	var levels_json = <?php echo $_smarty_tpl->tpl_vars['levels_json']->value;?>
;
	atom.levels = levels_json;
	<?php }?>

<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/libjson/js/cf.js?v2"><?php echo '</script'; ?>
>

<div class="clear"> </div> <br><br><br><br>
</body></html><?php }
}
