  <!-- Navigation -->
  <?php
  if (!isset($_GET["paso"]) || $_GET["paso"] == 1)
  {
	  $logo="iconos/logo_blanco.png";
  }
  else
  {
	  $logo="iconos/logo.png";
  }
  ?>
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="index.php">
		  <img src="<?php echo $logo;?>" width="199">
		
	 </a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
		  <div class="frase">TU PRESUPUESTO DE REFORMA EN 6 SENCILLOS PASOS</div>
        <ul class="navbar-nav">
          <li class="nav-item">
			  <span class="nav-presupuestador">1. TU REFORMA</span><br/><div class="barra_progreso <?php if (!isset($_GET["paso"]) || $_GET["paso"] == 1) { ?> activo <?php } else if (isset($_GET["paso"]) && $_GET["paso"] != 1) { ?> completado <?php } ?>"></div>
          </li>
          <li class="nav-item">
			  <span class="nav-presupuestador">2. PRESUPUESTO IKEA</span><br/><div class="barra_progreso <?php if (isset($_GET["paso"]) && $_GET["paso"] == 2) { ?> activo <?php } else if (isset($_GET["paso"]) && $_GET["paso"] > 2) { ?> completado <?php } ?>"></div>
          </li>
          <li class="nav-item">
			  <span class="nav-presupuestador">3. PLANIFICA</span><br/><div class="barra_progreso <?php if (isset($_GET["paso"]) && $_GET["paso"] == 3) { ?> activo <?php } else if (isset($_GET["paso"]) && $_GET["paso"] > 3) { ?> completado <?php } ?>"></div>
          </li>
          <li class="nav-item">
			  <span class="nav-presupuestador">4. PERSONALIZA</span><br/><div class="barra_progreso <?php if (isset($_GET["paso"]) && $_GET["paso"] == 4) { ?> activo <?php } else if (isset($_GET["paso"]) && $_GET["paso"] > 4) { ?> completado <?php } ?>"></div>
          </li>
		  <li class="nav-item">
			  <span class="nav-presupuestador">5. TU PRESUPUESTO</span><br/><div class="barra_progreso <?php if (isset($_GET["paso"]) && $_GET["paso"] == 5) { ?> activo <?php } else if (isset($_GET["paso"]) && $_GET["paso"] > 5) { ?> completado <?php } ?>"></div>
          </li>
		  <li class="nav-item">
			  <span class="nav-presupuestador">6. CITA PREVIA</span><br/><div class="barra_progreso <?php if (isset($_GET["paso"]) && $_GET["paso"] == 6) { ?> activo <?php } else if (isset($_GET["paso"]) && $_GET["paso"] > 6) { ?> completado <?php } ?>"></div>
          </li>
        </ul>
      </div>
    </div>
  </nav>