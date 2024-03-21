<?php


require_once "../../includes/config.php";

$search = (isset($_GET['search'])) ? trim($_GET['search']) : "";
if (isset($_GET['for'])) {
  $option = 2;
} else {
  $option = 1;
}

$page = "Busqueda Receta";
$section = "searches";
require_once "../../views/layout.php";
