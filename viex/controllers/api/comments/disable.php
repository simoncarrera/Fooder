<?php


require_once "../../../includes/config.php";

$comment_id = $_POST['id'];
header("Content-Type: application/json; charset=utf-8");
// Valido si estan enviando un valor numerico
if (is_numeric($comment_id)) {
  $sqlComment = "SELECT * FROM comments WHERE id=" . $comment_id . " AND user_id=" . $_SESSION['user']['id'];
  $resComment = mysqli_query($conn, $sqlComment);
  if (!$resComment) {
    die('Error de Consulta ' . mysqli_error($conn));
  }
  $rowComment = mysqli_fetch_assoc($resComment);

  if ($_SESSION['user']['id'] == $rowComment['user_id']) {
    $sqlDisableComment = "UPDATE comments SET deleted_at= now() WHERE id=" . $comment_id . " AND user_id=" . $_SESSION['user']['id'];
    $resDisableComment = mysqli_query($conn, $sqlDisableComment);
    if (!$resDisableComment) {
      die('Error de Consulta ' . mysqli_error($conn));
    }
    echo json_encode(array('estado' => 'borrado', 'mensaje' => 'Comentario borrado correctamente'));
  }
} else {
  echo json_encode(array('estado' => 'error', 'mensaje' => 'Error al intentar eliminar el comentario, el id no es numerico'));
}
