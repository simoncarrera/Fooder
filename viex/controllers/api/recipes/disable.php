<?php



require_once "../../../includes/config.php";

$recipeId = $_POST['id'];
header("Content-Type: application/json; charset=utf-8");
// Valido si estan enviando un valor numerico
if (is_numeric($recipeId)) {
  $sqlRecipe = "SELECT * FROM recipes WHERE id= '$recipeId'";
  $resRecipe = mysqli_query($conn, $sqlRecipe);
  if (!$resRecipe) {
    die('Error de Consulta ' . mysqli_error($conn));
  }
  $rowRecipe = mysqli_fetch_assoc($resRecipe);

  if ($_SESSION['user']['id'] == $rowRecipe['user_id']) {
    $sqlDisableRecipe = "UPDATE recipes
                          LEFT JOIN comments
                            ON recipes.id = comments.recipe_id
                        SET recipes.deleted_at= now(), comments.deleted_at= now()
                        WHERE recipes.id = '$recipeId'";
    $resDisableRecipe = mysqli_query($conn, $sqlDisableRecipe);
    if (!$resDisableRecipe) {
      die('Error de Consulta ' . mysqli_error($conn));
    }

    if (strpos($_SERVER['HTTP_REFERER'], 'publication')) {
      echo json_encode(array('estado' => 'borrado', 'mensaje' => 'Receta borrada correctamente', 'aux' => 'publication'));
    } else {
      echo json_encode(array('estado' => 'borrado', 'mensaje' => 'Receta borrada correctamente'));
    }
  }
} else {
  echo json_encode(array('estado' => 'error', 'mensaje' => 'Error al intentar eliminar la receta, el id no es numerico'));
}
