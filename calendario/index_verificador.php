<?php
 if (isset($_GET["admin"]))
  $admin=1;
 else
  $admin=0;
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
	  <link rel="stylesheet" href="https://www.zonasrurales.com/propietarios/js/jquery-ui/1.12.1-jquery-ui.calendario.min.css" type="text/css">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/dateTimePicker.css">
	<style>
	div#horas_disponibles * label {
		border: 1px solid black;
		margin: 4px;
		padding: 5px;
		width: 142px;
		display: inline-block;
		background: white;
	}
		div#horas_disponibles {
    width: 300px;
    max-width: 100%;
}
	  </style>
  </head>
  <body style="background:#F0F0F0">
	  <div>Días asignados al verificador: <span id="select-result"></span></div>
	 <select name="horario" id="horario" class="form form-control">
		 <option value="0">Horario de mañana (hasta 14:00)</option>
		 <option value="1">Horario de tarde (DESDE las 14:00)</option>
		 <option value="2">Todo el día</option>
	  </select>
	
	<input type="text" name="tipocita" value="<?php echo $admin;?>" id="tipocita" style="display:none;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div id="basic" data-toggle="calendar"></div>
        </div>
        
      </div>
  	  <div class="row">
		  <div class="col-md-12"><div id="horas_disponibles"></div></div> 
	  </div>	  
      
  </div>
    <script type="text/javascript" src="scripts/components/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/dateTimePicker.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="https://www.zonasrurales.com/propietarios/js/jquery.ui.touch-punch.min.js"></script>  
	  
	  
    <script type="text/javascript" defer="defer">
    $(document).ready(function()
    { 
		 
	  $(document).on("click","#confirmar_cita",function() {
		  
		  var email=localStorage.getItem('presupuesto_email_cliente');
		  var id_presupuesto=localStorage.getItem('id_presupuesto');
		  var tipocita=document.getElementById("tipocita").value;
		  if (confirm("Vas a solicitar cita previa para tu presupuesto Nº "+id_presupuesto))
		  {
			  var formulario=$("#cita_previa").serialize();
			   $.ajax({
					type: "POST",
					dataType: 'json', 
					url: "reservar_cita.php?id_presupuesto="+id_presupuesto+"&email="+email+"&tipocita="+tipocita,
					data: formulario,
					success:function(respuesta){	
					  alert(respuesta.mensaje);
					  location.reload();
					}
			   });
		  }
	  })
		
		
		
		
	  //let today = new Date().toISOString().slice(0, 10)
		// unavailable: ['2019-*-*','2020-1-*'],
      $('#basic').calendar({
		  onSelectDate: function(date, month, year){
           //alert([year, month, date].join('-') + ' está disponible: ' + this.isAvailable(date, month, year));
		   var fecha=[year, month, date].join('-');
		   if (this.isAvailable(date, month, year))
		   {
			  /* Saco los horarios disponibles para esa fecha */
			  $.ajax({
				type: "POST",
				dataType: 'json', 
				url: "obtener_horarios.php",
				data: {fecha:fecha},
				success:function(respuesta){	
				  document.getElementById("horas_disponibles").innerHTML=respuesta.mensaje;
			    }
		     });
		   }
		  
         },
		  unavailable: ['2019-*-*'],
		  adapter: 'server/adapter.php',
		  day_first: 1,
		  day_name: ['D', 'L', 'M', 'MX', 'J', 'V', 'S'],
          month_name: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre']
        });
      
    });
    </script>
	  
	
<script type="text/javascript">
  $( document ).ready(function() {
   $( "#basic" ).click(function() {
		console.log("click");
   });
	  
   $( function() {
    $( "#basic" ).selectable({
	filter:'td',
    selecting: function(event, ui){
        //console.log($(ui.selected));
    },	
      stop: function() {
		var result = $( "#select-result" ).empty();  
        $( ".ui-selected", this ).each(function() {
			
			var texto=$(this).text()
			result.append(texto+", ");
			
			var elemento=this; 
			var clases = elemento.className;
			
			var res = clases.split("_");
			var id_calendario=res[1];
			var horario=document.getElementById("horario").value; //0 mañana - 1 tarde - 2 todo el día
			
			$.ajax({ 
				type: "POST",
				dataType: 'json', 
				async: false,
				url: "scripts/verificadores_asignar_horario.php",
				data: {id_calendario:id_calendario,horario:horario},
				  success:function(respuesta){	 
				  
				}

			}); 
		
			
			
        });
      }
    });
  } );	  
	  
  
  
});
</script>	  
	  
  </body>
</html>