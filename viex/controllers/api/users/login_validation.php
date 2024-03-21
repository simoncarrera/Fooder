<?php

if (!empty($_POST)) {
  require_once('../../../includes/config.php');

  $sqlLogin = "SELECT * FROM users WHERE email='" . trim($_POST['email']) . "' AND deleted_at IS NULL";
  $resultLogin = mysqli_query($conn, $sqlLogin);

  $message = ["message" => "Error al iniciar sesión"];
  if (mysqli_num_rows($resultLogin) === 1) {
    $sqlLogin = "SELECT users.*, users_roles.role_id FROM users 
                  INNER JOIN users_roles 
                    ON users.id = users_roles.user_id
                  WHERE users.email='" . trim($_POST['email']) . "' AND users.password='" . sha1($_POST['password']) . "' AND users.deleted_at IS NULL";
    $resultLogin = mysqli_query($conn, $sqlLogin);
    if (mysqli_num_rows($resultLogin) === 1) {
      $sqlIsBan = "SELECT users.username, bans.end_at, bans.permaban FROM users 
                    INNER JOIN bans
                      ON users.id = bans.user_id AND (bans.end_at > now() OR bans.permaban IS NOT NULL)
                    WHERE users.email= '" . trim($_POST['email']) . "' AND users.password='" . sha1($_POST['password']) . "' AND users.deleted_at IS NULL";
      $resultIsBan = mysqli_query($conn, $sqlIsBan);

      if (mysqli_num_rows($resultIsBan) === 0) {
        $_SESSION['user'] = mysqli_fetch_assoc($resultLogin);

        if (isset($_POST['remember']) && $_POST['remember']) {
          setcookie('email', $_POST['email'], time() + 20 * 86400, '/');
          setcookie('password', sha1($_POST['password']), time() + 20 * 86400, '/');

          $_COOKIE['email'] = $_POST['email'];
          $_COOKIE['password'] = $_POST['password'];
        }

        $message['message'] = "Se ha iniciado sesión correctamente";
      } else {
        // La cuenta esta baneada
        $rowIsBan = mysqli_fetch_assoc($resultIsBan);
        $message['account'] = 'Actualmente te encuentras baneado, para más información, revisa tu correo';  
      }
    } else {
      // Error en la autentificacion 
      $message['password'] = "La contraseña no es correcta";
    }
  } else {
    // Error en la autentificacion 
    $message['email'] = "El correo electronico no esta asociado a ninguna cuenta";
  }
  header("Content-Type: application/json; charset=utf-8");
  return print_r(json_encode($message));
}
