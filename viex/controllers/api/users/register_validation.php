<?php

if (!empty($_POST)) {
  $username = trim($_POST['username']);
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $cpassword = $_POST['confirmpassword'];

  require_once "../../../includes/config.php";
  // Comprueba que no exista ninguna cuenta con ese email
  $sqlCheckEmail = "SELECT * FROM users WHERE email='$email'";
  $resultCheckEmail = mysqli_query($conn, $sqlCheckEmail);

  // Comprueba que no exista ninguna cuenta con ese username
  $sqlCheckUsername = "SELECT * FROM users WHERE username='$username'";
  $resultCheckUsername = mysqli_query($conn, $sqlCheckUsername);

  $message = [];
  if (($username != null && strlen($username) < 31) && ($name != null && strlen($name) < 41) && ($email != null && strlen($email) < 301) && ($password != null && strlen($password) > 7) && ($cpassword != null) && ($password == $cpassword) && (!mysqli_num_rows($resultCheckEmail) > 0) && (!mysqli_num_rows($resultCheckUsername) > 0) &&  (preg_match('/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/', $email))) {
    // bien
    $sqlRegister = "INSERT INTO users (username, name, email, password, created_at) VALUES ('" . $username . "', '" . $name . "', '" . $email . "', '" . sha1($password) . "', now())";
    $resultRegister = mysqli_query($conn, $sqlRegister);

    if ($resultRegister) {
      $sqlLogin = "SELECT users.*, users_roles.role_id FROM users 
                  LEFT JOIN users_roles 
                    ON users.id = users_roles.user_id
                  WHERE users.email='" . trim($_POST['email']) . "' AND users.password='" . sha1($_POST['password']) . "' AND users.deleted_at IS NULL";
      $resultLogin = mysqli_query($conn, $sqlLogin);
      if (!$resultLogin) {
        exit("Error de consulta" . mysqli_error($conn));
      }
      if (mysqli_num_rows($resultLogin) === 1) {
        $rowLogin = mysqli_fetch_assoc($resultLogin);
        $sqlRoles = "INSERT INTO users_roles(user_id, role_id) VALUES ('" . $rowLogin['id'] . "', '1')";
        $resRoles = mysqli_query($conn, $sqlRoles);
        if (!$resRoles) {
          exit("Error de consulta" . mysqli_error($conn));
        }

        
        $_SESSION['user'] = $rowLogin;
        $message['message'] = "Se ha registrado correctamente";
      }
    } else {
      die('Error de Consulta ' . mysqli_error($conn));
    }
  } else {
    $message['message'] = "Error al registrarse";

    // Ya existe una cuenta con ese email
    if (mysqli_num_rows($resultCheckEmail)) $message['email'] =  "El correo electronico ya esta en uso.";
    // Ya existe una cuenta con ese username 
    if (mysqli_num_rows($resultCheckUsername) > 0) $message['username'] = "El nombre de usuario ya esta en uso";

    // Contraseña con menos de 8 digitos
    if (strlen($password) < 8) $message['password'] = "Ingrese una combinacion con al menos ocho caracteres";
    // Contraseñas no coincide los campos
    if ($password != $cpassword) $message['cpassword'] = "Las contraseñas no coinciden.";

    // Maximo de caracteres
    if (strlen($username) > 30) $message['username'] = "El nombre de usuario es demasiado largo";
    if (strlen($name) > 40) $message['name'] = "El nombre es demasiado largo";
    if (strlen($email) > 300) $message['email'] = "El correo electronico es demasiado largo";

    // Correo electronico invalido
    if (!preg_match('/^([a-zA-Z0-9\.]+@+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/', $email)) $message['email'] = "Ingrese un correo electronico valido";

    // Campos vacios
    if (!$email) $message['email'] = "Por favor ingrese un correo electronico";
    if (!$username) $message['username'] = "Por favor ingrese un nombre de usuario";
    if (!$name) $message['name'] = "Por favor ingrese un nombre";
    if (!$password) $message['password'] = "Por favor ingrese una contraseña";
    if (!$cpassword) $message['cpassword'] = "Por favor confirme su contraseña";
  }
  header("Content-Type: application/json; charset=utf-8");
  return print_r(json_encode($message));
}
