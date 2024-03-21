<?php

require_once('../../includes/config.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] == 1) {
  // No tiene el rango para poder ver esta pagina
  header("location: home.php");
}



$page = "Categorias - Moderacion";
$section = "mod/categories";
require_once('../../views/layout.php');
