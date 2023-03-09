let dibujo = localStorage.getItem("history");
let id_plano;
const observaciones_texto = $("#textarea_observaciones").val();
const altura_techo = $("#altura_techo_actual").val();

function hide() {
    //alert(observaciones_texto);
    //Elimino el div de las observaciones para que no salga en el pantallazo
    $("#observaciones_plano").hide();
    $("#parte_superior").attr("style", "display:none");
    $("#moveBox").attr("style", "display:none");
    $("#zoomBox").attr("style", "display:none");
    $("#titulo_estado_actual").hide();
    $("#imagen_bloque_estado_actual").hide();
    $("#bloque_estado_actual").hide();

    /* Changing the font size of the text in the canvas. */
    /* Cambiar el tamaño de la fuente del texto en el canvas. */
    jQuery("#boxRib > text").each(function () {
        jQuery(this).attr("font-size", "0.80em");
    });
}

/* Mostrando los elementos con los id's: observaciones_plano, parte_superior,
moveBox, zoomBox, titulo_estado_actual, imagen_bloque_estado_actual,
bloque_estado_actual, menu_estado_actual_movil. */
function show() {
    $("#observaciones_plano").show();
    $("#parte_superior").attr("style", "display:block");
    $("#moveBox").attr("style", "display:block");
    $("#zoomBox").attr("style", "display:block");
    $("#titulo_estado_actual").show();
    $("#imagen_bloque_estado_actual").show();
    $("#bloque_estado_actual").show();
    $("#menu_estado_actual_movil").show();
}

///  ╔═══════════════════════════════════════════════════════════════════════════════════════════╗
///  ║ //zra9 **************************** Paso 1 start ********************************* ///    ║
///  ╠═══════════════════════════════════════════════════════════════════════════════════════════╣
///  ║     // Toma una captura de pantalla y la guarda servidor luego el URL de la foto   ///    ║
///  ║     //   en la base de datus.                                                      ///    ║
///  ╚═══════════════════════════════════════════════════════════════════════════════════════════╝

$("#screenshot_paso_1").click(function () {
    $("#screenshot_paso_1").attr("style", "pointer-events: none;");
    $("#screenshot_paso_1 > span").html("Guardando...");
    save();

    if (localStorage.getItem("history") == null) {
        alertify.alert(
            "Debes dibujar el estado actual de tu cocina antes de continuar"
        );

        /* / English
        Setting the style of the element with id `screenshot_paso_1` to `pointer-events: unset;` and
        the html of the element with id `screenshot_paso_1 > span` to `Siguiente paso` after 2
        seconds. 
        /* / Español
        Establecer el estilo del elemento con id `screenshot_paso_1` a `pointer-events: unset;` y
        el html del elemento con id `screenshot_paso_1 > span` a `Siguiente paso` después de 2
        segundos. 
        */
        setTimeout(function () {
            $("#screenshot_paso_1").attr("style", "pointer-events: unset;");
            $("#screenshot_paso_1 > span").html("Siguiente paso");
        }, 2000);
    } else {
        hide();

        /* / English
        The above code is taking a screenshot of the current state of the canvas and saving it to
        the database. 
        /* / Español
        El código anterior toma una captura de pantalla del estado actual del canvas y la guarda en
        la base de datos. 
        */
        html2canvas(document.body).then((canvas) => {
            console.log("done ... ");
            let photo = canvas.toDataURL("image/jpeg");
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "photo_upload.php",
                data: {
                    photo: photo,
                },
                success: function (mensaje) {
                    //alert(mensaje.id);
                    /* Establecer el valor de la clave `estado_actual` al valor de la variable
                    `mensaje.id`. */
                    localStorage.setItem("estado_actual", mensaje.id);

                    /* Envío de los datos al servidor. */
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        async: false,
                        url: "ajax/guardar_estado_actual.php",
                        data: {
                            id: mensaje.id,
                            dibujo: dibujo,
                            observaciones_texto: observaciones_texto,
                            altura_techo: altura_techo,
                        },
                        success: function (respuesta) {
                            // window.location.assign(
                            //     " https://presupuestador.rehubik.com/2d_v0.0.2/index.php"
                            // );

                            show();

                            $("#screenshot_paso_1").hide();
                            $("#screenshot_paso_2").show();
                        },
                    });

                    /* Taking a screenshot of the current state of the canvas and saving it to the
                    database. */
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        async: false,
                        url: "ajax/foto_estado_actual.php",
                        data: {
                            id: mensaje.id,
                        },
                        success: function (respuestas) {
                            // Mostrar captura de pantalla
                            /* Creación de una etiqueta de imagen con la variable `photo` como fuente. */
                            let foto;
                            foto =
                                '<img src="' +
                                photo +
                                '" width="100%" height="">';
                            $("#imagen_bloque_estado_actual").html(foto);
                            console.log(photo);

                            //Desactivar botón paso 1
                            const myButton = document.getElementById(
                                "menu_estado_actual_movil"
                            );
                            const my_button =
                                document.getElementById("menu_estado_actual");

                            /* Cambiando la opacidad del botón a 0.5 y el cursor a no permitido. */
                            myButton.style.opacity = 0.5;
                            myButton.style.cursor = "not-allowed";
                            my_button.style.opacity = 0.5;
                            my_button.style.cursor = "not-allowed";

                            /* Añadir una clase al elemento con id `menu_estado_actual_movil` y al
                            elemento con id `menu_estado_actual`. */
                            $("#menu_estado_actual_movil").addClass(
                                "desactivo"
                            );
                            $("#menu_estado_actual").addClass(
                                "menu_estado_inactivo"
                            );
                            hideMenus();

                            /* Eliminar el evento click del elemento con id `menu_estado_actual`. */
                            $("#menu_estado_actual").unbind("click");

                            /* Definir una variable llamada check_movil_paso_1 y check_paso_1. */
                            const check_movil_paso_1 =
                                '<span class="numeropaso"> PASO 1 </span> <br> DIBUJA EL ESTADO ACTUAL <br> <i class="fa fa-light fa-check"></i>';
                            const check_paso_1 =
                                '<h2 class="titular-planificador"><div style="color:#95C11F;">PASO 1</div>DIBUJA EL ESTADO ACTUAL<br><i class="fa fa-info-circle instructionsBtn" onclick="instrucciones(\'paso1\')"></i></h2><i class="fa fa-light fa-check"></i>';

                            /* Cambiar el html del elemento con id `menu_estado_actual_movil` a
                            `menu_estado_actual_movil_paso_1` */
                            $("#menu_estado_actual_movil").html(
                                check_movil_paso_1
                            );
                            $("#menu_estado_actual").html(check_paso_1);
                            $("#submenu_paso1").html("");

                            id_plano = mensaje.id;
                            console.log(id_plano);
                        },
                    });
                },
            });
        });
    }
});
///- ╔════════════════════════════════════════════════════════════════════════════════════════╗
///- ║ //mov ************************** Paso 1 end ********************************** ///-    ║
///- ╚════════════════════════════════════════════════════════════════════════════════════════╝

///  ╔════════════════════════════════════════════════════════════════════════════════════════╗
///  ║ //zra9 ************************* Paso 2 start ******************************** ///     ║
///  ╚════════════════════════════════════════════════════════════════════════════════════════╝
$("#screenshot_paso_2").click(function () {
    console.log('dintro de paso 2')
    $("#screenshot_paso_2").attr("style", "pointer-events: none;");
    $("#screenshot_paso_2 > span").html("Guardando...");
    save();

    if (localStorage.getItem("history") == null) {
        /* Setting the style of the element with id `screenshot_paso_2` to `pointer-events: unset;` and
        the html of the element with id `screenshot_paso_1 > span` to `Siguiente paso` after 2
        seconds. */
        /* Establecer el estilo del elemento con id `screenshot_paso_2` a `pointer-events: unset;` y
        el html del elemento con id `screenshot_paso_1 > span` a `Siguiente paso` después de 2
        segundos. */
        setTimeout(function () {
            $("#screenshot_paso_2").attr("style", "pointer-events: unset;");
            $("#screenshot_paso_2 > span").html("Siguiente paso");
        }, 2000);
        console.log("dntro de if 1")
    } else {
        console.log("dintro de else")
        hide();

        /* The above code is taking a screenshot of the current state of the canvas and saving it to
        the database. */
        /* El código anterior toma una captura de pantalla del estado actual del canvas y la guarda en
        la base de datos. */
        html2canvas(document.body).then((canvas) => {
            console.log("dintro de html2 canvas")
            console.log("done ... ");

            console.log(id_plano)
            console.log(id_plano);
            let photo = canvas.toDataURL("image/jpeg");
            $.ajax({
                method: "POST",
                dataType: "json",
                url: "ajax/photo_upload_reformado.php",
                data: {
                    photo: photo,
                    id: id_plano,
                },
                success: function (mensaje) {
                    //alert(mensaje.id);
                    /* Establecer el valor de la clave `estado_actual` al valor de la variable
                    `mensaje.id`. */
                    //localStorage.setItem("estado_reformado", id_plano);

                    /* Envío de los datos al servidor. */
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        async: false,
                        url: "ajax/guardar_estado_reformado.php",
                        data: {
                            id: id_plano,
                            dibujo: dibujo,
                            observaciones_texto: observaciones_texto,
                            altura_techo: altura_techo,
                        },
                        success: function (respuesta) {
                            show();
                            $("#screenshot_paso_2").hide();
                            $("#screenshot_paso_3").show();
                        },
                    });

                    /* Taking a screenshot of the current state of the canvas and saving it to the
                    database. */
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        async: false,
                        url: "ajax/foto_estado_reformado.php",
                        data: {
                            id: id_plano,
                        },
                        success: function (respuestas) {
                            hideMenus();

                            //Desactivar botón paso 2
                            const myButton = document.getElementById(
                                "menu_estado_reformado_movil"
                            );
                            const my_button = document.getElementById(
                                "menu_estado_reformado"
                            );

                            /* Cambiando la opacidad del botón a 0.5 y el cursor a no permitido. */
                            myButton.style.opacity = 0.5;
                            myButton.style.cursor = "not-allowed";
                            my_button.style.opacity = 0.5;
                            my_button.style.cursor = "not-allowed";

                            /* Añadir una clase al elemento con id `menu_estado_actual_movil` y al
                            elemento con id `menu_estado_actual`. */
                            $("#menu_estado_reformado_movil").addClass(
                                "desactivo"
                            );
                            $("#menu_estado_reformado").addClass(
                                "menu_estado_inactivo"
                            );

                            /* Eliminar el evento click del elemento con id `menu_estado_actual`. */
                            $("#menu_estado_reformado").unbind("click");
                            $("#menu_estado_reformado_movil").unbind("click");

                            /* Definir una variable llamada check_movil_paso_2 y check_paso_1. */
                            const check_movil_paso_2 =
                                '<span class="numeropaso"> PASO 2 </span> <br> DIBUJAR ESTADO REFORMADO <br> <i class="fa fa-light fa-check"></i>';
                            const check_paso_2 =
                                '<h2 class="titular-planificador"><div style="color:#95C11F;">PASO 2</div>DIBUJAR ESTADO REFORMADO<br><i class="fa fa-info-circle instructionsBtn" onclick="instrucciones(\'paso2\')"></i></h2><i class="fa fa-light fa-check"></i>';

                            /* Cambiar el html del elemento con id `menu_estado_actual_movil` a
                            `menu_estado_actual_movil_paso_1` */
                            $("#menu_estado_reformado_movil").html(check_movil_paso_2);
                            $("#menu_estado_reformado").html(check_paso_2);
                            $("#submenu_paso2").html("");

                            // const id_plano_2 = mensaje.id;
                            // console.log(id_plano_2);
                        },
                    });
                },
            });
        });
    }
});
///- ╔════════════════════════════════════════════════════════════════════════════════════════╗
///- ║ //mov ************************** Paso 2 end ********************************** ///-    ║
///- ╚════════════════════════════════════════════════════════════════════════════════════════╝

///  ╔════════════════════════════════════════════════════════════════════════════════════════╗
///  ║ //zra9 ************************* Paso 3 start ******************************** ///     ║
///  ╚════════════════════════════════════════════════════════════════════════════════════════╝
$("#screenshot_paso_3").click(function () {
    hideMenus();

    //Desactivar botón paso 3
    const myButton = document.getElementById(
        "menu_trabajos_movil"
    );
    const my_button = document.getElementById(
        "menu_trabajos"
    );

    /* Cambiando la opacidad del botón a 0.5 y el cursor a no permitido. */
    myButton.style.opacity = 0.5;
    myButton.style.cursor = "not-allowed";
    my_button.style.opacity = 0.5;
    my_button.style.cursor = "not-allowed";

    /* Añadir una clase al elemento con id `menu_estado_actual_movil` y al
    elemento con id `menu_estado_actual`. */
    $("#menu_trabajos_movil").addClass(
        "desactivo"
    );
    $("#menu_trabajos").addClass(
        "menu_estado_inactivo"
    );

    /* Eliminar el evento click del elemento con id `menu_estado_actual`. */
    $("#menu_trabajos").unbind("click");
    $("#menu_trabajos_movil").unbind("click");

    /* Definir una variable llamada check_movil_paso_3 y check_paso_1. */
    const check_movil_paso_3 =
        '<span class="numeropaso"> PASO 3 </span> <br> TRABAJOS A REALIZAR <br> <i class="fa fa-light fa-check"></i>';
    const check_paso_3 =
        '<h2 class="titular-planificador"><div style="color:#95C11F;">PASO 3</div>TRABAJOS A REALIZAR<br><i class="fa fa-info-circle instructionsBtn" onclick="instrucciones(\'paso3\')"></i></h2><i class="fa fa-light fa-check"></i>';

    /* Cambiar el html del elemento con id `menu_estado_actual_movil` a
    `menu_estado_actual_movil_paso_3` */
    $("#menu_trabajos_movil").html(check_movil_paso_3);
    $("#menu_trabajos").html(check_paso_3);
    $("#submenu_paso3").html("");


    $("#screenshot_paso_3").hide();
    $("#screenshot_paso_4").show();
});
///- ╔════════════════════════════════════════════════════════════════════════════════════════╗
///- ║ //mov ************************** Paso 3 end ********************************** ///-    ║
///- ╚════════════════════════════════════════════════════════════════════════════════════════╝

///  ╔════════════════════════════════════════════════════════════════════════════════════════╗
///  ║ //zra9 ************************* Paso 4 start ******************************** ///     ║
///  ╚════════════════════════════════════════════════════════════════════════════════════════╝
$("#screenshot_paso_4").click(function () {
    // hideMenus();

    // //Desactivar botón paso 4
    // const myButton = document.getElementById(
    //     "menu_materiales_movil"
    // );
    // const my_button = document.getElementById(
    //     "menu_materiales"
    // );

    // /* Cambiando la opacidad del botón a 0.5 y el cursor a no permitido. */
    // myButton.style.opacity = 0.5;
    // myButton.style.cursor = "not-allowed";
    // my_button.style.opacity = 0.5;
    // my_button.style.cursor = "not-allowed";

    // /* Añadir una clase al elemento con id `menu_estado_actual_movil` y al
    // elemento con id `menu_estado_actual`. */
    // $("#menu_materiales_movil").addClass(
    //     "desactivo"
    // );
    // $("#menu_materiales").addClass(
    //     "menu_estado_inactivo"
    // );

    //  /* Eliminar el evento click del elemento con id `menu_estado_actual`. */
    // $("#menu_materiales").unbind("click");
    // $("#menu_materiales_movil").unbind("click");

    // /* Definir una variable llamada check_movil_paso_4 y check_paso_3. */
    // const check_movil_paso_4 =
    //     '<span class="numeropaso"> PASO 4 </span> <br> MATERIALES <br> <i class="fa fa-light fa-check"></i>';
    // const check_paso_4 =
    //     '<h2 class="titular-planificador"><div style="color:#95C11F;">PASO 4</div>MATERIALES<br><i class="fa fa-info-circle instructionsBtn" onclick="instrucciones(\'paso4\')"></i></h2><i class="fa fa-light fa-check"></i>';

    // /* Cambiar el html del elemento con id `menu_estado_actual_movil` a
    // `menu_estado_actual_movil_paso_4` */
    // $("#menu_materiales_movil").html(check_movil_paso_4);
    // $("#menu_materiales").html(check_paso_4);
    // $("#submenu_paso4").html("");


    // $("#screenshot_paso_4").hide();
    // $("#btnFinalizar").show();
//7mar ************************************************************************************************
    console.log('dintro de paso 2')
    $("#screenshot_paso_2").attr("style", "pointer-events: none;");
    $("#screenshot_paso_2 > span").html("Guardando...");
    save();

    if (localStorage.getItem("history") == null) {
        setTimeout(function () {
            $("#screenshot_paso_2").attr("style", "pointer-events: unset;");
            $("#screenshot_paso_2 > span").html("Siguiente paso");
        }, 2000);
        console.log("dntro de if 1")
    } else {
        console.log("dintro de else")
        hide();

        const container = document.querySelector('#bloque_materiales');
        container.style.cssText = 'display: block; width: 100vw; height: 100vh; top: 0; right: 0;';

        html2canvas(document.body).then((canvas) => {
            let photo = canvas.toDataURL("image/jpeg");

            $.ajax({
                method: "POST",
                dataType: "json",
                url: "ajax/photo_upload_materiales.php",
                data: {
                    photo: photo,
                    id: id_plano,
                },
                success: function (mensaje) {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        async: false,
                        url: "ajax/guardar_materiales.php",
                        data: {
                            id: id_plano,
                            dibujo: dibujo,
                            observaciones_texto: observaciones_texto,
                            altura_techo: altura_techo,
                        },
                        success: function (respuesta) {
                            show();
                            container.style.cssText = 'display: block;';
                            $("#screenshot_paso_4").hide();
                            $("#btnFinalizar").show();
                        },
                    });

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        async: false,
                        url: "ajax/foto_materiales.php",
                        data: {
                            id: id_plano,
                        },
                        success: function (respuestas) {
                            hideMenus();

                            const myButton = document.getElementById(
                                "menu_materiales_movil"
                            );
                            const my_button = document.getElementById(
                                "menu_materiales"
                            );

                            myButton.style.opacity = 0.5;
                            myButton.style.cursor = "not-allowed";
                            my_button.style.opacity = 0.5;
                            my_button.style.cursor = "not-allowed";

                            $("#menu_materiales_movil").addClass(
                                "desactivo"
                            );
                            $("#menu_materiales").addClass(
                                "menu_estado_inactivo"
                            );

                            $("#menu_materiales").unbind("click");
                            $("#menu_materiales_movil").unbind("click");

                            const check_movil_paso_4 =
                                '<span class="numeropaso"> PASO 4 </span> <br> MATERIALES <br> <i class="fa fa-light fa-check"></i>';
                            const check_paso_4 =
                                '<h2 class="titular-planificador"><div style="color:#95C11F;">PASO 4</div>MATERIALES<br><i class="fa fa-info-circle instructionsBtn" onclick="instrucciones(\'paso4\')"></i></h2><i class="fa fa-light fa-check"></i>';

                            $("#menu_materiales_movil").html(check_movil_paso_4);
                            $("#menu_materiales").html(check_paso_4);
                            $("#submenu_paso4").html("");
                        },
                    });
                },
            });
        });
    }
//5dar ***********************************************************************************
});

///- ╔════════════════════════════════════════════════════════════════════════════════════════╗
///- ║ //mov ************************** Paso 4 end ********************************** ///-    ║
///- ╚════════════════════════════════════════════════════════════════════════════════════════╝

///  ╔════════════════════════════════════════════════════════════════════════════════════════╗
///  ║ //zra9 ************************* Paso 5 start ******************************** ///     ║
///  ╚════════════════════════════════════════════════════════════════════════════════════════╝
function btnFinalizar() {
    hideMenus();

    //Desactivar botón paso 5
    const myButton = document.getElementById(
        "menu_equipamiento_movil"
    );
    const my_button = document.getElementById(
        "menu_equipamiento"
    );

    /* Cambiando la opacidad del botón a 0.5 y el cursor a no permitido. */
    myButton.style.opacity = 0.5;
    myButton.style.cursor = "not-allowed";
    my_button.style.opacity = 0.5;
    my_button.style.cursor = "not-allowed";

    /* Añadir una clase al elemento con id `menu_estado_actual_movil` y al
    elemento con id `menu_estado_actual`. */
    $("#menu_equipamiento_movil").addClass(
        "desactivo"
    );
    $("#menu_equipamiento").addClass(
        "menu_estado_inactivo"
    );

    /* Eliminar el evento click del elemento con id `menu_estado_actual`. */
    $("#menu_equipamiento").unbind("click");
    $("#menu_equipamiento_movil").unbind("click");

    /* Definir una variable llamada check_movil_paso_5 y check_paso_3. */
    const check_movil_paso_5 =
        '<span class="numeropaso"> PASO 5 </span> <br> EQUIPAMIENTO <br> <i class="fa fa-light fa-check"></i>';
    const check_paso_5 =
        '<h2 class="titular-planificador"><div style="color:#95C11F;">PASO 5</div>EQUIPAMIENTO<br><i class="fa fa-info-circle instructionsBtn" onclick="instrucciones(\'paso5\')"></i></h2><i class="fa fa-light fa-check"></i>';

    /* Cambiar el html del elemento con id `menu_estado_actual_movil` a
    `menu_estado_actual_movil_paso_5` */
    $("#menu_equipamiento_movil").html(check_movil_paso_5);
    $("#menu_equipamiento").html(check_paso_5);
    $("#submenu_paso5").html("");

    $("#btnFinalizar").hide();
}

///- ╔════════════════════════════════════════════════════════════════════════════════════════╗
///- ║ //mov ************************** Paso 5 end ********************************** ///-    ║
///- ╚════════════════════════════════════════════════════════════════════════════════════════╝