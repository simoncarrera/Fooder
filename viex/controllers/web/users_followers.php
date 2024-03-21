<?php



require_once "../../includes/config.php";

if (is_numeric($_GET['id'])) {
  $sqlUsername = "SELECT username FROM users WHERE id = '" . $_GET['id'] . "' AND deleted_at IS NULL";
  $resUsername = mysqli_query($conn, $sqlUsername);
  if (!$resUsername) {
    die('Error de Consulta' . mysqli_error($conn));
  }
  $rowUsername = mysqli_fetch_assoc($resUsername);

  if (mysqli_num_rows($resUsername) != 1) {
    header("Location: home.php");
  }
} else {
  header("Location: home.php");
}

$page = "Usuarios Seguidores";
$section = "users_followers";
require_once "../../views/layout.php";
