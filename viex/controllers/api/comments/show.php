<?php



require_once "../../../includes/config.php";
require_once "../../../includes/functions.php";

$page = (isset($_POST['page'])) ? $_POST['page'] : 1;

if ($_POST['for'] == 'comments_publication') {
  if (isset($_SESSION['user'])) {
    // Para los datos de los comentarios y cant. de comentarios. Tambien verifica si le dio like al comentario
    $sqlDataComment = "SELECT comments.*, users.username,  COUNT(comments_likes.id) AS cant_likes, tbl_verify_like.verify_like
                        FROM comments 
                        INNER JOIN users ON comments.user_id = users.id
                        LEFT JOIN comments_likes ON comments.id = comments_likes.comment_id
                        LEFT JOIN (SELECT comment_id, COUNT(id) AS verify_like 
                                    FROM comments_likes
                                    WHERE user_id = '" . $_SESSION['user']['id'] . "'
                                    GROUP BY comment_id) AS tbl_verify_like
                                ON comments.id = tbl_verify_like.comment_id
                        WHERE comments.recipe_id= '" . $_POST['recipe_id'] . "' AND comments.deleted_at IS NULL
                        GROUP BY comments.id
                        ORDER BY id DESC";
  } else {
    // Para los datos de los comentarios y cant. de comentarios. NO verifica si le dio like al comentario porque no esta logueado
    $sqlDataComment = "SELECT comments.*, users.username,  COUNT(comments_likes.id) AS cant_likes
                        FROM comments 
                        INNER JOIN users ON comments.user_id = users.id
                        LEFT JOIN comments_likes ON comments.id = comments_likes.comment_id
                        WHERE comments.recipe_id= '" . $_POST['recipe_id'] . "' AND comments.deleted_at IS NULL
                        GROUP BY comments.id
                        ORDER BY id DESC";
  }
} else if ($_POST['for'] == 'comments_reported_mod') {
  if ($_SESSION['user']['role_id'] != 1) {
    //Para comentarios reportadas
    $sqlDataComment = "SELECT comments.*, users.username FROM comments
                        INNER JOIN users ON comments.user_id = users.id
                        INNER JOIN reports ON comments.id = reports.reported_comment_id
                        WHERE comments.deleted_at IS NULL AND reports.reported_comment_id IS NOT NULL AND reports.resolved_at IS NULL
                        GROUP BY comments.id
                        ORDER BY id DESC";
  }
}


$resultDataComment = mysqli_query($conn, $sqlDataComment);
if (!$resultDataComment) {
  exit("Error de consulta" . mysqli_error($conn));
}

$amt_comments_page = ceil(mysqli_num_rows($resultDataComment) / CANT_REG_PAG);

$sqlDataComment .= " LIMIT " . CANT_REG_PAG * ($page - 1) . ", " . CANT_REG_PAG;
$resultDataComment = mysqli_query($conn, $sqlDataComment);
if (!$resultDataComment) {
  die('Error de Consulta' . mysqli_error($conn));
}
$rowDataComment = mysqli_fetch_all($resultDataComment, MYSQLI_ASSOC);

foreach ($rowDataComment as $key => $value) {
  $rowDataComment[$key]['created_at'] = creation_date($value['created_at']);
  $rowDataComment[$key]['profile_pic'] = profile_image($value['user_id']);
  $rowDataComment[$key]['comment'] = htmlspecialchars($rowDataComment[$key]['comment']);
}

$message = [
  'message' => "Hecho",
  'user_logged_id' => (isset($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : null,
  'comments' => $rowDataComment,
  'amt_comments_page' => $amt_comments_page
];

header("Content-Type: application/json; charset=utf-8");
return print_r(json_encode($message));
