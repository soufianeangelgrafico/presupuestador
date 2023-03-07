$("#agregar_sc_buscador").click(function() {
    var sc = document.getElementById("sc").value;
    $.ajax({
        type: "POST",
        data: {
            sc: sc
        },
        dataType: 'json',
        async: false,
        url: "ajax/guardar_sc_buscador.php?id_presupuesto=<?php echo $_GET['id_presupuesto']; ?>",
        success: function(respuesta) {
            if (respuesta.error == 1)
                alertify.error(respuesta.mensaje);
            else {
                alertify.success(respuesta.mensaje);
                document.getElementById("listado_sc_guardados").innerHTML += "<p id='" + respuesta.codigo + "'>" + respuesta.codigo + " <span style='color:red;font.weight:bold;cursor:pointer;' onclick='eliminaSC(\"" + respuesta.codigo + "\")'>ELIMINAR</span></p>";
            }
            document.getElementById("sc").value = "";
        }
    });
})

availableTags = [];
$.ajax({
    type: "POST",
    dataType: 'json',
    async: false,
    url: "ajax/obtener_sc.php",
    success: function(respuesta) {
        availableTags = respuesta;
        console.log("AVAILABLE TAGS");
        console.log(availableTags);
    }
});

$(function() {
    /*var availableTags = [
        "ActionScript",
        "AppleScript",
        "Asp",
        "BASIC",
        "C",
        "C++",
        "Clojure",
        "COBOL",
        "ColdFusion",
        "Erlang",
        "Fortran",
        "Groovy",
        "Haskell",
        "Java",
        "JavaScript",
        "Lisp",
        "Perl",
        "PHP",
        "Python",
        "Ruby",
        "Scala",
        "Scheme"
    ];
    */
    $("#sc").autocomplete({
        source: availableTags
    });
});

$("#agregar_sc_nuevo").click(function() {
    var formulario = $("#form_nuevo_sc").serialize();
    //nuevo_sc / descripcion_sc / precio_sc
    //alert(formulario);
    $.ajax({
        type: "POST",
        data: formulario,
        dataType: 'json',
        async: false,
        url: "ajax/guardar_sc_nuevo.php?id_presupuesto=<?php echo $_GET['id_presupuesto']; ?>",
        success: function(respuesta) {
            if (respuesta.error == 1)
                alertify.error(respuesta.mensaje);
            else {
                alertify.success(respuesta.mensaje);
                document.getElementById("listado_sc_guardados").innerHTML += "<p id='" + respuesta.codigo + "'>" + respuesta.codigo + " <span style='color:red;font.weight:bold;cursor:pointer;' onclick='eliminaSC(\"" + respuesta.codigo + "\")'>ELIMINAR</span></p>";
            }
            $('#form_nuevo_sc').trigger("reset");
        }
    });
})

function eliminaSC(codigo) {
    codigo_sc = codigo;
    $.ajax({
        type: "POST",
        data: {
            codigo_sc: codigo_sc
        },
        dataType: 'json',
        async: false,
        url: "ajax/eliminar_sc.php?id_presupuesto=<?php echo $_GET['id_presupuesto']; ?>",
        success: function(respuesta) {
            if (respuesta.error == 1)
                alertify.error(respuesta.mensaje);
            else {
                alertify.success(respuesta.mensaje);
                $('#' + codigo_sc).remove();
            }
        }
    });
}

/*
$("#btnFinalizarVerificador").click(function() {
    var id="";
    var entro=false;
    var formularios=[];
    var contador=0;
    var altura_paredes=document.getElementById("altura_paredes").value;
    
    if (altura_paredes != "")
    {
    $(".elemento_instalacion.selected").each(function() {
        entro=true;
        //Por cada elemento seleccionado, detecto si es muro o unidades y lo añado a la cookie
        var formulario=$("form[name='"+this.id+"']").serialize();
        var id=this.id;
        console.log(formulario);
        //alert(formulario);
        $.ajax({
            type: "POST",
            dataType: 'json', 
            async:false,
            url: "ajax/finalizar_plano_verificador.php?altura_paredes="+altura_paredes+"&id_presupuesto=<?php //echo $_GET['id_presupuesto']; ?>",
            data: formulario,
            success:function(respuesta){	
                alertify.success(respuesta.mensaje);
                
            }
        });
        contador++;
        
    })
    
    if (!entro)
    alertify.error("Debes seleccionar, al menos, un elemento de instalaciones y equipamiento para finalizar el plano")
    else
    {
        save();
        var numero_muros=$(".muro").length;
        var contenido=HISTORY[0]; //El último muro es el que tiene la info de todo el dibujo
        console.log("OJO, el CONTENIDO ES "+contenido);
        var elementos_dibujados=$("#boxEnergy").html();
        var puertas_ventanas=$("#boxcarpentry").html();
        var observaciones=$("#boxText").html();
        var observaciones_texto=$("#anotaciones_observacion").html(); 
        
        $.ajax({
                type: "POST",
                dataType: 'json', 
                async:false,
                url: "ajax/guardar_dibujo2d_verificador.php?id_presupuesto=<?php //echo $_GET['id_presupuesto']; ?>",
                data: {contenido:contenido,elementos_dibujados:elementos_dibujados,puertas_ventanas:puertas_ventanas,observaciones:observaciones,observaciones_texto:observaciones_texto},
                success:function(respuesta){	
                }
        });
        //window.location.assign("https://rehubik.com/presupuestador/2d/registro_cliente.php"); 
    }
}
else
{
    alertify.error("Debes especificar la altura de las paredes en el PASO 1"); 
}
    
})
 */