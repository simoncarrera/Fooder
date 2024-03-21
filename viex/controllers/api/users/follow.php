<?php



require_once "../../../includes/config.php";


$followedId = $_POST['id'];
// Valido si estan enviando un valor numerico
if (is_numeric($followedId)) {
  $sqlVerifyFollow = "SELECT * FROM follows WHERE followed_id= '" . $followedId . "' AND follower_id = " . $_SESSION['user']['id'] . " ";
  $resVerifyFollow = mysqli_query($conn, $sqlVerifyFollow);
  if (!$resVerifyFollow) {
    die('Error de Consulta ' . mysqli_error($conn));
  }

  if (mysqli_num_rows($resVerifyFollow) == 0) {
    $sqlFollow = "INSERT INTO follows (follower_id, followed_id, created_at) VALUES ('" . $_SESSION['user']['id'] . "' , '" . $followedId . "' , now());";
    $resFollow = mysqli_query($conn, $sqlFollow);
    if (!$resFollow) {
      die('Error de Consulta ' . mysqli_error($conn));
    }
    $devolver = array('follow' => 'agregar');
  } else {
    $sqlUnfollow = "DELETE FROM follows WHERE followed_id= '" . $followedId . "' AND follower_id= '" . $_SESSION['user']['id'] . "' ";
    $resUnfollow = mysqli_query($conn, $sqlUnfollow);
    if (!$resUnfollow) {
      die('Error de Consulta ' . mysqli_error($conn));
    }
    $devolver = array('follow' => 'sacar');
  }
}

header("Content-Type: application/json; charset=utf-8");
echo json_encode($devolver);
