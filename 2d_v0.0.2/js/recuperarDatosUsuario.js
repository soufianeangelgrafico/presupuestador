$.ajax({
    type: "POST",
    async: false,
    url: "ajax/sacar_dibujo2d.php",
    data: {
        id_presupuesto: id_presupuesto
    },
    success: function(mensaje) {
        localStorage.setItem("history", mensaje);
        var historyTemp = JSON.parse(localStorage.getItem('history'));
        load(historyTemp.length - 1, "boot");
        save("boot");
    }
});

//Saco elementos dibujados
/*$.ajax({
        type: "POST",
        dataType: 'json', 
        async:false,
        url: "ajax/sacar_boxenergy.php",
        data: {id_presupuesto:id_presupuesto},
        success:function(respuesta){	
            console.log("Mensaje!");
            console.log(respuesta.mensaje);
            $("#boxEnergy").html(respuesta.mensaje);
        }

});
*/
//Saco paredes y puertas
/*
$.ajax({
            type: "POST",
            dataType: 'json', 
            async:false,
            url: "ajax/sacar_boxcarpentry.php",
            data: {id_presupuesto:id_presupuesto},
            success:function(respuesta){	
                console.log("Mensaje!");
                console.log(respuesta.mensaje);
                $("#boxcarpentry").html(respuesta.mensaje);
            }
});
*/
//Saco observaciones
$.ajax({
    type: "POST",
    dataType: 'json',
    async: false,
    url: "ajax/sacar_observaciones_estado_reformado.php",
    data: {
        id_presupuesto: id_presupuesto
    },
    success: function(respuesta) {
        console.log(respuesta.mensaje);
        $("#boxText").html(respuesta.mensaje);
    }
});

console.log("HISTORY PUSH ES ");
console.log(HISTORY);
/*HISTORY.push({"objData":[],"wallData":[{"thick":20,"start":{"x":905,"y":85.21875},"end":{"x":1240.5,"y":85.21875},"type":"normal","parent":7,"child":1,"angle":0,"equations":{"up":{"A":"h","B":84.21875},"down":{"A":"h","B":86.21875},"base":{"A":"h","B":85.21875}},"coords":[{"x":905,"y":84.21875},{"x":905,"y":86.21875},{"x":1240.5,"y":86.21875},{"x":1240.5,"y":84.21875}],"backUp":false,"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":1240.5,"y":85.21875},"end":{"x":1240.5,"y":211.03125},"type":"normal","parent":null,"child":2,"angle":1.5707963267948966,"equations":{"up":{"A":"v","B":1241.5},"down":{"A":"v","B":1239.5},"base":{"A":"v","B":1240.5}},"coords":[{"x":1241.5,"y":85.21875},{"x":1239.5,"y":85.21875},{"x":1239.5,"y":211.03125},{"x":1241.5,"y":211.03125}],"backUp":false,"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":1240.5,"y":211.03125},"end":{"x":1129.125,"y":211.03125},"type":"normal","parent":null,"child":3,"angle":3.141592653589793,"equations":{"up":{"A":"h","B":210.03125},"down":{"A":"h","B":212.03125},"base":{"A":"h","B":211.03125}},"coords":[{"x":1240.5,"y":210.03125},{"x":1240.5,"y":212.03125},{"x":1129.125,"y":212.03125},{"x":1129.125,"y":210.03125}],"backUp":false,"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":1129.125,"y":211.03125},"end":{"x":1129.125,"y":119.59375},"type":"normal","parent":null,"child":4,"angle":-1.5707963267948966,"equations":{"up":{"A":"v","B":1130.125},"down":{"A":"v","B":1128.125},"base":{"A":"v","B":1129.125}},"coords":[{"x":1130.125,"y":211.03125},{"x":1128.125,"y":211.03125},{"x":1128.125,"y":119.59375},{"x":1130.125,"y":119.59375}],"backUp":false,"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":1129.125,"y":119.59375},"end":{"x":1022.5625,"y":119.59375},"type":"normal","parent":null,"child":5,"angle":3.141592653589793,"equations":{"up":{"A":"h","B":118.59375},"down":{"A":"h","B":120.59375},"base":{"A":"h","B":119.59375}},"coords":[{"x":1129.125,"y":118.59375},{"x":1129.125,"y":120.59375},{"x":1022.5625,"y":120.59375},{"x":1022.5625,"y":118.59375}],"backUp":false,"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":1022.5625,"y":119.59375},"end":{"x":1022.5625,"y":208.96875},"type":"normal","parent":null,"child":6,"angle":1.5707963267948966,"equations":{"up":{"A":"v","B":1023.5625},"down":{"A":"v","B":1021.5625},"base":{"A":"v","B":1022.5625}},"coords":[{"x":1023.5625,"y":119.59375},{"x":1021.5625,"y":119.59375},{"x":1021.5625,"y":208.96875},{"x":1023.5625,"y":208.96875}],"backUp":false,"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":1022.5625,"y":208.96875},"end":{"x":905,"y":208.96875},"type":"normal","parent":null,"child":7,"angle":3.141592653589793,"equations":{"up":{"A":"h","B":207.96875},"down":{"A":"h","B":209.96875},"base":{"A":"h","B":208.96875}},"coords":[{"x":1022.5625,"y":207.96875},{"x":1022.5625,"y":209.96875},{"x":905,"y":209.96875},{"x":905,"y":207.96875}],"backUp":false,"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":905,"y":208.96875},"end":{"x":905,"y":85.21875},"type":"normal","parent":null,"child":null,"angle":-1.5707963267948966,"equations":{"up":{"A":"v","B":906},"down":{"A":"v","B":904},"base":{"A":"v","B":905}},"coords":[{"x":906,"y":208.96875},{"x":904,"y":208.96875},{"x":904,"y":85.21875},{"x":906,"y":85.21875}],"backUp":false,"graph":{"0":{},"context":{},"length":1}}],"roomData":[{"coords":[{"x":905,"y":209},{"x":1023,"y":209},{"x":1023,"y":120},{"x":1129,"y":120},{"x":1129,"y":211},{"x":1241,"y":211},{"x":1241,"y":85},{"x":905,"y":85},{"x":905,"y":209}],"coordsOutside":[{"x":1033,"y":219},{"x":1033,"y":130},{"x":1119,"y":130},{"x":1119,"y":221},{"x":1251,"y":221},{"x":1251,"y":75},{"x":895,"y":75},{"x":895,"y":219},{"x":1033,"y":219}],"coordsInside":[{"x":1013,"y":199},{"x":1013,"y":110},{"x":1139,"y":110},{"x":1139,"y":201},{"x":1231,"y":201},{"x":1231,"y":95},{"x":915,"y":95},{"x":915,"y":199},{"x":1013,"y":199}],"inside":[],"way":["7","6","5","4","3","2","0","1","7"],"area":21834,"surface":"","name":"","color":"gradientWhite","showSurface":true,"action":"add"}]});*/