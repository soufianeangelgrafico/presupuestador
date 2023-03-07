$("#menu_instalaciones_movil").click(function() {
    //Cojo todos los muros creados y los añado a todos los elementos 
    //de instalaciones y equipamiento en el que podrán seleccionar los muros a los que van ese elemento
    var paredes = "";
    var i = 0;
    $(".info_muro").each(function() {
        //$(this).text();
        //paredes=paredes+" <span class='checkmuro'><input type='checkbox' name='paredes[]' class='paredes' value='"+$(this).text()+"'> "+$(this).text()+"</span>";

        //Si no existe se muro, creámelo, y si no, no hagas nada
        //Esto es así xq si no me reinicia todos los input y lo que hayas marcado se elimina
        if (!$("input[value='" + $(this).text() + "']").length) {
            $(".form_muros").append("<span class='checkmuro'><input type='checkbox' name='paredes[]' class='paredes' value='" + $(this).text() + "'> " + $(this).text() + "</span>");
        }
    })
    //$(".form_muros > .checkmuro").remove(); 
})

$("#menu_trabajos").click(function() {
    //Cojo todos los muros creados y los añado a todos los elementos 
    //de instalaciones y equipamiento en el que podrán seleccionar los muros a los que van ese elemento
    var paredes = "";
    var i = 0;
    $(".info_muro").each(function() {
        const replacers = {
            Pared: ' ',
            A: ' ',
            B: ' ',
            C: ' ',
            D: ' ',
            E: ' ',
            F: ' ',
            G: ' ',
            H: ' ',
            I: ' ',
            J: ' ',
            K: ' ',
            L: ' ',
            M: ' ',
            N: ' ',
            O: ' ',
            P: ' ',
            Q: ' ',
            R: ' ',
            S: ' ',
            T: ' ',
            U: ' ',
            V: ' ',
            W: ' ',
            X: ' ',
            Y: ' ',
            Z: ' ',
            m: ' '
        }
        const stringArr = $(this).text().split(' ');
        const result_metros = stringArr.map(word => replacers[word] ? replacers[word] : word).join(' ')

        //Si no existe se muro, creámelo, y si no, no hagas nada
        //Esto es así xq si no me reinicia todos los input y lo que hayas marcado se elimina
        if (!$("input[value='" + $(this).text() + "']").length) {
            $(".form_muros").append("<span class='checkmuro'><input type='checkbox' name='paredes[]' class='paredes' value='" + $(this).text() + "'> " + $(this).text() + "<br/><input class='child' name='seleccion_metros' type='checkbox' value='" + $(this).text() + "'> Completa <br/> <input name='seleccion_metros' class='" + $(this).text() + "' type='checkbox' value='parcial'> Parcial <input type='range' value='0.1' min='0.1' name='metros_parcial' class='" + $(this).text() + "' max='" + result_metros.trim() + "' step='0.01' oninput='this.nextElementSibling.value = this.value'> <output style='display:none'></output></span>");
        }

        //Ahora que ha creado todos los muros, debo mirar si algún muro lo había marcado como "Tabique a demoler" (lo sé porque el fill es de color #f08675) o como muro nuevo (lo sé porque el fill es de color green). Si hay alguno marcado, el elemento de picado desescombro de tabiquería (en trabajos realizados) debe tener marcado por defecto esta pared.
        $(".muro").each(function() {
            var pared = "";
            switch (this.id) {
                case "muro1":
                    pared = "Pared A";
                    break;
                case "muro2":
                    pared = "Pared B";
                    break;
                case "muro3":
                    pared = "Pared C";
                    break;
                case "muro4":
                    pared = "Pared D";
                    break;
                case "muro5":
                    pared = "Pared E";
                    break;
                case "muro6":
                    pared = "Pared F";
                    break;
                case "muro7":
                    pared = "Pared G";
                    break;
                case "muro8":
                    pared = "Pared H";
                    break;
                case "muro9":
                    pared = "Pared I";
                    break;
                case "muro10":
                    pared = "Pared J";
                    break;
                case "muro11":
                    pared = "Pared K";
                    break;
                case "muro12":
                    pared = "Pared L";
                    break;
                case "muro13":
                    pared = "Pared M";
                    break;
                case "muro14":
                    pared = "Pared N";
                    break;
                case "muro15":
                    pared = "Pared O";
                    break;
                case "muro16":
                    pared = "Pared P";
                    break;
                case "muro17":
                    pared = "Pared Q";
                    break;
                case "muro18":
                    pared = "Pared R";
                    break;
                case "muro19":
                    pared = "Pared S";
                    break;
                case "muro20":
                    pared = "Pared T";
                    break;
                case "muro21":
                    pared = "Pared U";
                    break;
                case "muro22":
                    pared = "Pared V";
                    break;
                case "muro23":
                    pared = "Pared W";
                    break;
                case "muro24":
                    pared = "Pared X";
                    break;
                case "muro25":
                    pared = "Pared Y";
                    break;
                case "muro26":
                    pared = "Pared Z";
                    break;
            }
            if ($(this).attr("fill") == "#F08675") {
                if (!$("img#picado_desescombro_tabiqueria").hasClass("selected"))
                    $("img#picado_desescombro_tabiqueria").trigger("click");

                if (!$("form[name='picado_desescombro_tabiqueria'] * input[value*='" + pared + "'][class='child']").is(':checked'))
                    $("form[name='picado_desescombro_tabiqueria'] * input[value*='" + pared + "'][class='child']").trigger("click");
            } else if ($(this).attr("fill") == "green") {
                //Si lo ha marcado como muro nuevo
                if (!$("img#hacer_tabique").hasClass("selected"))
                    $("img#hacer_tabique").trigger("click");

                if (!$("form[name='hacer_tabique'] * input[value*='" + pared + "'][class='child']").is(':checked'))
                    $("form[name='hacer_tabique'] * input[value*='" + pared + "'][class='child']").trigger("click");
            }
        });
    })
    //$(".form_muros > .checkmuro").remove(); 
})

$("#menu_materiales").click(function() {
    //Cojo todos los muros creados y los añado a todos los elementos 
    //de instalaciones y equipamiento en el que podrán seleccionar los muros a los que van ese elemento
    var paredes = "";
    var i = 0;
    $(".info_muro").each(function() {
        //$(this).text();
        //paredes=paredes+" <span class='checkmuro'><input type='checkbox' name='paredes[]' class='paredes' value='"+$(this).text()+"'> "+$(this).text()+"</span>";

        //Si no existe se muro, creámelo, y si no, no hagas nada
        //Esto es así xq si no me reinicia todos los input y lo que hayas marcado se elimina
        if (!$("input[value='" + $(this).text() + "']").length) {
            $(".form_muros").append("<span class='checkmuro'><input type='checkbox' name='paredes[]' class='paredes' value='" + $(this).text() + "'> " + $(this).text() + "</span>");
        }
    })
    //$(".form_muros > .checkmuro").remove(); 
})