<?php

require_once "../../../includes/config.php";


$user_id = $_POST['user_id'];
// Valido si estan enviando un valor numerico
if (is_numeric($user_id)) {
  $sqlRole = "SELECT * FROM users_roles WHERE user_id= '" . $user_id . "'";
  $resRole = mysqli_query($conn, $sqlRole);
  if (!$resRole) {
    die('Error de Consulta ' . mysqli_error($conn));
  }

  if (mysqli_num_rows($resRole) == 1) {
    $rowRole = mysqli_fetch_assoc($resRole);

    if ($rowRole['role_id'] == 1) {
      // Es rango normal
      $sqlMod = "UPDATE users_roles SET role_id = 2, modified_at = now() WHERE user_id = '" . $user_id . "'";
      $resMod = mysqli_query($conn, $sqlMod);
      if (!$resMod) {
        die('Error de Consulta ' . mysqli_error($conn));
      }
      $message = [
        'message' => "Hecho",
        'action' => "Mod"
      ];
    } else if ($rowRole['role_id'] == 2) {
      // Es mod
      $sqlUnmod = "UPDATE users_roles SET role_id = 1, modified_at = now() WHERE user_id = '" . $user_id . "'";
      $resUnmod = mysqli_query($conn, $sqlUnmod);
      if (!$resUnmod) {
        die('Error de Consulta ' . mysqli_error($conn));
      }
      $message = [
        'message' => "Hecho",
        'action' => "Unmod"
      ];
    } else {
      // Es admin
      $message = [
        'message' => "Error al intentar dar mod",
        'reason' => "El usuario es administrador"
      ];
    }
  } else {
    // No existe el usuario
    $message = [
      'message' => "Error al intentar dar mod",
      'reason' => "El usuario no existe"
    ];
  }
} else {
  // El id del usuario a reportar no es numerico
  $message = [
    'message' => "Error al intentar quitar mod",
    'reason' => "El id del usuario a reportar debe ser numerico"
  ];
}

header("Content-Type: application/json; charset=utf-8");
return print_r(json_encode($message));
