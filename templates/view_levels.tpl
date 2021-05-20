<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
	<script type="text/javascript" src="js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="js/fancybox/jquery.mousewheel-3.0.6.pack.js"></script>
	<script type="text/javascript" src="js/fancybox/jquery.fancybox.pack.js"></script>
	<!--[if IE 7]><script type="text/javascript" src="js/jquery.dropdown.js"></script><![endif]-->
	<!--[if IE 6]><script type="text/javascript" src="js/jquery.dropdown.js"></script><![endif]-->
	<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/table.css" />
	<script type="text/javascript" src="js/tablexport.js"></script>
	<script type="text/javascript" src="js/bibtex_js.js"></script>
	<script type="text/javascript" charset="windows-1251">var locale="en";</script>
	<script type="text/javascript" charset="windows-1251" src="js/levels.js?v5"></script>
</head>
<body>
			<div id="tab">
				<div id="panel" >
		    		<div class="container_12">
						<div class="grid_7">
            				<h4>{$l10n.Table_lookup}:</h4>
	               			<table class="search_form">
								<tbody>
				                	<tr>
				                    	  <td></td>
                                          <td align="center"><div class="froam">{$l10n.from}</div><div class="froam" >{$l10n.to}</div></td>
					                </tr>
									<tr>
										<td class="name">{$l10n.Energy}:</td>
										<td>
				                        	<input size="12" id="min_3" name="min_3"  type="text"/>
											<input size="12" id="max_3" name="max_3"  type="text"/>
										</td>

									</tr>

									<tr>
										<td class="name">{$l10n.ConfigurationType}:</td>
										<td>
											<select id="configurationType" name="configurationType" style="width: 210px">
												<option>&nbsp;</option>
											</select>
										</td>

									</tr>
									<tr>
										<td class="name">{$l10n.Configuration}:</td>
										<td>
											<select id="configurationSelect" name="configurationSelect" style="width: 210px">
												<option>&nbsp;</option>
											</select>
										</td>

									</tr>
									<tr>
										<td class="name">{$l10n.Term}:</td>
										<td>
											<select id="termSelect" name="termSelect" style="width: 210px">
												<option>&nbsp;</option>
											</select>
										</td>

									</tr>
									<tr>
										<td class="name"> {$l10n.Jvalue}:</td>
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
								{if $atom.ENERGY_DIMENSION=="MHz" }
								<th>Energy (MHz)</th>
								{else}
								<th>Energy ( cm <sup>-1</sup>)</th>
								{/if}
								<th>Lifetime <br/>(ns)</th>
								<th>Source</th>
							</tr>
						</thead>

                    {foreach item=level from=$level_list}
					<tr class="selectable">
						<!-- <td><input type="checkbox" name="selected_tbl[]" value="aliases" /></td>  -->
						<td>{if $level.config_type} {$level.config_type} {else} (?) {/if}</td>
					 	<td>{if $level.CONFIG ==NULL || $level.CONFIG ==""} (?) {else} {$level.CONFIG} {/if} </td>
				        <td>
				        {if $level.TERMSECONDPART!="NULL" }<span>{$level.TERMSECONDPART}</span>{/if}
						{if $level.TERMPREFIX!="" }<sup>{$level.TERMPREFIX}</sup>{/if}
				        {if $level.TERMFIRSTPART=="" || $level.TERMFIRSTPART==" " }(?){else}<span>{$level.TERMFIRSTPART}</span>{/if}
				        {if $level.TERMMULTIPLY == TRUE}<sup>o</sup>{/if}

				        </td>
                        <td>{$level.J}</td>
						<td>{$level.F}</td>
                        {if $atom.ENERGY_DIMENSION=="MHz" }
						<td>{$level.ENERGY_MHZ}</td>
                        {else}
						<td>{$level.ENERGY}</td>
                        {/if}
                        <td>{$level.LIFETIME}</td>
                        <td class="source">
                        {if $level.SOURCE_IDS !='' }
							<span class="links">
							{assign var=sources value=","|explode:$level.SOURCE_IDS}
							{foreach from=$sources item=source}
								{if $source !='' }
									<a class="source_link various fancybox.ajax" href="../bibliography/{$source}" >{$source}</a>
								{/if}
							{/foreach}
							</span>
						{/if}
                       	</td>
                    </tr>
                    {/foreach}
		    		</table>
			</div>
</body>
</html>