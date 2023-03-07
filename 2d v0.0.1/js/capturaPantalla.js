//5dar: Start btnSiguientePaso
$("#screenshot").click(function () {
    $("#screenshot").attr("style", "pointer-events: none;");
    $("#screenshot > span").html("Guardando...");
    save();

    if (localStorage.getItem("history") == null) {
        alertify.alert(
            "Debes dibujar el estado actual de tu cocina antes de continuar"
        );
        setTimeout(function () {
            $("#screenshot").attr("style", "pointer-events: unset;");
            $("#screenshot > span").html("Siguiente paso");
        }, 2000);
    } else {
        let dibujo = localStorage.getItem("history");
        let observaciones_texto = $("#textarea_observaciones").val();
        let altura_techo = $("#altura_techo_actual").val();

        //alert(observaciones_texto);
        //Elimino el div de las observaciones para que no salga en el pantallazo
        $("#observaciones_plano").hide(); 
        $("#parte_superior").attr("style", "display:none");
        $("#moveBox").attr("style", "display:none");
        $("#zoomBox").attr("style", "display:none");
        $("#titulo_estado_actual").hide();
        $("#imagen_bloque_estado_actual").hide();
        $("#bloque_estado_actual").hide();

        jQuery("#boxRib > text").each(function () {
            jQuery(this).attr("font-size", "0.80em");
        });

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
                    localStorage.setItem("estado_actual", mensaje.id);

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
                            //     "https://rehubik.com/presupuestador/2d v0.0.1/index.php"
                            // );
                            
                            $("#observaciones_plano").show(); 
                            $("#parte_superior").attr("style", "display:block");
                            $("#moveBox").attr("style", "display:block");
                            $("#zoomBox").attr("style", "display:block");
                            $("#titulo_estado_actual").show();
                            $("#imagen_bloque_estado_actual").show();
                            $("#bloque_estado_actual").show();
                            // $("#screenshot").attr("style", "background-color: #99999987 !important; cursor: not-allowed;");
                            $("#screenshot").hide();
                            $("#menu_estado_actual_movil").show();
                        },
                    });

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
                            let foto;
                            foto = '<img src="'+photo+'" width="100%" height="">';
                            $('#imagen_bloque_estado_actual').html(foto);
                            console.log(photo);
                            //Desactivar botón paso 1
                            const myButton = document.getElementById('menu_estado_actual_movil');
                            const my_button = document.getElementById('menu_estado_actual');

                            myButton.style.opacity = 0.5;
                            myButton.style.cursor = 'not-allowed';
                            my_button.style.opacity = 0.5;
                            my_button.style.cursor = 'not-allowed';
                            // myButton.addClass("desactivo");
                            $('#menu_estado_actual_movil').addClass("desactivo");
                            $("#menu_estado_actual").addClass(
                                "menu_estado_actual_inactivo"
                            );
                            hideMenus();
                            let check_movil = '<span class="numeropaso"> PASO 1 </span> <br> DIBUJA EL ESTADO ACTUAL <br> <i class="fa fa-light fa-check"></i>';
                            let check = '<h2 class="titular-planificador"><div style="color:#95C11F;">PASO 1</div>DIBUJA EL ESTADO ACTUAL<br><i class="fa fa-info-circle instructionsBtn" onclick="instrucciones(\'paso1\')"></i></h2><i class="fa fa-light fa-check"></i>';
                            
                            $('#menu_estado_actual_movil').html(check_movil);
                            $('#menu_estado_actual').html(check);
                            $('#submenu_paso1').html('');
                        },
                    });
                },
            });

            //photo.download = 'ss.png';
        });
    }
});
//7mar: Fin btnSiguientePaso
