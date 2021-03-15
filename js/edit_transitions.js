if (typeof isotop === 'undefined') isotop = false;
$.fn.dataTableExt.afnFiltering.push(//wavelength
    function (oSettings, aData, iDataIndex) {

        var iMin = document.getElementById('min_2').value * 1;
        var iMax = document.getElementById('max_2').value * 1;

        var iVersion = aData[3] == "-" ? 0 : aData[3] * 1;

        if (iMin == "" && iMax == "") {
            return true;
        }
        else if (iMin == "" && iVersion <= iMax) {
            return true;
        }
        else if (iMin <= iVersion && "" == iMax) {
            return true;
        }
        else if (iMin <= iVersion && iVersion <= iMax) {
            return true;
        }

        else if (iMin == iVersion && iVersion == iMax) {
            return true;
        }

        return false;

    }
);

$.fn.dataTableExt.afnFiltering.push(//intensity
    function (oSettings, aData, iDataIndex) {

        var iMin = document.getElementById('min_3').value * 1;
        var iMax = document.getElementById('max_3').value * 1;

        var iVersion = aData[5] == "-" ? 0 : aData[5] * 1;

        if (iMin == "" && iMax == "") {
            return true;
        }
        else if (iMin == "" && iVersion <= iMax) {
            return true;
        }
        else if (iMin <= iVersion && "" == iMax) {
            return true;
        }
        else if (iMin <= iVersion && iVersion <= iMax) {
            return true;
        }

        else if (iMin == iVersion && iVersion == iMax) {
            return true;
        }

        return false;

    }
);


$.fn.dataTableExt.afnFiltering.push(//fik
    function (oSettings, aData, iDataIndex) {

        var iMin = document.getElementById('min_4').value * 1;
        var iMax = document.getElementById('max_4').value * 1;

        var iVersion = aData[6] == "-" ? 0 : aData[6] * 1;

        if (iMin == "" && iMax == "") {
            return true;
        }
        else if (iMin == "" && iVersion <= iMax) {
            return true;
        }
        else if (iMin <= iVersion && "" == iMax) {
            return true;
        }
        else if (iMin <= iVersion && iVersion <= iMax) {
            return true;
        }

        else if (iMin == iVersion && iVersion == iMax) {
            return true;
        }

        return false;

    }
);


$.fn.dataTableExt.afnFiltering.push(//Aki
    function (oSettings, aData, iDataIndex) {

        var iMin = document.getElementById('min_5').value * 1;
        var iMax = document.getElementById('max_5').value * 1;

        var iVersion = aData[7] == "-" ? 0 : aData[7] * 1;

        if (iMin == "" && iMax == "") {
            return true;
        }
        else if (iMin == "" && iVersion <= iMax) {
            return true;
        }
        else if (iMin <= iVersion && "" == iMax) {
            return true;
        }
        else if (iMin <= iVersion && iVersion <= iMax) {
            return true;
        }

        else if (iMin == iVersion && iVersion == iMax) {
            return true;
        }

        return false;

    }
);


$.fn.dataTableExt.afnFiltering.push(//Qmax
    function (oSettings, aData, iDataIndex) {

        var iMin = document.getElementById('min_6').value * 1;
        var iMax = document.getElementById('max_6').value * 1;

        var iVersion = aData[8] == "-" ? 0 : aData[8] * 1;

        if (iMin == "" && iMax == "") {
            return true;
        }
        else if (iMin == "" && iVersion < iMax) {
            return true;
        }
        else if (iMin < iVersion && "" == iMax) {
            return true;
        }
        else if (iMin < iVersion && iVersion < iMax) {
            return true;
        }

        else if (iMin == iVersion && iVersion == iMax) {
            return true;
        }

        return false;

    }
);

/*			$.fn.dataTableExt.oApi.fnGetColumnData = function ( oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty ) {
				// check that we have a column id
				if ( typeof iColumn == "undefined" ) return new Array();
	
				// by default we only wany unique data
				if ( typeof bUnique == "undefined" ) bUnique = true;
	
				// by default we do want to only look at filtered data
				if ( typeof bFiltered == "undefined" ) bFiltered = true;
	
				// by default we do not wany to include empty values
				if ( typeof bIgnoreEmpty == "undefined" ) bIgnoreEmpty = true;
	
				// list of rows which we're going to loop through
				var aiRows;
	
				// use only filtered rows
				if (bFiltered == true) aiRows = oSettings.aiDisplay; 
				// use all rows
				else aiRows = oSettings.aiDisplayMaster; // all row numbers

				// set up data array	
				var asResultData = new Array();
	
				for (var i=0,c=aiRows.length; i<c; i++) {
					iRow = aiRows[i];
					var aData = this.fnGetData(iRow);
					var sValue = aData[iColumn];
		
					// ignore empty values?
					if (bIgnoreEmpty == true && sValue.length == 0) continue;

					// ignore unique values?
					else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;
		
					// else push the value onto the result data array
					else asResultData.push(sValue);
				}			
				
				return asResultData.sort();
			};
*/


$(document).ready(function () {

    $.fn.dataTableExt.oApi.fnReloadAjax = function (oSettings, sNewSource, fnCallback) {
        if (typeof sNewSource != 'undefined' && sNewSource != null) {
            oSettings.sAjaxSource = sNewSource;
        }

        this.oApi._fnProcessingDisplay(oSettings, true);
        var that = this;

        oSettings.fnServerData(oSettings.sAjaxSource, null, function (json) {
            /* Clear the old information from the table */
            that.oApi._fnClearTable(oSettings);
            /* Got the data - add it to the table */
            for (var i = 0; i < json.aaData.length; i++) {
                that.oApi._fnAddData(oSettings, json.aaData[i]);
            }

            oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
            that.draw(that);
            that.oApi._fnProcessingDisplay(oSettings, false);

            /* Callback user function - for event handlers etc */
            if (typeof fnCallback == 'function') {
                fnCallback(oSettings);
            }
        });
    }

//�������� ������� � ����������� �� ������				

    if (locale == "en") dataTableslib = {
        "lengthMenu": "Show _MENU_ records per page",
        "zeroRecords": "No entries",
        "info": "Entries from _START_ to _END_ of _TOTAL_",
        "infoEmtpy": "Entries from 0 to 0 of 0",
        "infoFiltered": "(Filtred from _MAX_ entries)",
        "paginate": {
            "first": "&lt;&lt;",
            "previous": "&lt;",
            "next": "&gt;",
            "last": "&gt;&gt;"
        }
    };

    if (locale == "ru") dataTableslib = {
        "lengthMenu": "�������� _MENU_ ������� �� ��������",
        "zeroRecords": "������ �����������",
        "info": "������ � _START_ �� _END_ �� _TOTAL_ �������",
        "infoEmtpy": "������ � 0 �� 0 �� 0 �������",
        "infoFiltered": "(������������� �� _MAX_ �������)",
        "paginate": {
            "first": "&lt;&lt;",
            "previous": "&lt;",
            "next": "&gt;",
            "last": "&gt;&gt;"
        }
    };

    var oTable = $('#table1').DataTable({
        "order": [[isotop?4:3, "asc"]],
        "dom": 'l<"toolbar">rtip',
        "language": dataTableslib,
        "columns": [
            /*{ "fnRender": function ( oObj ) {
                return oObj.aData[0].replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");
            } },*/
            {},//serie
            {
                "render": function (oObj) {
                    return String(oObj).replace(/@\{([^\}\{]*)\}/gi, "<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi, "<sub>$1</sub>").replace(/\s/gi, "");
                }
            },//Lower level
            {
                "render": function (oObj) {
                    return String(oObj).replace(/@\{([^\}\{]*)\}/gi, "<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi, "<sub>$1</sub>").replace(/<sup><suf>1<\/sup>/gi, "").replace(/\s/gi, "");
                }
            },//Upper level
            {
                "render": function (oObj) {
                    if (String(oObj) != "")
                        return Number(oObj);
                    else return "";
                },
                "type": "numeric"
            },//Wavelength
            {
                "render": function (oObj) {
                    if (String(oObj) != "")
                        return Number(oObj);
                    else return "";
                },
                "type": "numeric"
            },//Wavelength in MHz
            {
                "type": "numeric",
                "render": function (oObj) {
                    if (String(oObj) != "")
                        return Number(oObj);
                    else return "";
                }
            },//intensity
            {
                "type": "numeric",
                "render": function (oObj) {
                    if (String(oObj) != "")
                        return Number(oObj);
                    else return "";
                }
            },//fik
            {
                /*	"fnRender": function ( oObj ) {
                        var str= oObj.aData[5];
                        str = str.replace(",", ".");
                        str = parseFloat(str);
                        if (!isNaN(str)) str = str; else str="";

                        return str
                        },			*/
                "type": "numeric",
                "render": function (oObj) {
                    if (String(oObj) != "")
                        return Number(oObj);
                    else return "";
                }
            },//Aki
            {
                "type": "numeric",
                "render": function (oObj) {
                    if (String(oObj) != "")
                        return Number(oObj);
                    else return "";
                }
            },//Qmax
            {"type": "html"},//source by string
            {"type": "html"}//source
        ],

        "pageLength": 25,
        "lengthChange": true,
        "searching": true,
        "processing": true,
        "pagingType": "full_numbers",
        "initComplete": function () {
            // Make custom toolbar
            $("div.toolbar").html('<input class="button white" id="saveTransitions" value="' + SaveLevels + '" type="button"><input class="button white" id="deleteTransitions" value="' + DeleteLevels + '" type="button"><input class="button white" id="createTransition" value="' + CreateLevel + '" type="button">');
        }
    });

    /* Add event listeners to the two range filtering inputs */

    $('#min_6').keyup(function () {
        oTable.draw();
    });
    $('#max_6').keyup(function () {
        oTable.draw();
    });
    $('#min_2').keyup(function () {
        oTable.draw();
    });
    $('#max_2').keyup(function () {
        oTable.draw();
    });
    $('#min_3').keyup(function () {
        oTable.draw();
    });
    $('#max_3').keyup(function () {
        oTable.draw();
    });
    $('#min_4').keyup(function () {
        oTable.draw();
    });
    $('#max_4').keyup(function () {
        oTable.draw();
    });
    $('#min_5').keyup(function () {
        oTable.draw();
    });
    $('#max_5').keyup(function () {
        oTable.draw();
    });

    function addSelection(transition) {
        var lower_level_config, upper_level_config, wavelength, intensity, f_ik, a_ki, excitation, source;
        //alert("dfg");
        if (!transition.hasClass('row_selected')) {

            transition.removeClass('selectable').addClass('row_selected').find(':checkbox').attr('checked', 'checked');

            transition.children('.lower_level_config').data("cfg", transition.children('.lower_level_config').html());
            transition.children('.lower_level_config').html('<a href="#" class=" button white" id="select_lower_level">�������</a>');

            transition.children('.upper_level_config').data("cfg", transition.children('.upper_level_config').html());
            transition.children('.upper_level_config').html('<a href="#" class="button white" id="select_upper_level">�������</a>');

            wavelength = transition.children('.wavelength').text();
            transition.children('.wavelength').html('<input size="" type="text" name="wavelength[]" value="' + wavelength + '"/>');

            wavelength_mhz = transition.children('.wavelength_mhz').text();
            transition.children('.wavelength_mhz').html('<input size="" type="text" name="wavelength_mhz[]" value="' + wavelength_mhz + '"/>');

            intensity = transition.children('.intensity').text();
            transition.children('.intensity').html('<input size="" type="text" name="intensity[]" value="' + intensity + '"/>');

            f_ik = transition.children('.f_ik').text();
            transition.children('.f_ik').html('<input size="" type="text" name="f_ik[]" value="' + f_ik + '"/>');

            a_ki = transition.children('.a_ki').text();
            transition.children('.a_ki').html('<input size="" type="text" name="a_ki[]" value="' + a_ki + '"/>');

            excitation = transition.children('.excitation').text();
            transition.children('.excitation').html('<input size="" type="text" name="excitation[]" value="' + excitation + '"/>');

            bibliolink = transition.children('.bibliolink').html();
            transition.children('.bibliolink').html('<input size="" type="text" name="bibliolink[]" value="' + bibliolink + '"/>');

            if (transition.find('.links').children('a').html() != null) {
                transition.children('.source').data("source", transition.find('.links').html());
                var buttons = '<span id="buttons"><a href="#" class="button white" id="add_source">+</a><a class="button white" id="remove_source">-</a></span>';
            } else var buttons = '<span id="buttons"><a href="#" class="button white" id="add_source">+</a></span>';

            transition.children('.source').append(buttons);
            //alert(level.children('.source').data("source"));

        }
    }


    function removeSelection(transition) {
        var lower_level_config, upper_level_config, wavelength, intensity, f_ik, a_ki, excitation, source;

        transition.removeClass('row_selected').addClass('selectable').find(':checkbox').removeAttr('checked');

        transition.children('.wavelength').html(transition.children('.wavelength').children().prop('value'));
        transition.children('.wavelength_mhz').html(transition.children('.wavelength_mhz').children().prop('value'));
        transition.children('.intensity').html(transition.children('.intensity').children().prop('value'));
        transition.children('.f_ik').html(transition.children('.f_ik').children().prop('value'));
        transition.children('.a_ki').html(transition.children('.a_ki').children().prop('value'));
        transition.children('.excitation').html(transition.children('.excitation').children().prop('value'));

        if (transition.children('.lower_level_config').data("cfg")) {
            transition.children('.lower_level_config').html(transition.children('.lower_level_config').data("cfg"));
        } else transition.children('.lower_level_config').html('');

        if (transition.children('.upper_level_config').data("cfg")) {
            transition.children('.upper_level_config').html(transition.children('.upper_level_config').data("cfg"));
        } else transition.children('.upper_level_config').html('');

        bibliolink = transition.children('.bibliolink').children().prop('value');
        transition.children('.bibliolink').html(bibliolink);

        if (transition.children('.source').data("source")) {
            transition.children('.source').html('<span class="links">' + transition.children('.source').data("source") + "</span>");
        } else transition.children('.source').html('<span class="links"></span>');


    }

    function levelsTableSort(energyValue, lowerUpper, termMultiply) {
        //alert(energyValue+"\n"+lowerUpper+"\n"+termMultiply);
        //oTableLevels.fnFilter("109",4);
    }

    /* Add a click handler to the rows - this could be used as a callback */

    $(document).on("click", "tr.selectable td:not(.source)", function () {
        addSelection($(this).parent());
    });

    $(document).on("click", ".row_selected input:checkbox", function () {
        removeSelection($(this).parent().parent());
    });


    $("#saveTransitions").click(function () {
        /*
                        var hasemptybib = false;
                        $('.row_selected ').each(function() {
                            if (!$(this).children('.source').data("source") && !$(this).children('.bibliolink').children().prop("value")){
                                hasemptybib = true;
                            }
                        });
                        if (hasemptybib) {
                            alert("��������� ������� ����������! ����� ��������� ���������, ��� ���������� ���������� ������ �� ��������! ��� ��� �������, ����� �������� � ����� ��� �����. �������� ���!");
                            return;
                        }
        commented after megascandal with yatsenko*/

        var str = $(".row_selected input").serialize();
        str += "&action=saveTransitions&count=" + $(".row_selected .row_id").length;
        $.post("/transitions_admin.php", str, function (data) {
            $('.row_selected').each(function () {
                //console.log(data);
                removeSelection($(this));
            });
        });

    });


    $("#deleteTransitions").click(function () {
        var str = $(".row_selected .row_id").serialize() + "&action=deleteTransitions";

        if (confirm('������� ��������� ��������?')) {
            $.post("/transitions_admin.php", str, function (data) {
                $(".row_selected").remove();
                //alert(data);
            });
        }
    });

    $("#createTransition").click(function () {
        if (confirm('������� ����� �������?')) {
            var atom_id = $("#atom_id").val();
            //alert(atom_id);
            $.post("/transitions_admin.php", {atom_id: atom_id, action: "createTransition"}, function (data) {
                //alert(data);
                if ($('tr:first').hasClass("odd")) p = "even"; else p = "odd";
                //var str ='<tr class="'+p+' row_selected"><input type="hidden" class="level_id" name="level_id[]" value="'+data+'"><td class=""><input type="checkbox" checked="checked"></td><!--  <td></td>--><td id="level_config" class=" sorting_1"><input size="" type="text" name="level_config[]" value=""></td><td id="term"><input size="1" type="text" id="termPrefix" name="termPrefix[]" value=""><input size="1" type="text" id="termFirstpart" name="termFirstpart[]" value=""><input size="1" type="text" id="termMultiply" name="termMultiply[]" value=""></td><td id="j"><input size="" type="text" name="j[]" value=""></td><td id="energy"><input size="" type="text" name="energy[]" value=""></td><td id="lifetime"><input size="" type="text" name="lifetime[]" value=""></td><td id="source"><a href="#" class="button white" id="add_source">+</a><a class="button white" id="remove_source">-</a></td></tr>';
                var str = '<tr class="' + p + ' row_selected"><input type="hidden" class="row_id" name="row_id[]" value="' + data + '">' +
                    '<td class=""><input type="hidden" class="lower_level_id" value=""/>' +
                    '<input type="hidden" class="upper_level_id" value="" />' +
                    '<input type="checkbox" checked="true"></td>' +
                    '<td class="lower_level_config"><a href="#" class="button white" id="select_lower_level">�������</a></td>' +
                    '<td class="upper_level_config"><a href="#" class="button white" id="select_upper_level">�������</a></td>' +
                    '<td class="wavelength"><input size="" type="text" name="wavelength[]" value=""></td>' +
                    '<td class="wavelength_mhz"><input size="" type="text" name="wavelength_mhz[]" value=""></td>' +
                    '<td class="intensity"><input size="" type="text" name="intensity[]" value=""></td>' +
                    '<td class="f_ik"><input size="" type="text" name="f_ik[]" value=""></td>' +
                    '<td class="a_ki"><input size="" type="text" name="a_ki[]" value=""></td>' +
                    '<td class="excitation"><input size="" type="text" name="excitation[]" value=""></td>' +
                    '<td class="bibliolink"><input size="" type="text" name="bibliolink[]" value=""></td>' +
                    '<td class="source"><span id="links"></span><span id="buttons"><a href="#" class="button white" id="add_source">+</a></span></td></tr>';
                //alert (str);
                $('#table1').prepend(str);

                //window.location.href = "/admin/ru/element/"+data;
            });
        }
    });


    /*			$("#select_upper_level").live("click", function(){
                    var n = 0;
                    var transition = $(this).parent().parent();
                    var atom_id = $("#atom_id").val();
                    var transition_id=transition.find('.row_id').val();
                    energyValue=transition.find('.lower_level_energy').val();
                    isUpperOrLower="is_upper";
                    isOtherLevel = transition.find('.lower_level_config').data("cfg");
                    termmultiplyValue=transition.find('.lower_level_termmultiply').val()+"a";

                    $.fancybox.showLoading();

                    $.post("/levels_admin.php",  {atom_id: atom_id , action: "manageLevel"}, function(data){
                        $.fancybox(data,{
                            'hideOnContentClick': false,
                            'overlayColor'		: '#000',
                            'overlayOpacity'	: 0.8
                        });
                    });


                    $('#levels_table tbody tr').live("click", function(){
                        if (n == 0){
                            n = 1;
                            if (confirm('��������� ���� �������?')) {
                                var level_id = $(this).children('.row_id').val();
                                //	alert("transition_id="+transition_id+"level_di="+level_id);
                                $.post("/transitions_admin.php",  { transition_id:transition_id,level_id:level_id , action: "setUpperLevel" },function(data) {
                                    //	alert(transition.find('.upper_level_config').data("cfg"));
                                    data=data.replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");
                                    transition.find('.upper_level_config').data("cfg", data);
                                    parent.$.fancybox.close();
                                });

                            }
                        }
                    });
                });	*/

    /*$("#select_lower_level").live("click", function(){
        var n = 0;
        var transition = $(this).parent().parent();
        var atom_id = $("#atom_id").val();
        var transition_id=transition.find('.row_id').val();
        energyValue=transition.find('.upper_level_energy').val();
        isUpperOrLower = "is_lower";
        isOtherLevel = transition.find('.upper_level_config').data("cfg");
        //alert(isOtherLevel);
        //console.log(isOtherLevel);
        termmultiplyValue=transition.find('.upper_level_termmultiply').val()+"a";
        $.fancybox.showLoading();

        $.post("/levels_admin.php", {atom_id: atom_id , action: "manageLevel"}, function(data){
            alert(data);
            $.fancybox(data,{
                'hideOnContentClick': false,
                'overlayColor'		: '#000',
                'overlayOpacity'	: 0.8
            });
        });

        $('#levels_table tbody tr').live("click", function(){
            if (n == 0){
                n = 1;

                if (confirm('��������� ���� �������?')) {
                    var level_id = $(this).children('.row_id').val();
                    //alert("transition_id="+row_id+"level_di="+level_id+"atom_id="+atom_id);
                    //alert("transition_id:"+transition_id+"level_id:"+level_id+"action: setLowerLevel");
                    $.post("/transitions_admin.php",  { transition_id:transition_id,level_id:level_id , action: "setLowerLevel"},function(data) {
                        data=data.replace(/@\{([^\}\{]*)\}/gi,"<sup>$1</sup>").replace(/~\{([^\}\{]*)\}/gi,"<sub>$1</sub>").replace(/\s/gi,"");
                        transition.find('.lower_level_config').data("cfg", data);
                        parent.$.fancybox.close();
                    });
                }
            }
        });
    });	*/

    $(document).on("click", "#select_lower_level", function (event) {
        event.preventDefault();
        var position = "lower";
        var transition = $(this).parent().parent();
        var atom_id = $("#atom_id").val();
        var transition_id = transition.find('.row_id').val();
        var level_id;
        var str;
        $('.clicked').removeClass('clicked');
        transition.addClass("clicked");

        if (transition.find('.upper_level_config').data("cfg")) {
            level_id = transition.find('.upper_level_id').val();
            str = '../addlevels/' + atom_id + '/' + transition_id + '/' + position + '/' + level_id;
        } else str = '../addlevels/' + atom_id + '/' + transition_id + '/' + position;

        $.fancybox({
            'href': str,
            'width': '75%',
            'height': '75%',
            'autoScale': false,
            'type': 'iframe',
            'hideOnContentClick': false
        });
    });

    $(document).on("click", "#select_upper_level", function (event) {
        event.preventDefault();
        var position = "upper";
        var transition = $(this).parent().parent();
        var atom_id = $("#atom_id").val();
        var transition_id = transition.find('.row_id').val();
        var level_id;
        var str;
        $('.clicked').removeClass('clicked');
        transition.addClass("clicked");

        if (transition.find('.lower_level_config').data("cfg")) {
            level_id = transition.find('.lower_level_id').val();
            str = '../addlevels/' + atom_id + '/' + transition_id + '/' + position + '/' + level_id;
        } else str = '../addlevels/' + atom_id + '/' + transition_id + '/' + position;

        $.fancybox({
            'href': str,
            'width': '75%',
            'height': '75%',
            'autoScale': false,
            'type': 'iframe',
            'hideOnContentClick': false
        });
    });


});