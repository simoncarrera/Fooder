<?php
require_once "../../includes/config.php";

if (!isset($_SESSION['user'])) {
  header('location: login.php');
}

if (!empty($_POST)) {

  $sqlVerify = "SELECT password FROM users WHERE id= '" . $_SESSION['user']['id'] . "'";
  $resultVerify = mysqli_query($conn, $sqlVerify);
  $rowVerify = mysqli_fetch_assoc($resultVerify);

  if (mysqli_num_rows($resultVerify) > 0) {
    if ($_POST['newpass'] === $_POST['cnewpass'] && $rowVerify['password'] == sha1($_POST['oldpass']) && $_POST['oldpass'] != null && $_POST['newpass'] != null && $_POST['cnewpass'] != null && strlen($_POST['newpass']) > 7) {
      $sqlChangePass = "UPDATE users SET password = '" . sha1($_POST['newpass']) . "', modified_at= now() WHERE id= '" . $_SESSION['user']['id'] . "'";
      $resultChangePass = mysqli_query($conn, $sqlChangePass);
      if ($resultChangePass) {
        header("Location: change_password.php");
      } else {
        die('Error de Consulta ' . mysqli_error($conn));
      }
    } else {
      // Contraseña vieja que puso esta mal
      if ($rowVerify['password'] != sha1($_POST['oldpass'])) $errormessage_oldpass =  "La contraseña actual no coincide";
      // Las contraseñas no coinciden
      if ($_POST['newpass'] !== $_POST['cnewpass']) $errormessage_cnewpass = "Asegurate de que ambas contraseñas coincidan";

      if (strlen($_POST['newpass']) < 8) $errormessage_newpass = "Ingrese una combinacion con al menos ocho caracteres";

      // Campos vacios
      if (!$_POST['oldpass']) $errormessage_oldpass = "Por favor ingrese su contraseña actual";
      if (!$_POST['newpass']) $errormessage_newpass = "Por favor ingrese una nueva contraseña";
      if (!$_POST['cnewpass']) $errormessage_cnewpass = "Por favor confirme su nueva contraseña";
    }
  }
}



$page = "Cambiar contraseña";
$section = "change_password";
require_once "../../views/layout.php";
