 <div class="row">  
			 <div class="col-md-12"><h5>CENTROS</h5></div> 
		 </div>
		  
		<div class="row"> 
		 <div class="col-md-12">
			<ul>
		  <?php
			$result_centros=$mysqli->query("SELECT * FROM centros");

		    while ($arr_result_centros = $result_centros->fetch_array())
			{
		  ?>
				<li style="margin-bottom:15px;display:inline-block;width:33%"><b><a href="ver_verificadores.php?id=<?php echo $arr_result_centros['id_centro'];?>"><?php echo utf8_encode($arr_result_centros["nombre"]);?></a></b><br><?php echo strtoupper($arr_result_centros["ciudad"]);?></li> 
		  <?php
			}
		  ?> 
			</ul>
		</div> 
		</div>    