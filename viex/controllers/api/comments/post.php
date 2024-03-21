<?php


require_once "../../../includes/config.php";
require_once "../../../includes/functions.php";

if (isset($_SESSION['user'])) {
  $message = ['message' => 'Error al intentar publicar el comentario'];
  if (!empty($_POST['comment']) && strlen($_POST['comment']) < 1000) {
    $sqlPostComment = "INSERT INTO comments (user_id, recipe_id, comment, created_at) VALUES ('" . $_SESSION['user']['id'] . "', '" . $_POST['recipe_id'] . "' , '" . trim($_POST['comment']) . "', now());";
    $resultPostComment = mysqli_query($conn, $sqlPostComment);
    if ($resultPostComment) {
      $sqlId = "SELECT LAST_INSERT_ID() AS comment_id;";
      $resultId = mysqli_query($conn, $sqlId);
      $rowId = mysqli_fetch_assoc($resultId);

      $message = [
        'message' => 'Se ha publicado correctamente el comentario',
        'id' => $rowId['comment_id'],
        'user_logged_id' => $_SESSION['user']['id'],
        'profile_pic' => profile_image($_SESSION['user']['id']),
        'username' => $_SESSION['user']['username'],
        'created_at' => creation_date(date("Y-m-d H:i:s")),
        'comment' => trim($_POST['comment']),
        'status' => http_response_code(200)
      ];
    } else {
      die('Error de Consulta ' . mysqli_error($conn));
    }
  } else {
    // Quiere publicar un comentario vacio
    $message['status'] = http_response_code(500);
    if (empty($_POST['comment'])) $message['error_comment'] = "Ingrese un comentario";
    if (strlen($_POST['comment']) > 1000) $message['error_comment'] = "Comentario demasiado largo";
  }
} else {
  // No esta logueado
  $message = [
    'message' => 'Error',
    'reason' => "Usuario no logeado",
    'status' => http_response_code(500)
  ];
}

header("Content-Type: application/json; charset=utf-8");
return print_r(json_encode($message));
