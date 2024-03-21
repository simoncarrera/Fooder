<?php


require_once "../../includes/config.php";

if (!isset($_SESSION['user'])) {
  header('location: login.php');
}

$page = "Publicar receta";
$section = "post_recipe";
require_once('../../views/layout.php');
