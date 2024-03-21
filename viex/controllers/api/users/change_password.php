<?php

$message = ["message" => "Error"];
if (!isset($_SESSION['user'])) {
  require_once('../../../includes/config.php');
  if (!empty($_POST)) {

    $sqlVerify = "SELECT password FROM users WHERE id= '" . $_SESSION['user']['id'] . "'";
    $resultVerify = mysqli_query($conn, $sqlVerify);
    $rowVerify = mysqli_fetch_assoc($resultVerify);

    if (mysqli_num_rows($resultVerify) > 0) {
      if ($_POST['newpass'] === $_POST['cnewpass'] && $rowVerify['password'] == sha1($_POST['oldpass']) && $_POST['oldpass'] != null && $_POST['newpass'] != null && $_POST['cnewpass'] != null && strlen($_POST['newpass']) > 7) {
        $sqlChangePass = "UPDATE users SET password = '" . sha1($_POST['newpass']) . "', modified_at= now() WHERE id= '" . $_SESSION['user']['id'] . "'";
        $resultChangePass = mysqli_query($conn, $sqlChangePass);
        if ($resultChangePass) {
          if (isset($_COOKIE['password'])) {
            setcookie('password', sha1($_POST['newpass']), time() + 20 * 86400, '/');

            $_COOKIE['password'] = sha1($_POST['newpass']);
          }

          $message = [
            'message' => "Hecho",
            'action' => "Se ha actualizado la contraseña correctamente"
          ];
        } else {
          die('Error de Consulta ' . mysqli_error($conn));
        }
      } else {
        $message['reason'] = "Problema en las validaciones";

        // Contraseña vieja que puso esta mal
        if ($rowVerify['password'] != sha1($_POST['oldpass'])) $message['error_oldpass'] = "La contraseña actual no coincide";
        // Las contraseñas no coinciden
        if ($_POST['newpass'] !== $_POST['cnewpass']) $message['error_cnewpass'] = "Asegurate de que ambas contraseñas coincidan";

        if (strlen($_POST['newpass']) < 8) $message['error_newpass'] = "Ingrese una combinacion con al menos ocho caracteres";
        // Campos vacios 
        if (!$_POST['oldpass']) $message['error_oldpass'] = "Por favor ingrese su contraseña actual";
        if (!$_POST['newpass']) $message['error_newpass'] = "Por favor ingrese una nueva contraseña";
        if (!$_POST['cnewpass']) $message['error_cnewpass'] = "Por favor confirme su nueva contraseña";
      }
    }
  } else {
    // POST vacio
    $message['reason'] = "Problema en las validaciones";
    $message['error_oldpass'] = "Por favor ingrese su contraseña actual";
    $message['error_newpass'] = "Por favor ingrese una nueva";
    $message['error_cnewpass'] = "Por favor confirme su nueva contraseña";
  }
} else {
  // No logueado
  $message['reason'] = "No estas lgueado";
}

header("Content-Type: application/json; charset=utf-8");
return print_r(json_encode($message));
