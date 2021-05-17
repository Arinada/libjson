<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
	<script type="text/javascript" src="js/transitions.js?v3"></script>
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
                                {if ($atom.ENERGY_DIMENSION=='MHz')}
								<th>Wavelength [MHz]</th>
                                {else}
								<th>Wavelength [<i>&#197;</i>]</th>
                                {/if}
								<th>Intensity</th>
								<th><i>f<sub>ik</sub></i></th>
					            <th>A<sub><i>ki</i></sub><br/>[<i>10<sup>8</sup>сек<sup>-1</sup></i>]</th>
					            <th>Excitation cross section <br/> Q<sub>max</sub>* 10<sup>18</sup>, <i>{$l10n.cm}<sup>2</sup></i></th>
								<th>Source</th>
							</tr>
						</thead>

                        {foreach item=transition from=$transition_list}
                             <tr>
                             <td>
                            	{if ($transition.lower_level_config=="" || $transition.lower_level_config==" ")}(?)
                            	{else} {$transition.lower_level_config}
						 			{if $transition.upper_level_config_type} - {$transition.upper_level_config_type} {/if}
								{/if}
                             </td>
					 			<td>
					 			{if $transition.lower_level_config=="" || $transition.lower_level_config==" " || $transition.lower_level_config=="(?)"}
            						{if $transition.lower_level_config!=""}{$transition.lower_level_energy}{else}(?){/if}
									{else} {$transition.lower_level_config}
								{/if}:

					 			{if ($transition.lower_level_termsecondpart!="NULL")}{$transition.lower_level_termsecondpart}{/if}

					 			{if $transition.lower_level_termprefix!=""}<sup>{$transition.lower_level_termprefix}</sup>{/if}

					 			{if $transition.lower_level_termfirstpart=="" || $transition.lower_level_termfirstpart==" "} (?) {else}<span>{$transition.lower_level_termfirstpart}</span>{/if}

					 			{if $transition.lower_level_termmultiply==1}<span>&deg;</span>{/if}

					 			{if $transition.lower_level_j!=""}<sub>{$transition.lower_level_j}</sub>{/if}
					 			</td>

                                <td>
                                {if $transition.upper_level_config=="" || $transition.upper_level_config==" " || $transition.upper_level_config=="(?)"}
                                    {if $transition.upper_level_config!=""}{$transition.upper_level_energy}{else}(?){/if}
                                    {else} {$transition.upper_level_config}
								{/if}:

                                {if $transition.upper_level_termsecondpart!="NULL"}{$transition.upper_level_termsecondpart}{/if}

                                {if $transition.upper_level_termprefix!=""}<sup>{$transition.upper_level_termprefix}</sup>{/if}

                                {if $transition.upper_level_termfirstpart=="" || $transition.upper_level_termfirstpart==" "} (?) {else}<span>{$transition.upper_level_termfirstpart}</span>{/if}

                                {if $transition.upper_level_termmultiply==1}<span>&deg;</span>{/if}

                                {if $transition.upper_level_j!=""}<sub>{$transition.upper_level_j}</sub>{/if}

                                </td>
								{if $atom.ENERGY_DIMENSION=="MHz" }
								<td>{$transition.WAVELENGTH_MHZ}</td>
								{else}
								<td>{$transition.WAVELENGTH}</td>
								{/if}
						        <td>{$transition.INTENSITY}</td>
						        <td>{$transition.OSCILLATOR_F}</td>
				        		<td>
				        			{if $transition.PROBABILITY!=""}
				        				{$transition.PROBABILITY/100000000}
				        			{/if}
				        		</td>
        		                <td>{$transition.CROSSECTION}</td>

								<td class="source">
                        		{if $transition.SOURCE_IDS !=''}
									<span class="links">
									{assign var=sources value=","|explode:$transition.SOURCE_IDS}
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
</body></html>