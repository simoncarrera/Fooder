<?php
require_once "../../includes/config.php";

if (!empty($_POST)) {
  $token = trim($_POST['token']);

  $sql = "SELECT * FROM users WHERE token = '" . $token . "';";
  $result1 = mysqli_query($conn, $sql);
  if (mysqli_num_rows($result1) > 0) {
    $row = mysqli_fetch_assoc($result1);
    $dataConsulta = $row;
  }
  if ($result1) {



    //esta pagina está incompleta

    $linkRecuperar = "http://127.0.0.1/22-4.10-proyectos/viex/controllers/new_password.php?id=" . $dataConsulta['id'] . "&token=" . $token;


    header("Location: new_password.php?id=" . $dataConsulta['id'] . "&token=" . $dataConsulta['token']);
  } else {
    header('Location: login.php');
  }
}



$page = "Restablecer contraseña";
$section = "forgot_password";
require_once('../../views/layout2.php');
