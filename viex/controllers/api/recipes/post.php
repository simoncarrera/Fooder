<?php


require_once "../../../includes/config.php";

header("Content-Type: application/json; charset=utf-8");

if (!empty($_FILES)) {
  $count = 0;
  foreach ($_FILES as $key => $file) {
    if (!strpos($file['type'], "jpeg") && !strpos($file['type'], "png") && !strpos($file['type'], "gif") && !strpos($file['type'], "webp")) {
      // La extension no esta permitida
      return print_r(json_encode(['message' => 'Error al intentar publicar.', 'message_img' => 'La imagen "' . $file['name'] . '" tiene una extension no permitida. Las permitidas son: jpeg, png, gif y webp', 'status' => http_response_code(500)]));
    }
    if ($file['size'] > 3000000) {
      // Excede el tamaño limite
      return print_r(json_encode(['message' => 'Error al intentar publicar.', 'message_img' => 'La imagen "' . $file['name'] . '" excede el tamaño limite (3MB)', 'status' => http_response_code(500)]));
    }
    $count++;
  }
  if ($count > 4) {
    return print_r(json_encode(['message' => 'Error al intentar publicar.', 'message_img' => 'Se excede del limite maximo de imagenes por receta (4)', 'status' => http_response_code(500)]));
  }
}

$title = trim($_POST['title']);
$intro = trim($_POST['introduction']);
$ingredients = trim($_POST['ingredients']);
$steps = trim($_POST['steps']);
$categories = json_decode($_POST['categories']);

if (($title != null && strlen($title) < 76) && (strlen($intro) < 251) && ($ingredients != null && strlen($ingredients) < 501) && ($steps != null && strlen($steps) < 2001) && count($categories) < 15) {
  $sqlPostRecipe = "INSERT INTO recipes (user_id, title, introduction, ingredients, steps, created_at) VALUES ('" . $_SESSION['user']['id'] . "', '" . trim($_POST['title']) . "', '" . trim($_POST['introduction']) . "', '" . trim($_POST['ingredients']) . "' , '" . trim($_POST['steps']) . "', now()); ";
  $resultPostRecipe = mysqli_query($conn, $sqlPostRecipe);
  // Hacerlo en mysqli_multi_query
  $sqlId = "SELECT LAST_INSERT_ID() AS recipe_id;";
  $resultId = mysqli_query($conn, $sqlId);
  $rowId = mysqli_fetch_assoc($resultId);
  if (!$resultPostRecipe) {
    die('Error de Consulta ' . mysqli_error($conn));
  }

  if (count($categories) > 0) {
    $sqlCategories = "INSERT INTO categories_recipes (recipe_id, category_id) VALUES ";
    foreach ($categories as $key => $category) {
      $sqlCategories .= "(" . $rowId['recipe_id'] . ", " . $category->id . ")";
      $sqlCategories .= ($key < count($categories) - 1) ? ", " : null;
    }
    $resultCategories = mysqli_query($conn, $sqlCategories);
    if (!$resultCategories) {
      die('Error de Consulta ' . mysqli_error($conn));
    }
  }
} else {
  // Campos vacios
  if (!$title) return print_r(json_encode(['message' => 'Error al intentar publicar', 'message_title' => "Ingrese un titulo", 'status' => http_response_code(500)]));
  if (!$ingredients) return print_r(json_encode(['message' => 'Error al intentar publicar', 'message_ingredients' => "Ingrese los ingredientes", 'status' => http_response_code(500)]));
  if (!$steps) return print_r(json_encode(['message' => 'Error al intentar publicar', 'message_steps' => "Ingrese los pasos a seguir", 'status' => http_response_code(500)]));

  // Maximo de caracteres
  if (strlen($title) > 30) return print_r(json_encode(['message' => 'Error al intentar publicar', 'message_title' => "El titulo debe ser más pequeño", 'status' => http_response_code(500)]));
  if (strlen($intro) > 40) return print_r(json_encode(['message' => 'Error al intentar publicar', 'message_intro' => "La introducción debe ser menor", 'status' => http_response_code(500)]));
  if (strlen($ingredients) > 300) return print_r(json_encode(['message' => 'Error al intentar publicar', 'message_ingredients' => "Demasiado largo", 'status' => http_response_code(500)]));
  if (strlen($steps) > 300) return print_r(json_encode(['message' => 'Error al intentar publicar', 'message_steps' => "Ingrese pasos más cortos", 'status' => http_response_code(500)]));
  if (count($categories) > 15) return print_r(json_encode(['message' => 'Error al intentar publicar', 'message_categories' => "Solo se pueden ingresar hasta 15 categorias", 'status' => http_response_code(500)]));
}


if (!empty($_FILES)) {
  // Subir las fotos

  // Funcion para crear un nombre ramdom para las imagenes
  function str_random($path_info)
  {
    $string = 'AaBbCcDd';
    return str_shuffle($string) . "_" . gettimeofday()['sec'] . "-" . gettimeofday()['usec'] . '.' . $path_info['extension'];
    //return str_shuffle($string) . '.' . $path_info['extension'];
  }

  if (!is_dir('../../../images/recipes/' . $rowId['recipe_id'])) mkdir('../../../images/recipes/' . $rowId['recipe_id']);

  foreach ($_FILES as $key => $file) {
    $path_info = pathinfo('../../../images/recipes/' . $rowId['recipe_id'] . '/' . $file['name']);
    $photo_name = str_random($path_info);

    // Muevo los archivos subidos por el usuario a la ruta deseada, si no es posible, arrojo mensaje ded error
    if (!move_uploaded_file($file['tmp_name'], '../../../images/recipes/' . $rowId['recipe_id'] . '/' . $photo_name)) {
      $sqlDeleteRecipe = "DELETE FROM recipes WHERE id=" . $rowId['recipe_id'];
      $resultDeleteRecipe = mysqli_query($conn, $sqlDeleteRecipe);
      if (!$resultDeleteRecipe) {
        die('Error de Consulta ' . mysqli_error($conn));
      }
      return print_r(json_encode([
        'message' => 'Error al intentar publicar.', 'message_img' => 'No fue posible subir las imagenes', 'status' => http_response_code(500)
      ]));
    }
  }
}

return print_r(json_encode(
  [
    'message' => 'Se publico correctamente la receta',
    'status' => http_response_code(200),
  ]
));
