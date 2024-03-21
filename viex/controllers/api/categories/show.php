<?php



require_once "../../../includes/config.php";
require_once "../../../includes/functions.php";

$page = (isset($_POST['page'])) ? $_POST['page'] : 1;

if ($_POST['for'] == 'categories_mod') {
  if (isset($_SESSION['user']) && $_SESSION['user']['role_id'] != 1) {
    //Para categorias
    $sqlCategories = "SELECT * FROM categories ORDER BY name ASC";
  }
} else if ($_POST['for'] == 'post_recipe') {
  if (isset($_SESSION['user'])) {
    //Para categorias
    $sqlCategories = "SELECT * FROM categories ORDER BY name ASC";
  }
} else if ($_POST['for'] == 'edit_recipe') {
  if (isset($_SESSION['user'])) {
    //Para categorias
    $sqlCategories = "SELECT categories.* FROM categories 
                      INNER JOIN categories_recipes ON categories.id = categories_recipes.category_id
                      INNER JOIN recipes ON categories_recipes.recipe_id = recipes.id
                      WHERE recipes.id = " . $_POST['recipe_id'];
    $resultCategories = mysqli_query($conn, $sqlCategories);
    if (!$resultCategories) {
      die('Error de Consulta' . mysqli_error($conn));
    }
    $rowRecipeCategories = mysqli_fetch_all($resultCategories, MYSQLI_ASSOC);

    $sqlCategories = "SELECT * FROM categories ORDER BY name ASC";
  }
}


$resultCategories = mysqli_query($conn, $sqlCategories);
if (!$resultCategories) {
  die('Error de Consulta' . mysqli_error($conn));
}

if ($_POST['for'] == 'categories_mod') {
  $amt_categories_page = ceil(mysqli_num_rows($resultCategories) / CANT_REG_PAG);

  $sqlCategories .= " LIMIT " . CANT_REG_PAG * ($page - 1) . ", " . CANT_REG_PAG;
  $resultCategories = mysqli_query($conn, $sqlCategories);
  if (!$resultCategories) {
    die('Error de Consulta' . mysqli_error($conn));
  }

  $rowCategories = mysqli_fetch_all($resultCategories, MYSQLI_ASSOC);

  foreach ($rowCategories as $key => $value) {
    $rowCategories[$key]['category_img'] = category_pics($value['id']);

    $rowCategories[$key]['name'] = htmlspecialchars($rowCategories[$key]['name']);
  }

  $message = [
    'message' => "Hecho",
    'user_logged_id' => (isset($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : null,
    'categories' => $rowCategories,
    'amt_categories_page' => $amt_categories_page
  ];
} else if ($_POST['for'] == 'post_recipe') {
  $rowCategories = mysqli_fetch_all($resultCategories, MYSQLI_ASSOC);

  $message = [
    'message' => "Hecho",
    'categories' => $rowCategories
  ];
} else {
  $rowCategories = mysqli_fetch_all($resultCategories, MYSQLI_ASSOC);

  $message = [
    'message' => "Hecho",
    'categories' => $rowCategories,
    'recipe_categories' => $rowRecipeCategories
  ];
}


header("Content-Type: application/json; charset=utf-8");
return print_r(json_encode($message));
