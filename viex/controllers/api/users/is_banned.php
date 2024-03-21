<?php
session_start();

date_default_timezone_set('America/Argentina/Buenos_Aires');
$conn = mysqli_connect('localhost', 'root', '', 'fooder');
if (!$conn) {
  die('Error de Conexión (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
}
mysqli_set_charset($conn, "utf8");


if (isset($_SESSION['user'])) {
  $sqlIsBanned = "SELECT * FROM `bans` WHERE user_id = " . $_SESSION['user']['id'] . " AND (end_at > now() OR permaban IS NOT NULL)";
  $resIsBanned = mysqli_query($conn, $sqlIsBanned);
  if (!$resIsBanned) {
    exit("Error de consulta" . mysqli_error($conn));
  }


  if (mysqli_num_rows($resIsBanned) == 1) {
    $rowIsBanned = mysqli_fetch_assoc($resIsBanned);
    // Cuenta se encuentra baneada
    session_unset();
    session_destroy();

    if (isset($_COOKIE['email']) || isset($_COOKIE['password'])) {
      unset($_COOKIE['email']);
      unset($_COOKIE['password']);
      setcookie('email', $_POST['email'], time() - 20 * 86400, '/');
      setcookie('password', sha1($_POST['password']), time() - 20 * 86400, '/');
    }

    $message = [
      'message' => "Error",
      'reason' => "La cuenta se encuentra baneada"
    ];
  } else {
    // Cuenta no baneada
    $message = [
      'message' => "Hecho",
      'reason' => "La cuenta no se encuentra baneada"
    ];
  }
}

header("Content-Type: application/json; charset=utf-8");
return print_r(json_encode($message));
