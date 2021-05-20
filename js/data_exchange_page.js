    var select_elements = document.getElementById("elements");
    var select_ionization = document.getElementById("ionization");
    var select_ionization_potencial = document.getElementById("ionization_potencial");

    select_elements.addEventListener("change", function(){
        var index = select_elements.options.selectedIndex;
        var element_abbr = select_elements.options[index].value;

        $(select_ionization_potencial).empty();
        $(select_ionization_potencial).append('<option value="">Choose ionization potencial:</option>');
        loadIonizationList(element_abbr);
    });

    select_ionization.addEventListener("change", function(){
        var index = select_elements.options.selectedIndex;
        var element_abbr = select_elements.options[index].value;

        var index2 = select_ionization.options.selectedIndex;
        var ionization = select_ionization.options[index2].value;

        //alert( "Value= " + element_abbr);
        loadIonizationPotencialList(element_abbr, ionization);
    });

    function loadIonizationList(element_abbr) {
        //alert( "function " + element_abbr);
        $.ajax({
            url: "ionization_list.php",
            data: {element_abbr},
            // файл, к которому обращается скрипт
            success: function (data) {
                data = JSON.parse(data);
                console.log(data);
                //alert( "success" + element_abbr);
                $(select_ionization).empty();
                console.log(select_ionization);

                $(select_ionization).append('<option value=\"\">Choose ionization:</option>');
                for (var i in data) {
                    var option = document.createElement("option");
                    option.setAttribute("value", data[i]);
                    option.text = data[i];
                    select_ionization.appendChild(option);
                }
            }
        })
    }

    function loadIonizationPotencialList(element_abbr, ionization) {
        //alert( "function " + element_abbr);
        $.ajax({
            url: "ionization_potencial_list.php",
            data: {element_abbr, ionization},
            // файл, к которому обращается скрипт
            success: function (data) {
                data = JSON.parse(data);
                console.log(data);
                //alert( "success" + element_abbr);
                $(select_ionization_potencial).empty();
                $(select_ionization_potencial).append('<option value="">Choose ionization potencial:</option>');
                console.log(select_ionization_potencial);
                for (var i in data) {
                    var option = document.createElement("option");
                    option.setAttribute("value", data[i]);
                    option.text = data[i];
                    select_ionization_potencial.appendChild(option);
                    if(data[i] == null) {
                        alert('Атомной системы с такими данными нет! Выберите другие параметры!');
                    }
                }

            }
        })
    }
