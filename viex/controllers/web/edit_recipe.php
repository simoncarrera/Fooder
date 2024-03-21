<?php


require_once "../../includes/config.php";
require_once "../../includes/functions.php";

if (isset($_SESSION['user'])) {
  // consulta a la db sobre los datos de la receta
  $sql_Old_Recipe = "SELECT * FROM recipes WHERE id = '" . $_GET['id'] . "' AND user_id= '" . $_SESSION['user']['id'] . "'";
  $result_Old_Recipe = mysqli_query($conn, $sql_Old_Recipe);
  if (!$result_Old_Recipe) {
    die('Error de Consulta ' . mysqli_error($conn));
  }

  if (mysqli_num_rows($result_Old_Recipe) == 1) {
    $datos_Old = mysqli_fetch_assoc($result_Old_Recipe);
  } else {
    // No existe la receta o no es el creador de la misma
    header("Location: home.php");
  }
}

$page = "Editar receta";
$section = "edit_recipe";
require_once('../../views/layout.php');
