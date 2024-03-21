<?php


require_once "../../../includes/config.php";

$recipe_id = $_POST['id'];
// Valido si estan enviando un valor numerico

if (is_numeric($recipe_id)) {
  $sqlVerifyLike = "SELECT * FROM recipes_likes WHERE recipe_id= '" . $recipe_id . "' AND user_id = " . $_SESSION['user']['id'] . " ";
  $resVerifyLike = mysqli_query($conn, $sqlVerifyLike);
  if (!$resVerifyLike) {
    die('Error de Consulta ' . mysqli_error($conn));
  }
  if (mysqli_num_rows($resVerifyLike) == 0) {
    // Agrego el like a la base de datos
    $sqlLike = "INSERT INTO recipes_likes (user_id, recipe_id, created_at) VALUES ('" . $_SESSION['user']['id'] . "' , '" . $recipe_id . "', now())";
    $resLike = mysqli_query($conn, $sqlLike);
    if (!$resLike) {
      die('Error de Consulta ' . mysqli_error($conn));
    }
    $devolver = array('like' => 'sumar');
  } else {
    // Saco el like a la base de datos
    $sqlDislike = "DELETE FROM recipes_likes WHERE recipe_id= '" . $recipe_id . "' AND user_id= '" . $_SESSION['user']['id'] . "' ";
    $resDislike = mysqli_query($conn, $sqlDislike);
    if (!$resDislike) {
      die('Error de Consulta ' . mysqli_error($conn));
    }
    $devolver = array('like' => 'restar');
  }
}

header("Content-Type: application/json; charset=utf-8");
echo json_encode($devolver);
