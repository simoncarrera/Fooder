<?php
$message = ["message" => "Error"];
if (!isset($_SESSION['user'])) {
  require_once('../../../includes/config.php');

  // Cambios editar perfil 
  if (!empty($_POST)) {
    $name = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $gender = $_POST['gender'];
    $biography = trim($_POST['biography']);

    $sqlCheckUsername = "SELECT * FROM users WHERE username='$username' AND username != '" . $_SESSION['user']['username'] . "'";
    $resultCheckUsername = mysqli_query($conn, $sqlCheckUsername);
    $sqlCheckEmail = "SELECT * FROM users WHERE email='$email' AND email != '" . $_SESSION['user']['email'] . "'";
    $resultCheckEmail = mysqli_query($conn, $sqlCheckEmail);

    if ((!mysqli_num_rows($resultCheckUsername) > 0) && (!mysqli_num_rows($resultCheckEmail) > 0) && ($username != null && strlen($username) < 31) && ($name != null && strlen($name) < 41) && ($email != null && strlen($email) < 301) && (preg_match('/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/', $email)) && (strlen($biography) < 301)) {
      $sqlEdit = "UPDATE users SET username = '$username', name = '$name', email = '$email', biography = '$biography', gender = '$gender', modified_at= now() WHERE id= '" . $_SESSION['user']['id'] . "'";
      $resultEdit = mysqli_query($conn, $sqlEdit);
      if ($resultEdit) {
        if (isset($_COOKIE['email'])) {
          setcookie('email', trim($_POST['email']), time() + 20 * 86400, '/');

          $_COOKIE['email'] = trim($_POST['email']);
        }

        $message = [
          'message' => "Hecho",
          'action' => "Se han hechos los cambios correctamente"
        ];
      } else {
        die('Error de consulta' . mysqli_error($conn));
      }
    } else {
      $message['reason'] = "Problema en las validaciones";

      // Ya existe una cuenta con ese email
      if (mysqli_num_rows($resultCheckEmail)) $message['error_email'] = "El correo electronico ya esta en uso.";
      // Ya existe una cuenta con ese username 
      if (mysqli_num_rows($resultCheckUsername) > 0) $message['error_username'] =  "El nombre de usuario ya esta en uso";

      // Maximo de caracteres
      if (strlen($username) > 30) $message['error_username'] = "El nombre de usuario es demasiado largo";
      if (strlen($name) > 40) $message['error_name'] = "El nombre es demasiado largo";
      if (strlen($email) > 300) $message['error_email'] = "El correo electronico es demasiado largo";
      if (strlen($biography) > 300) $message['error_biography'] = "La biografia demasiado larga";

      // Email invalido
      if (!preg_match('/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/', $email)) $message['error_email'] = "Ingrese un correo electronico valido";

      // Campos vacios
      if (!$email) $message['error_email'] = "Por favor ingrese un correo electronico";
      if (!$username) $message['error_username'] =  "Por favor ingrese un nombre de usuario";
      if (!$name) $message['error_name'] =  "Por favor ingrese un nombre";
    }
  } else {
    // No ingreso ningun valor
    $message['reason'] = "Problema en las validaciones";
    $message['error_email'] = "Por favor ingrese un correo electronico";
    $message['error_username'] = "Por favor ingrese un nombre de usuario";
    $message['error_name'] = "Por favor ingrese un nombre";
  }
} else {
  // No esta logeado
  $message['reason'] = "No estas lgueado";
}

header("Content-Type: application/json; charset=utf-8");
return print_r(json_encode($message));
