<?php
require_once('../../includes/config.php');



if (isset($_SESSION['user'])) {
  header('location: home.php');
}

$page = "Inicia sesión";
$section = "login";
require_once('../../views/layout2.php');
