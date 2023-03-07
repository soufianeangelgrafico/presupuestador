$(document).on("input", ".child", function () {
    console.log("Es completa");
    $(this).parent().find("input[value='parcial']").prop("checked", false);
    console.log($(this).parent().find("input[value='parcial']"));
});

$(document).on("input", '[name="seleccion_metros"]', function () {
    if (this.value == "parcial") {
        console.log("Es parcial");
        //$( (this).parent()+" > input:first-child").prop("checked",false);
        $(this).parent().find(".child").prop("checked", false);
        console.log($(this).parent().find(".child"));
    }
});

$(document).on("input", '[name="metros_parcial"]', function () {
    var value = this.value;
    var a = $(this).parent().parent(); /* nombre del formulario */
    var valor_anterior = $(
        "form[name='" + a[0].name + "'] * input[value='" + this.className + "']"
    )
        .val()
        .split("/");

    $(
        "form[name='" + a[0].name + "'] * input[value='" + this.className + "']"
    ).val(valor_anterior[0]);

    $(
        "form[name='" +
            a[0].name +
            "'] * input[type='checkbox'][value='" +
            this.className +
            "']"
    ).attr("checked", true);
    $(
        "form[name='" +
            a[0].name +
            "'] * input[type='checkbox'][value='" +
            valor_anterior[0] +
            "']"
    ).val(valor_anterior[0] + "/" + value);
    this.className = valor_anterior[0] + "/" + value;
});

$(document).on(
    "click",
    "input[name='seleccion_metros'][value='parcial']",
    function () {
        var valor_clase = this.className;
        var a = $(this).parent().parent(); /* nombre del formulario */

        $(
            "form[name='" +
                a[0].name +
                "'] * input[value*='" +
                valor_clase +
                "']"
        ).val(valor_clase);
        $(
            "form[name='" +
                a[0].name +
                "'] *  input[name='seleccion_metros'][class='" +
                valor_clase +
                "'] + input[type='range']"
        ).removeClass();
        $(
            "form[name='" +
                a[0].name +
                "'] *  input[name='seleccion_metros'][class='" +
                valor_clase +
                "'] + input[type='range']"
        ).addClass(valor_clase);

        $(
            "form[name='" +
                a[0].name +
                "'] * input[name='seleccion_metros'][class='" +
                valor_clase +
                "'] + input[type='range']"
        ).show();
        $(
            "form[name='" +
                a[0].name +
                "'] * input[name='seleccion_metros'][class='" +
                valor_clase +
                "'] + input[type='range']"
        ).attr("style", "display:block !important");

        $(
            "form[name='" +
                a[0].name +
                "'] * input[name='seleccion_metros'][class='" +
                valor_clase +
                "'] + input[type='range'] + output"
        ).show();

        if (!$(this).is(":checked")) {
            $(
                "form[name='" +
                    a[0].name +
                    "'] * input[name='seleccion_metros'][class='" +
                    valor_clase +
                    "'] + input[type='range']"
            ).hide();
            $(
                "form[name='" +
                    a[0].name +
                    "'] * input[name='seleccion_metros'][class='" +
                    valor_clase +
                    "'] + input[type='range'] + output"
            ).hide();
        }
    }
);

$(document).on("click", ".child", function () {
    var value = this.value;

    const replacers_child = {
        Pared: " ",
        A: " ",
        B: " ",
        C: " ",
        D: " ",
        E: " ",
        F: " ",
        G: " ",
        H: " ",
        I: " ",
        J: " ",
        K: " ",
        L: " ",
        M: " ",
        N: " ",
        O: " ",
        P: " ",
        Q: " ",
        R: " ",
        S: " ",
        T: " ",
        U: " ",
        V: " ",
        W: " ",
        X: " ",
        Y: " ",
        Z: " ",
        m: " ",
    };
    const stringArrm = value.split(" ");
    const result_value = stringArrm
        .map((word) => (replacers_child[word] ? replacers_child[word] : word))
        .join(" ")
        .trim();

    var a = $(this).parent().parent(); /* nombre del formulario */

    //Oculto el input Range (que aparece cuando seleccionas parcial). Porque si seleccionas la completa,
    //No tiene sentido que aparezca este input
    $(
        "form[name='" +
            a[0].name +
            "'] * input[type='range'][class*='" +
            value +
            "']"
    ).hide();
    $(
        "form[name='" +
            a[0].name +
            "'] * input[type='range'][class*='" +
            value +
            "'] + output"
    ).hide();

    var valor_anterior = $(
        "form[name='" +
            a[0].name +
            "'] * input[type='checkbox'][value*='" +
            value +
            "']"
    )
        .val()
        .split("/");

    $("form[name='" + a[0].name + "'] * input[value*='" + value + "']").val(
        valor_anterior[0]
    );

    var valor_input = $(
        "form[name='" +
            a[0].name +
            "'] * input[value='" +
            valor_anterior[0] +
            "']"
    ).val();

    $("form[name='" + a[0].name + "'] * input[value='" + value + "']").attr(
        "checked",
        true
    );
    $(
        "form[name='" +
            a[0].name +
            "'] * input[type='checkbox'][value='" +
            value +
            "']"
    ).val(valor_input + "/" + result_value);
});

/*Interface menu*/
// zra9: Start click
$("#menu_estado_actual").click(function () {
    $("#lin").show();
    if ($("#menu_estado_actual").hasClass("menu-activo")) {
        $("#submenu_paso1").attr("style", "display:none");
        $("#menu_estado_actual").removeClass("menu-activo");
        hideSubMenus();
    } else {
        hideMenus();
        $("#submenu_paso1").attr("style", "display:block");
        $("#menu_estado_actual").addClass("menu-activo");
        $("#menu_trabajos").removeClass("menu-activo");
    }
});

$("#menu_estado_reformado").click(function () {
    $("#lin").show();
    if ($("#menu_estado_reformado").hasClass("menu-activo")) {
        $("#submenu_paso2").attr("style", "display:none");
        $("#menu_estado_reformado").removeClass("menu-activo");
        hideSubMenus();
    } else {
        hideMenus();
        $("#submenu_paso2").attr("style", "display:block");
        $("#menu_estado_reformado").addClass("menu-activo");
        $("#menu_trabajos").removeClass("menu-activo");
    }
});

$("#menu_trabajos").click(function () {
    $("#lin").show();
    if ($("#submenu_paso3").is(":visible")) {
        $("#menu_trabajos").removeClass("menu-activo");
        $("#submenu_paso3").attr("style", "display:none");
        $("#submenu_paso3").removeClass("menu-activo");
        hideSubMenus();
    } else {
        hideMenus();
        $("#menu_trabajos").addClass("menu-activo");
        $("#opciones_trabajos").show();
        $("#submenu_paso3").attr("style", "display:block");
    }
});

$("#menu_materiales").click(function () {
    if ($("#menu_materiales").hasClass("menu-activo")) {
        $("#menu_materiales").removeClass("menu-activo");
        $("#opciones_materiales").hide();
        hideSubMenus();
    } else {
        hideMenus();
        $("#menu_materiales").addClass("menu-activo");
        $("#opciones_materiales").hide();
        $("#opciones_estilos").show();
    }
});

$("#menu_equipamiento").click(function () {
    if ($("#menu_equipamiento").hasClass("menu-activo")) {
        $("#menu_equipamiento").removeClass("menu-activo");
        $("#bloque_materiales").hide();
        hideSubMenus();
    } else {
        hideMenus();
        $("#menu_equipamiento").addClass("menu-activo");
        $("#opciones_equipamiento").show();
        $("#bloque_materiales").show();
    }
});

$("#menu_plano").click(function () {
    hideSubMenus();
    if ($("#menu_plano").hasClass("menu-activo")) {
        $("#opciones_crear_plano").hide();
    } else {
        $("#menu_plano").addClass("menu-activo");
        $("#opciones_crear_plano").show();
    }
});

$("#menu_plano_paso1").click(function () {
    hideSubMenus();
    if ($("#menu_plano_paso1").hasClass("menu-activo")) {
        $("#opciones_crear_plano").hide();
    } else {
        $("#menu_plano_paso1").addClass("menu-activo");
        $("#opciones_crear_plano").show();
    }
});

$("#menu_mobiliario").click(function () {
    hideSubMenus();
    if ($("#menu_mobiliario").hasClass("menu-activo")) {
        $("#menu_mobiliario").removeClass("menu-activo");
    } else {
        $("#menu_mobiliario").addClass("menu-activo");
        $("#opciones_mobiliario").show();
        $("#armarios_bajos > ul").show();
        $("#armarios_altos > ul").show();
    }

    alertify.success(
        "En el presupuesto no está incluido el mobiliario ni electrodomésticos. Sólo instalación y mano de obra"
    );

    fonc_button("select_mode");
    $("#boxinfo").html("Modo selección");
    $("#wallTools").hide("300");
    $("#panel").show("300");
});

$("#menu_mobiliario_paso1").click(function () {
    hideSubMenus();
    if ($("#menu_mobiliario_paso1").hasClass("menu-activo")) {
        $("#menu_mobiliario_paso1").removeClass("menu-activo");
    } else {
        $("#menu_mobiliario_paso1").addClass("menu-activo");
        $("#opciones_mobiliario").show();
        $("#armarios_bajos > ul").show();
        $("#armarios_altos > ul").show();
    }

    alertify.success(
        "En el presupuesto no está incluido el mobiliario ni electrodomésticos. Sólo instalación y mano de obra"
    );

    fonc_button("select_mode");
    $("#boxinfo").html("Modo selección");
    $("#wallTools").hide("300");
    $("#panel").show("300");
});

$("#menu_instalaciones").click(function () {
    hideSubMenus();
    $("#menu_instalaciones").addClass("menu-activo");
    $("#menu_estado_reformado").show();
    $("#opciones_instalaciones").show();

    alertify.success(
        "En el presupuesto no está incluido el mobiliario ni electrodomésticos. Sólo instalación y mano de obra"
    );
});

$("#menu_instalaciones_paso1").click(function () {
    hideSubMenus();
    $("#menu_instalaciones_paso1").addClass("menu-activo");
    $("#menu_estado_actual").show();
    $("#opciones_instalaciones").show();

    alertify.success(
        "En el presupuesto no está incluido el mobiliario ni electrodomésticos. Sólo instalación y mano de obra"
    );
});

$("#observaciones").click(function () {
    hideSubMenus();
    $("#observaciones").addClass("menu-activo");
    $("#opciones_observacion").show();
});

$("#observaciones_paso1").click(function () {
    hideSubMenus();
    $("#observaciones_paso1").addClass("menu-activo");
    $("#opciones_observacion").show();
});
// zra9: Fin click

$("#menu_materiales_movil").click(function () {
    $("#menu_materiales_movil").addClass("menu-activo");
    $("#opciones_estilos").show();
    hideMenus();
    // $("#menu_plano_movil").removeClass("menu-activo");
    // $("#menu_instalaciones_movil").removeClass("menu-activo");
    // $("#menu_mobiliario_movil").removeClass("menu-activo");
    // $("#menu_trabajos_movil").removeClass("menu-activo");
    // $("#menu_estado_reformado_movil").removeClass("menu-activo");
    // $("#menu_estado_reformado_movil").removeClass("menu-activo");
    // $("#menu_equipamiento_movil").removeClass("menu-activo");
    //$("#menu_estado_reformado").removeClass("menu-activo");

    // $("#opciones_crear_plano_movil").hide();
    // $("#opciones_instalaciones_movil").hide();
    // $("#opciones_sc_movil").hide();
    // $("#opciones_mobiliario_movil").hide();
    // $("#submenu_paso3_movil").hide();
    // $("#submenu_paso2_movil").hide();
    // $("#opciones_materiales_movil").hide();
    // $("#opciones_observacion_movil").hide();
    // $("#opciones_equipamiento").hide();
    // $("#bloque_materiales").hide();
});

$("#paso_menu_movil").click(function () {
    $("#lin_movil").show();
    if ($("#paso_menu_movil").hasClass("menu-activo")) {
        //$("#submenu_paso2_movil").attr("style", "display:none");
        $("#menu_trabajos_movil").removeClass("menu-activo");
        $("#menu_materiales_movil").removeClass("menu-activo");
        $("#menu_equipamiento_movil").removeClass("menu-activo");
        hideSubMenus();
    } else {
        hideMenus();
        //$("#submenu_paso2_movil").attr("style", "display:grid");
        $("#paso_menu_movil").addClass("menu-activo");
        $("#menu_trabajos").removeClass("menu-activo");
    }

    $("#menu_plano_movil").removeClass("menu-activo");
    $("#menu_instalaciones_movil").removeClass("menu-activo");
    $("#menu_mobiliario_movil").removeClass("menu-activo");
    $("#menu_trabajos_movil").removeClass("menu-activo");
    $("#paso_menu_movil").addClass("menu-activo");
    //$("#menu_estado_reformado").removeClass("menu-activo");
    $("#menu_materiales_movil").removeClass("menu-activo");
    $("#menu_equipamiento_movil").removeClass("menu-activo");

    $("#opciones_crear_plano_movil").hide();
    $("#opciones_instalaciones_movil_movil").hide();
    $("#opciones_sc_movil").hide();
    $("#opciones_mobiliario_movil").hide();
    $("#submenu_paso3_movil").hide();
    $("#submenu_paso2_movil").show();
    //$("#opciones_estilos").hide();
});

$("#menu_estado_reformado_movil").click(function () {
    $("#lin_movil").show();
    if ($("#menu_estado_reformado_movil").hasClass("menu-activo")) {
        //$("#submenu_paso2_movil").attr("style", "display:none");
        $("#menu_trabajos_movil").removeClass("menu-activo");
        $("#menu_materiales_movil").removeClass("menu-activo");
        $("#menu_equipamiento_movil").removeClass("menu-activo");
        hideSubMenus();
    } else {
        hideMenus();
        //$("#submenu_paso2_movil").attr("style", "display:grid");
        $("#menu_estado_reformado_movil").addClass("menu-activo");
        $("#menu_trabajos").removeClass("menu-activo");
    }

    $("#submenu_paso2_movil").attr("style", "display:grid");

    $("#menu_plano_movil").removeClass("menu-activo");
    $("#menu_instalaciones_movil").removeClass("menu-activo");
    $("#menu_mobiliario_movil").removeClass("menu-activo");
    $("#menu_trabajos_movil").removeClass("menu-activo");
    $("#menu_estado_reformado_movil").addClass("menu-activo");
    //$("#menu_estado_reformado").removeClass("menu-activo");
    $("#menu_materiales_movil").removeClass("menu-activo");
    $("#menu_equipamiento_movil").removeClass("menu-activo");

    $("#opciones_crear_plano_movil").hide();
    $("#opciones_instalaciones_movil_movil").hide();
    $("#opciones_sc_movil").hide();
    $("#opciones_mobiliario_movil").hide();
    $("#submenu_paso3_movil").hide();
    $("#submenu_paso2_movil").show();
    //$("#opciones_estilos").hide();
});


//@7mar
$("#menu_instalaciones_movil").click(function () {
    $("#menu_plano_movil").removeClass("menu-activo");
    $("#menu_mobiliario_movil").removeClass("menu-activo");
    $("#menu_materiales_movil").removeClass("menu-activo");
    $("#menu_instalaciones_movil").addClass("menu-activo");

    $("#opciones_crear_plano").hide();
    $("#opciones_mobiliario").hide();
    $("#opciones_materiales").hide();
    $("#bloque_materiales").hide();
    $("#opciones_observacion").hide();
    $("#opciones_instalaciones").show();

    alertify.success(
        "En el presupuesto no está incluido el mobiliario ni electrodomésticos. Sólo instalación y mano de obra"
    );
});

$("#menu_mobiliario_movil").click(function () {
    $("#menu_plano_movil").removeClass("menu-activo");
    $("#menu_instalaciones_movil").removeClass("menu-activo");
    $("#menu_materiales_movil").removeClass("menu-activo");
    $("#menu_mobiliario_movil").addClass("menu-activo");

    $("#opciones_crear_plano").hide();
    $("#opciones_instalaciones").hide();
    $("#opciones_sc").hide();
    $("#opciones_materiales").hide();
    $("#bloque_materiales").hide();
    $("#opciones_observacion").hide();
    $("#opciones_mobiliario").show();

    alertify.success(
        "En el presupuesto no está incluido el mobiliario ni electrodomésticos. Sólo instalación y mano de obra"
    );

    fonc_button("select_mode");
    $("#boxinfo").html("Modo selección");
    $("#wallTools").hide("300");
    $("#panel").show("300");
});

$("#menu_plano_movil").click(function () {
    $("#menu_mobiliario_movil").removeClass("menu-activo");
    $("#menu_instalaciones_movil").removeClass("menu-activo");
    $("menu_materiales_movil").removeClass("menu-activo");
    $("#menu_plano_movil").addClass("menu-activo");

    $("#opciones_mobiliario").hide();
    $("#opciones_instalaciones").hide();
    $("#opciones_sc").hide();
    $("#opciones_materiales").hide();
    $("#bloque_materiales").hide();
    $("#opciones_observacion").hide();
    $("#opciones_crear_plano").show();
});

$("#menu_plano").click(function () {
    $("#menu_mobiliario").removeClass("menu-activo");
    $("#menu_instalaciones").removeClass("menu-activo");
    $("#menu_materiales").removeClass("menu-activo");
    $("#observaciones").removeClass("menu-activo");
    $("#menu_plano").addClass("menu-activo");

    $("#opciones_mobiliario").hide();
    $("#opciones_instalaciones").hide();
    $("#opciones_sc").hide();
    $("#opciones_observacion").hide();
    $("#opciones_materiales").hide();
    $("#opciones_crear_plano").show();
});

$("#menu_sc").click(function () {
    $("#menu_mobiliario").removeClass("menu-activo");
    $("#menu_instalaciones").removeClass("menu-activo");
    $("#menu_plano").removeClass("menu-activo");
    $("#menu_materiales").removeClass("menu-activo");
    $("#menu_sc").addClass("menu-activo");

    $("#opciones_mobiliario").hide();
    $("#opciones_instalaciones").hide();
    $("#opciones_observacion").hide();
    $("#opciones_crear_plano").hide();
    $("#opciones_materiales").hide();
    $("#opciones_sc").show();
});


$("#observaciones_movil").click(function () {
    $("#menu_mobiliario_movil").removeClass("menu-activo");
    $("#menu_instalaciones_movil").removeClass("menu-activo");
    $("#menu_materiales_movil").removeClass("menu-activo");
    //$("#menu_estado_reformado").removeClass("menu-activo");
    $("#menu_plano_movil").removeClass("menu-activo");
    $("#opciones_observacion").addClass("menu-activo");

    $("#opciones_mobiliario").hide();
    $("#opciones_instalaciones").hide();
    $("#opciones_sc").hide();
    $("#opciones_materiales").hide();
    $("#opciones_crear_plano").hide();
    $("#opciones_observacion").show();
});

$("#menu_trabajos_movil").click(function () {
    $("#lin").show();
    if ($("#submenu_paso3_movil").is(":visible")) {
        $("#menu_trabajos_movil").removeClass("menu-activo");
        $("#submenu_paso3_movil").attr("style", "display:none");
        $("#submenu_paso3_movil").removeClass("menu-activo");
        hideSubMenus();
    } else {
        hideMenus();
        $("#menu_trabajos_movil").addClass("menu-activo");
        $("#submenu_paso3_movil").attr("style", "display:block");
        $("#menu_plano_movil").removeClass("menu-activo");
        $("#menu_estado_reformado_movil").removeClass("menu-activo");
        $("#menu_mobiliario_movil").removeClass("menu-activo");
        $("#menu_materiales_movil").removeClass("menu-activo");
        $("#menu_instalaciones_movil").removeClass("menu-activo");
        $("#menu_estado_reformado_movil_movil").removeClass("menu-activo");
        $("#menu_equipamiento_movil").removeClass("menu-activo");

        $("#opciones_crear_plano_movil").hide();
        $("#opciones_mobiliario_movil").hide();
        $("#opciones_materiales_movil").hide();
        $("#opciones_observacion_movil").hide();
        $("#opciones_instalaciones_movil").hide();
        $("#submenu_paso2_movil_movil").hide();
        $("#opciones_trabajos").show();
    }
});


$("#menu_equipamiento_movil").click(function () {
    hideMenus();
    hideSubMenus();
    $("#menu_mobiliario_movil").removeClass("menu-activo");
    $("#menu_materiales_movil").removeClass("menu-activo");
    $("#observaciones_movil").removeClass("menu-activo");
    $("#menu_plano_movil").removeClass("menu-activo");
    $("#menu_estado_reformado_movil").removeClass("menu-activo");
    $("#menu_trabajos_movil").removeClass("menu-activo");
    $("#menu_equipamiento_movil").addClass("menu-activo");
    $("#opciones_equipamiento").show();
    $("#bloque_materiales").show();
    $("#titulo_estado_actual_movil").hide();
    $("#bloque_estado_actual_movil").hide();
    $("#submenu_paso3_movil").hide();
    $("#submenu_paso2_movil").hide();
});

$(".style-options").click(function () {
    $("#lin").hide();
    hideSubMenus();

    var id_material = $(this).attr("id");

    if (id_material == "nordicoStyleBtn") var estilo = "estilo1";
    else if (id_material == "minimalistaStyleBtn") var estilo = "estilo2";
    else if (id_material == "industrialStyleBtn") var estilo = "estilo3";
    else if (id_material == "rusticoStyleBtn") var estilo = "estilo4";
    else if (id_material == "clasicoStyleBtn") var estilo = "estilo5";
    else if (id_material == "mediterraneoStyleBtn") var estilo = "estilo6";
    else var estilo = "libre";

    $("#selectedStyleBtn").css(
        "background-image",
        $(this).css("background-image")
    );
    $("#selectedStyleBtn p").text($(this).children("p").text());
    $("#bloque_materiales").show();
    $("#titulo_estado_actual").hide();
    $("#bloque_estado_actual").hide();
    $("#opciones_materiales").show();

    $(".materials_submenu_btn").hide();
    $(".wall_options_btn").hide();

    $(".materials_submenu_btn").each(function () {
        if ($(this).hasClass(estilo)) $(this).show();
    });

    $(".wall_options_btn").each(function () {
        if (
            $(this).hasClass(estilo) ||
            $(this).hasClass("alicatadoBtn") ||
            $(this).hasClass("enlucidoBtn")
        )
            $(this).show();
    });
});
$(".alicatadoBtn").click(function () {
    $(this).addClass("active");
    $(".enlucidoBtn").removeClass("active");
    $(this).parent().nextAll("div .options_enlucido_list").hide();
    $(this).parent().nextAll("div .options_alicatado_list").show();
});

$(".enlucidoBtn").click(function () {
    $(this).addClass("active");
    $(".alicatadoBtn").removeClass("active");
    $(this).parent().nextAll("div .options_alicatado_list").hide();
    $(this).parent().nextAll("div .options_enlucido_list").show();
});

$(".wall_options_btn").click(function () {
    $(this)
        .parent()
        .parent()
        .children()
        .each(function () {
            $(this).children(".wall_options_btn").removeClass("active");
        });
    $(this).addClass("active");
});

$(".carpentry_options_btn").click(function () {
    $(this).parent().children(".carpentry_options_btn").removeClass("active");
    $(this).addClass("active");
});
$(".flexBtn").click(function () {
    $(".flexBtn").each(function () {
        $(this).removeClass("active");
        $(this).children(".unidades_elemento").attr("style", "display:none");
    });

    $(this).addClass("active");
    $(this).children(".unidades_elemento").attr("style", "display:block");
});
$(".materials_submenu_btn").click(function () {
    $(this).parent().children(".materials_submenu_btn").removeClass("active");
    $(this).addClass("active");
});
$(".color_picker_btn").click(function () {
    $(this)
        .parent()
        .parent()
        .children()
        .each(function () {
            $(this).children(".color_picker_btn").removeClass("active");
        });

    $(this).addClass("active");
});
$(".RYLbuttonContainer").click(function () {
    $(this)
        .parent()
        .parent()
        .children()
        .each(function () {
            $(this).children(".RYLbuttonContainer").removeClass("active");
        });

    $(this).addClass("active");
});

function selectRadiator(caller, type) {
    const currentArray = [
        ["3", "5", "6", "7", "8", "9", "10", "11", "12"],
        ["3", "4", "6", "8", "10", "12"],
        ["1", "3", "4", "8", "10"],
    ];
    var nextElementsList = $(caller)
        .parent()
        .parent()
        .children(".elements-content");
    nextElementsList.show();
    nextElementsList.children("button").remove();

    $(caller).parent().children("button").removeClass("active");
    $(caller).addClass("active");

    for (let i = 0; i < currentArray[type].length; i++) {
        nextElementsList.append(
            '<button onclick="selectRadiatorElements(this)">' +
                currentArray[type][i] +
                " elementos</button>"
        );
    }
}

function selectRadiatorElements(caller) {
    $(caller).parent().children("button").removeClass("active");
    $(caller).addClass("active");
}
$("#addRadiatorBtn").click(function () {
    var rawHtml =
        '<div style="margin-top:15px;"class="dropdown_radiator">' +
        '<button class="deleteRadiatorBtn" onclick="deleteRadiator(this)">X</button>' +
        '<img src="CapasCocina/EQUIPAMIENTO/Radiador.png"/>' +
        '<div style="width:100%; text-align: center; margin-bottom:10px;">Radiador Europa</div>' +
        '<div class="dropdown-content">' +
        "<p>Selecciona un Modelo</p>" +
        '<button onclick="selectRadiator(this,0);">450 N</button>' +
        '<button onclick="selectRadiator(this,1);">600 N</button>' +
        ' <button onclick="selectRadiator(this,2);">700 N</button>' +
        '<button onclick="selectRadiator(this,2);">800 N</button>' +
        "</div>" +
        '<div  class="elements-content">' +
        "<p>Selecciona el numero de elementos</p> " +
        "</div>" +
        "</div>";
    $(this).before(rawHtml);
});

function deleteRadiator(caller) {
    $(caller).parent().remove();
}

function setMaterialsImages(container, image) {
    const containerArray = [
        "#imagen_frente_armario",
        "#imagen_encimera",
        "#imagen_pared_lateral_puerta",
        "#imagen_pared_frontal",
        "#imagen_pared_lateral_ventana",
        "#imagen_suelo",
        "#imagen_rodapie_puerta",
        "#imagen_rodapie_ventana",
        "#imagen_RYL_pared",
        "#imagen_RYL_suelo",
        "#imagen_RYL_listelos",
        "#imagen_puertas",
        "#imagen_ventanas",
    ];
    $(containerArray[container]).css({
        "background-image": "url(" + image + ")",
    });
}

function hideMenus() {
    // $("#bloque_estado_actual").show();
    // $("#titulo_estado_actual").show();
    
    $("#menu_instalaciones").removeClass("menu-activo");
    $("#bloque_materiales").hide();

    //zra9: Start menu planificador
    $("#menu_estado_reformado").removeClass("menu-activo");
    $("#menu_trabajos").removeClass("menu-activo");
    $("#menu_materiales").removeClass("menu-activo");
    $("#menu_equipamiento").removeClass("menu-activo");
    $("#menu_plano").removeClass("menu-activo");
    $("#menu_estado_actual").removeClass("menu-activo");

    $("#submenu_paso1").hide();
    $("#submenu_paso2").hide();
    $("#submenu_paso3").hide();
    $("#submenu_paso1_movil").hide();
    $("#submenu_paso2_movil").hide();
    $("#submenu_paso3_movil").hide();
    //zra9: Fin menu planificador
    hideSubMenus();
}

function hideSubMenus() {
    $("#opciones_crear_plano").hide();
    $("#opciones_instalaciones").hide();
    $("#opciones_sc").hide();
    $("#opciones_observacion").hide();
    $("#opciones_mobiliario").hide();
    $("#opciones_trabajos").hide();
    $("#opciones_materiales").hide();
    $("#opciones_estilos").hide();
    $("#opciones_equipamiento").hide();


    // paso 1
    $("#menu_plano_paso1").removeClass("menu-activo");
    $("#menu_mobiliario_paso1").removeClass("menu-activo");
    $("#menu_instalaciones_paso1").removeClass("menu-activo");
    $("#observaciones_paso1").removeClass("menu-activo");
    // paso 2
    $("#menu_plano").removeClass("menu-activo");
    $("#menu_mobiliario").removeClass("menu-activo");
    $("#menu_instalaciones").removeClass("menu-activo");
    $("#observaciones").removeClass("menu-activo");
    //$("#titulo_estado_actual").hide();
}

function hideWallsMenus(parent) {
    if (parent != null) {
        var visibility = $(parent).next("div").is(":visible");
    }
    $(".pared_lateral_list").hide();
    $(".pared_frontal_list").hide();
    $(".pared_ventana_list").hide();
    $(".options_alicatado_list").hide();
    $(".options_enlucido_list").hide();
    if (parent != null) {
        if (visibility) {
            $(parent).next("div").hide();
        } else {
            $(parent).next("div").show();
        }
    }
}

function hideRodapieMenus() {
    $(".rodapie_pared_puerta_list").hide();
    $(".rodapie_pared_ventana_list").hide();
}

function hideRYLMenus() {
    $(".rejunte_pared_list").hide();
    $(".rejunte_suelo_list").hide();
    $(".listelos_list").hide();
}

function hideCarpentryMenus() {
    $(".window_list").hide();
    $(".door_list").hide();
}

function hideStep4SubMenus(parent) {
    var visibility = $(parent).next(".child_list").is(":visible");

    $("#frente_armario_list").hide();
    $("#encimera_list").hide();
    $("#paredes_list").hide();
    $("#suelo_list").hide();
    $("#rodapie_list").hide();
    $("#RYL_list").hide();
    $("#carpinteria_list").hide();

    hideWallsMenus(null);
    hideRodapieMenus();
    hideRYLMenus();
    hideCarpentryMenus();

    if (visibility) {
        $(parent).next(".child_list").hide();
    } else {
        $(parent).next(".child_list").show();
    }
}

function hideStep5SubMenus(caller) {
    $("#opciones_equipamiento .blackBtn").removeClass("active");
    $(caller).addClass("active");
    var visibility = $(caller).next(".child_list").is(":visible");
    $(caller).parent().children(".child_list").hide();

    if (visibility) {
        $(caller).next(".child_list").hide();
    } else {
        $(caller).next(".child_list").show();
    }
}

function hideStep2SubMenus(caller) {
    var visibility = $(caller).next(".child_list").is(":visible");
    $(caller).parent().children(".child_list").hide();

    if (visibility) {
        $(caller).next(".child_list").hide();
    } else {
        $(caller).next(".child_list").show();
    }
}

function hideStep2Menus(caller) {
    var visibility = $(caller).next(".father_list").is(":visible");
    $(caller).parent().children(".father_list").hide();

    if (visibility) {
        console.log("in");
        $(caller).next(".father_list").hide();
    } else {
        console.log("out");
        $(caller).next(".father_list").show();
    }
}

function manageStep5Submenu(caller, mode) {
    switch (mode) {
        case 0:
            $(".thermusList button").removeClass("active");
            $(".thermusList img").removeClass("active");
            $(".calentadoresList .equipment_options_btn").removeClass("active");
            $(".calderasList .equipment_options_btn").removeClass("active");
            $(caller)
                .parent()
                .parent()
                .parent()
                .children("img")
                .addClass("active");

            $(caller).addClass("active");
            break;
        case 1:
            $(".thermusList button").removeClass("active");
            $(".thermusList img").removeClass("active");
            $(".calentadoresList .equipment_options_btn").removeClass("active");
            $(".calderasList .equipment_options_btn").removeClass("active");
            $(caller).addClass("active");
            break;
        case 2:
            break;
    }
    $(caller).addClass("active");
}

function manageStyleInfo(objct) {
    var coords = $(objct).parent().offset();
    var width = $(objct).parent().width();
    //var height=$(objct).parent().height();

    $(objct).parent().nextAll("div .style-info").width(width);
    //$(objct).parent().nextAll('div .style-info').height(height);
    $(objct)
        .parent()
        .nextAll("div .style-info")
        .css({
            top: coords.top + "px",
        });
    $(objct)
        .parent()
        .nextAll("div .style-info")
        .css({
            left: coords.left + width + 25 + "px",
        });
    $(objct).parent().nextAll("div .style-info").show();
}

$(".styleInfoBtn").click(function (e) {
    e.stopPropagation();
    if ($(this).parent().nextAll("div .style-info").is(":visible")) {
        $(this).parent().nextAll("div .style-info").hide();
    } else {
        manageStyleInfo($(this));
    }
});

$(function () {
    $("#panel_informacion").scroll(function () {
        $(".style-info").hide();
    });
});
