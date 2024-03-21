<?php



require_once "../../../includes/config.php";
require_once "../../../includes/functions.php";

header("Content-Type: application/json; charset=utf-8");

if (isset($_SESSION['user'])) {

  $imgs_recipe = (recipe_pics($_POST['id'])) ? recipe_pics($_POST['id']) : [];
  $imgs_to_remove = (isset($_POST['imgs_to_remove'])) ? $_POST['imgs_to_remove'] : [];

  // Calculo si no excede el limite de fotos por receta
  if (count($imgs_recipe) - count($imgs_to_remove) + count($_FILES) > 4) {
    return print_r(json_encode(['message' => 'Error al intentar publicar.', 'message_img' => 'Se excede del limite maximo de imagenes por receta (4)', 'status' => http_response_code(500)]));
  }

  if (!empty($_FILES)) {
    // Funcion para crear un nombre ramdom para las imagenes
    function str_random($path_info)
    {
      $string = 'AaBbCcDd';
      return str_shuffle($string) . "_" . gettimeofday()['sec'] . "-" . gettimeofday()['usec'] . '.' . $path_info['extension'];
    }

    if (!is_dir('../../../images/recipes/' . $_POST['id'])) mkdir('../../../images/recipes/' . $_POST['id']);

    foreach ($_FILES as $key => $file) {
      if (!strpos($file['type'], "jpeg") && !strpos($file['type'], "png") && !strpos($file['type'], "gif") && !strpos($file['type'], "webp")) {
        // La extension no esta permitida
        return print_r(json_encode(['message' => 'Error al intentar publicar.', 'message_img' => 'La imagen "' . $file['name'] . '" tiene una extension no permitida. Las permitidas son: jpeg, png, gif y webp', 'status' => http_response_code(500)]));
      }
      if ($file['size'] > 3000000 /*3MB*/) {
        // Excede el tamaño limite
        return print_r(json_encode(['message' => 'Error al intentar publicar.', 'message_img' => 'La imagen "' . $file['name'] . '" excede el tamaño limite (3MB)', 'status' => http_response_code(500)]));
      }

      // Subir las fotos
      $path_info = pathinfo('../../../images/recipes/' . $_POST['id'] . '/' . $file['name']);
      $photo_name = str_random($path_info);

      // Muevo los archivos subidos por el usuario a la ruta deseada, si no es posible, arrojo mensaje ded error
      if (!move_uploaded_file($file['tmp_name'], '../../../images/recipes/' . $_POST['id']  . '/' . $photo_name)) {
        return print_r(json_encode([
          'message' => 'Error al intentar publicar.', 'message_img' => 'No fue posible subir las imagenes', 'status' => http_response_code(500)
        ]));
      }
    }
  }

  // Elimino las fotos deseadas por el suer
  if (is_dir('../../../images/recipes/' . $_POST['id'])) {
    if (!empty($imgs_to_remove)) {
      foreach ($imgs_to_remove as $img_to_remove) {
        if (is_file("../../../images/recipes/" . $_POST['id'] . "/" . $img_to_remove)) {
          unlink("../../../images/recipes/" . $_POST['id'] . "/" . $img_to_remove);
        }
      }
    }
  }


  // actualizo la receta con nuevos datos obtenidos por post
  if (!empty($_POST)) {
    $title = trim($_POST['title']);
    $intro = trim($_POST['introduction']);
    $ingredients = trim($_POST['ingredients']);
    $steps = trim($_POST['steps']);
    $new_categories = json_decode($_POST['categories']);

    if (($title != null && strlen($title) < 76) && (strlen($intro) < 251) && ($ingredients != null && strlen($ingredients) < 501) && ($steps != null && strlen($steps) < 2001) && count($new_categories) < 15) {

      $sql_Edited_Recipe = "UPDATE recipes SET title = '" . $title . "' , introduction = '" . $intro . "' , 
                                    ingredients = '" . $ingredients . "', steps = '" . $steps . "' 
                                WHERE id = '" . $_POST['id'] . "' AND user_id = '" . $_SESSION['user']['id'] . "'; 
                                DELETE FROM categories_recipes WHERE recipe_id = " . $_POST['id'] . "; ";
      if (count($new_categories) > 0) {
        $sql_Edited_Recipe .= "INSERT INTO categories_recipes (recipe_id, category_id) VALUES ";
        foreach ($new_categories as $key => $new_category) {
          $sql_Edited_Recipe .= "(" . $_POST['id'] . ", " . $new_category->id . ")";
          $sql_Edited_Recipe .= ($key < count($new_categories) - 1) ? ", " : null;
        }
      }
      $result_Edited_Recipe = mysqli_multi_query($conn, $sql_Edited_Recipe);
      if (!$result_Edited_Recipe) {
        die('Error de Consulta ' . mysqli_error($conn));
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
  }


  return print_r(json_encode([
    'message' => 'Se actualizó correctamente la receta',
    'status' => http_response_code(200),
  ]));
}
