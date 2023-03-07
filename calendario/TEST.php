<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/dateTimePicker.css">
  </head>
  <body>
    <div class="container">
       <div id="calendario" data-toggle="calendar" ></div>    
  </div>
    <script type="text/javascript" src="scripts/components/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/dateTimePicker.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function()
		{
			  $('#calendario').calendar();
		}
	</script>  
  </body>
</html>