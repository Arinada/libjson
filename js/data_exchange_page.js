
    var select = document.getElementById("elements");

    select.addEventListener("change", function(){
        var index = document.getElementById("elements").options.selectedIndex;
        var element_abbr = document.getElementById("elements").options[index].value;

        //alert( "Value= " + val);
        load(element_abbr);
    });

    function load(element_abbr) {
        $.ajax({
            url: "ionization_list.php",
            data: {element_abbr},
            // файл, к которому обращается скрипт
            success: function (data) {
                var ionization_select = document.getElementById("ionizations");
                ionization_select.add(data);
                for (var i in data) {
                    var option = document.createElement("option");
                    option.setAttribute("value", data[i]);
                    option.text = data[i];
                    ionization_select.appendChild(option);
                }
                ionization_select=this.appendChild(select);

            }
        })
    }
