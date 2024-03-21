<?php


require_once "../../includes/config.php";

if (isset($_GET['id']) || is_numeric($_GET['id'])) {
  $sqlExistUser = "SELECT * FROM users WHERE id= '" . $_GET['id'] . "' AND deleted_at IS NULL";
  $resExistUser = mysqli_query($conn, $sqlExistUser);
  $rowExistUser = mysqli_fetch_assoc($resExistUser);
  if ($rowExistUser) {
    if (isset($_SESSION['user'])) {
      // Para los datos del usuario, cant. de recetas, cant. de followers, cant. de followeds. También verifica si el usuario logueado lo sigue. RECORDATORIO QUE ME RECUERDA UNA COSA A RECORDAR
      $sqlCreator = "SELECT users.*, COUNT(recipes.id) AS cant_recipes, tbl_cant_followers.cant_followers, tbl_cant_followeds.cant_followeds, tbl_verify_follow.verify_follow 
                        FROM users 
                        LEFT JOIN recipes ON users.id = recipes.user_id 
                        LEFT JOIN 
                            (SELECT followed_id, COUNT(followed_id) AS cant_followers FROM follows 
                            INNER JOIN users
                            ON follows.follower_id = users.id
                            WHERE followed_id = '" . $_GET['id'] . "' AND users.deleted_at IS NULL) AS tbl_cant_followers
                            ON users.id = tbl_cant_followers.followed_id
                        LEFT JOIN 
                            (SELECT follower_id, COUNT(follower_id) AS cant_followeds FROM follows 
                            INNER JOIN users
                            ON follows.followed_id = users.id
                            WHERE follower_id = '" . $_GET['id'] . "' AND users.deleted_at IS NULL) AS tbl_cant_followeds
                            ON users.id = tbl_cant_followeds.follower_id
                        LEFT JOIN (SELECT followed_id, COUNT(id) as verify_follow 
                                FROM follows
                                WHERE follower_id = '" . $_SESSION['user']['id'] . "'
                                GROUP BY followed_id) AS tbl_verify_follow
                            ON users.id = tbl_verify_follow.followed_id
                        WHERE users.id = '" . $_GET['id'] . "' AND users.deleted_at IS NULL AND recipes.deleted_at IS NULL";
    } else {
      // Para los datos del usuario, cant. de recetas, cant. de followers, cant. de followeds. NO verifica si el user logueado lo sigue (no esta logueado)
      $sqlCreator = "SELECT users.*, COUNT(recipes.id) AS cant_recipes, tbl_cant_followers.cant_followers, tbl_cant_followeds.cant_followeds FROM users 
                        LEFT JOIN recipes ON users.id = recipes.user_id 
                        LEFT JOIN 
                            (SELECT followed_id, COUNT(followed_id) AS cant_followers FROM follows 
                            INNER JOIN users
                            ON follows.follower_id = users.id
                            WHERE followed_id = '" . $_GET['id'] . "' AND users.deleted_at IS NULL) AS tbl_cant_followers
                            ON users.id = tbl_cant_followers.followed_id
                        LEFT JOIN 
                            (SELECT follower_id, COUNT(follower_id) AS cant_followeds FROM follows 
                            INNER JOIN users
                            ON follows.followed_id = users.id
                            WHERE follower_id = '" . $_GET['id'] . "' AND users.deleted_at IS NULL) AS tbl_cant_followeds
                            ON users.id = tbl_cant_followeds.follower_id
                        WHERE users.id = '" . $_GET['id'] . "' AND users.deleted_at IS NULL";
    }
    $resultCreator = mysqli_query($conn, $sqlCreator);
    if (!$resultCreator) {
      echo "Error de consulta" . mysqli_error($conn);
      exit();
    }
    $rowCreator = mysqli_fetch_assoc($resultCreator);
    // Reemplazo por cero los valores que pueden ser null (de las cantidades)
    $rowCreator['cant_followeds'] = (is_null($rowCreator['cant_followeds'])) ? 0 : $rowCreator['cant_followeds'];
    $rowCreator['cant_followers'] = (is_null($rowCreator['cant_followers'])) ? 0 : $rowCreator['cant_followers'];
  } else {
    //No existe el user (o esta eliminado)
    header("Location: home.php");
  }
} else {
  // Lo que ingreso por el get no es un id
  header("Location: home.php");
}

$page = $rowCreator['username'];
$section = "profile";
require_once "../../views/layout.php";
