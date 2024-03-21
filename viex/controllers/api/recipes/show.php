<?php



require_once "../../../includes/config.php";
require_once "../../../includes/functions.php";

$page = (isset($_POST['page'])) ? $_POST['page'] : 1;

if ($_POST['for'] == 'home') {
  if (isset($_SESSION['user'])) {
    //Devuelve las recetas, los datos necesarios del user, la cant. de comentarios y la cant. de likes. También devuelve si el usuario logueado le dio like a la receta
    $sqlRecipe = "SELECT recipes.*, users.username,  tbl_cant_comments.cant_comments, COUNT(recipes_likes.recipe_id) AS cant_likes, tbl_verify_like.verify_like 
                    FROM recipes 
                    INNER JOIN users ON recipes.user_id = users.id 
                    LEFT JOIN recipes_likes ON recipes.id = recipes_likes.recipe_id 
                    LEFT JOIN 
                        (SELECT recipes.id AS recipe_id, COUNT(comments.recipe_id) AS cant_comments 
                            FROM recipes 
                            LEFT JOIN comments ON comments.recipe_id=recipes.id 
                            WHERE comments.deleted_at IS NULL
                            GROUP BY comments.recipe_id) AS tbl_cant_comments 
                        ON recipes.id = tbl_cant_comments.recipe_id
                    LEFT JOIN (SELECT recipe_id, COUNT(id) as verify_like 
                            FROM recipes_likes
                            WHERE user_id = '" . $_SESSION['user']['id'] . "'
                            GROUP BY recipe_id) AS tbl_verify_like
                        ON recipes.id = tbl_verify_like.recipe_id
                    WHERE recipes.deleted_at IS NULL
                    GROUP BY recipes.id
                    ORDER BY recipes.id DESC";
  } else {
    //Devuelve las recetas, los datos necesarios del user, la cant. de comentarios y la cant. de likes. NO hay usuario logueado
    $sqlRecipe = "SELECT recipes.*, users.username,  tbl_cant_comments.cant_comments, COUNT(recipes_likes.recipe_id) AS cant_likes
                    FROM recipes 
                    INNER JOIN users ON recipes.user_id = users.id 
                    LEFT JOIN recipes_likes ON recipes.id = recipes_likes.recipe_id 
                    LEFT JOIN 
                        (SELECT recipes.id AS recipe_id, COUNT(comments.recipe_id) AS cant_comments 
                            FROM recipes 
                            LEFT JOIN comments ON comments.recipe_id=recipes.id 
                            GROUP BY comments.recipe_id) AS tbl_cant_comments 
                        ON recipes.id = tbl_cant_comments.recipe_id
                    WHERE recipes.deleted_at IS NULL
                    GROUP BY recipes.id
                    ORDER BY recipes.id DESC";
  }
} else if ($_POST['for'] == 'recipes_followed') {
  // Recetas y datos de los creadores al cual sigue el usuario logueado
  $sqlRecipe = "SELECT recipes.*, users.username,  tbl_cant_comments.cant_comments, COUNT(recipes_likes.recipe_id) AS cant_likes, tbl_verify_like.verify_like
                FROM recipes 
                INNER JOIN follows ON recipes.user_id = follows.followed_id 
                INNER JOIN users ON recipes.user_id = users.id 
                LEFT JOIN recipes_likes ON recipes.id = recipes_likes.recipe_id 
                LEFT JOIN 
                    (SELECT recipes.id AS recipe_id, COUNT(comments.recipe_id) AS cant_comments 
                        FROM recipes 
                        LEFT JOIN comments ON comments.recipe_id=recipes.id 
                        WHERE comments.deleted_at IS NULL
                        GROUP BY comments.recipe_id) AS tbl_cant_comments 
                    ON recipes.id = tbl_cant_comments.recipe_id
                LEFT JOIN (SELECT recipe_id, COUNT(id) as verify_like 
                        FROM recipes_likes
                        WHERE user_id = '" . $_SESSION['user']['id'] . "'
                        GROUP BY recipe_id) AS tbl_verify_like
                    ON recipes.id = tbl_verify_like.recipe_id
                WHERE follows.follower_id = '" . $_SESSION['user']['id'] . "' AND recipes.deleted_at IS NULL
                GROUP BY recipes.id
                ORDER BY recipes.id DESC";
} else if ($_POST['for'] == 'searches') {
  $search = trim($_POST['search']);
  if (isset($_SESSION['user'])) {
    // Devuelve datos de las recetas segun la variable $search, la cant. de likes, la cant. de comentarios. También verifica si el usuario logueado le dio like al posteo 
    $sqlRecipe = "SELECT recipes.*, users.username,  tbl_cant_comments.cant_comments, COUNT(recipes_likes.recipe_id) AS cant_likes, tbl_verify_like.verify_like 
                FROM recipes 
                INNER JOIN users ON recipes.user_id = users.id 
                LEFT JOIN recipes_likes ON recipes.id = recipes_likes.recipe_id 
                LEFT JOIN 
                    (SELECT recipes.id AS recipe_id, COUNT(comments.recipe_id) AS cant_comments 
                        FROM recipes 
                        LEFT JOIN comments ON comments.recipe_id=recipes.id 
                        WHERE comments.deleted_at IS NULL
                        GROUP BY comments.recipe_id) AS tbl_cant_comments 
                    ON recipes.id = tbl_cant_comments.recipe_id
                LEFT JOIN (SELECT recipe_id, COUNT(id) as verify_like 
                        FROM recipes_likes
                        WHERE user_id = '" . $_SESSION['user']['id'] . "'
                        GROUP BY recipe_id) AS tbl_verify_like
                    ON recipes.id = tbl_verify_like.recipe_id ";

    if ($_POST['filter_for'] == 'titles') {
      $sqlRecipe .= "WHERE recipes.title LIKE '%$search%' AND recipes.deleted_at IS NULL ";
    } else if ($_POST['filter_for'] == 'ingredients') {
      $sqlRecipe .= "WHERE recipes.ingredients LIKE '%$search%' AND recipes.deleted_at IS NULL ";
    } else {
      $sqlRecipe .= "INNER JOIN categories_recipes ON recipes.id = categories_recipes.recipe_id
                    INNER JOIN categories ON categories_recipes.category_id = categories.id
                    WHERE categories.name LIKE '%$search%' AND recipes.deleted_at IS NULL ";
    }

    $sqlRecipe .= "GROUP BY recipes.id
                  ORDER BY recipes.id DESC";
  } else {
    // Devuelve datos de las recetas segun la variable $search, la cant. de likes, la cant. de comentarios. NO hay usuario logueado
    $sqlRecipe = "SELECT recipes.*, users.username,  tbl_cant_comments.cant_comments, COUNT(recipes_likes.recipe_id) AS cant_likes
                FROM recipes 
                INNER JOIN users ON recipes.user_id = users.id 
                LEFT JOIN recipes_likes ON recipes.id = recipes_likes.recipe_id 
                LEFT JOIN 
                    (SELECT recipes.id AS recipe_id, COUNT(comments.recipe_id) AS cant_comments 
                        FROM recipes 
                        LEFT JOIN comments ON comments.recipe_id=recipes.id 
                        WHERE comments.deleted_at IS NULL
                        GROUP BY comments.recipe_id) AS tbl_cant_comments 
                    ON recipes.id = tbl_cant_comments.recipe_id
                WHERE recipes.title LIKE '%$search%' AND recipes.deleted_at IS NULL
                GROUP BY recipes.id
                ORDER BY recipes.id DESC";
  }
} else if ($_POST['for'] == 'profile') {
  if (isset($_SESSION['user'])) {
    // Para los datos de la receta del usuario, cant.likes y cant.comments. También verifica si el usuario logueado le dio like            
    $sqlRecipe = "SELECT recipes.*, users.username,  tbl_cant_comments.cant_comments, COUNT(recipes_likes.recipe_id) AS cant_likes, tbl_verify_like.verify_like 
                FROM recipes 
                INNER JOIN users ON recipes.user_id = users.id 
                LEFT JOIN recipes_likes ON recipes.id = recipes_likes.recipe_id 
                LEFT JOIN 
                    (SELECT recipes.id AS recipe_id, COUNT(comments.recipe_id) AS cant_comments 
                        FROM recipes 
                        LEFT JOIN comments ON comments.recipe_id=recipes.id 
                        WHERE comments.deleted_at IS NULL
                        GROUP BY comments.recipe_id) AS tbl_cant_comments 
                    ON recipes.id = tbl_cant_comments.recipe_id
                LEFT JOIN (SELECT recipe_id, COUNT(id) as verify_like 
                        FROM recipes_likes
                        WHERE user_id = '" . $_SESSION['user']['id'] . "'
                        GROUP BY recipe_id) AS tbl_verify_like
                    ON recipes.id = tbl_verify_like.recipe_id
                WHERE recipes.user_id = '" . $_POST['profile_id'] . "' AND recipes.deleted_at IS NULL
                GROUP BY recipes.id
                ORDER BY recipes.id DESC";
  } else {
    // Para los datos de la receta del usuario, cant.likes y cant.comments                
    $sqlRecipe = "SELECT recipes.*, tbl_cant_comments.cant_comments, COUNT(recipes_likes.recipe_id) AS cant_likes
                FROM recipes 
                INNER JOIN users ON recipes.user_id = users.id 
                LEFT JOIN recipes_likes ON recipes.id = recipes_likes.recipe_id 
                LEFT JOIN 
                    (SELECT recipes.id AS recipe_id, COUNT(comments.recipe_id) AS cant_comments 
                        FROM recipes 
                        LEFT JOIN comments ON comments.recipe_id=recipes.id 
                        WHERE comments.deleted_at IS NULL
                        GROUP BY comments.recipe_id) AS tbl_cant_comments 
                    ON recipes.id = tbl_cant_comments.recipe_id
                WHERE recipes.user_id = '" . $_POST['profile_id'] . "' AND recipes.deleted_at IS NULL
                GROUP BY recipes.id
                ORDER BY recipes.id DESC";
  }
} else if ($_POST['for'] == 'recipes_reported_mod') {
  if ($_SESSION['user']['role_id'] != 1) {
    //Para comentarios reportadas
    $sqlRecipe = "SELECT recipes.*, users.username FROM recipes
                        INNER JOIN users ON recipes.user_id = users.id
                        INNER JOIN reports ON recipes.id = reports.reported_recipe_id
                        WHERE recipes.deleted_at IS NULL AND reports.reported_recipe_id IS NOT NULL AND reports.resolved_at IS NULL
                        GROUP BY recipes.id
                        ORDER BY recipes.id DESC";
  }
}

$resultRecipe = mysqli_query($conn, $sqlRecipe);
if (!$resultRecipe) {
  die('Error de Consulta' . mysqli_error($conn));
}

$amt_total_reg = mysqli_num_rows($resultRecipe);
$amt_recipes_page = ceil(mysqli_num_rows($resultRecipe) / CANT_REG_PAG);

$sqlRecipe .= " LIMIT " . CANT_REG_PAG * ($page - 1) . ", " . CANT_REG_PAG;
$resultRecipe = mysqli_query($conn, $sqlRecipe);
if (!$resultRecipe) {
  die('Error de Consulta' . mysqli_error($conn));
}
$rowRecipe = mysqli_fetch_all($resultRecipe, MYSQLI_ASSOC);

if ($_POST['for'] != 'recipes_reported_mod') {
  foreach ($rowRecipe as $key => $value) {
    $rowRecipe[$key]['cant_comments'] =  (is_null($value['cant_comments'])) ? 0 : $value['cant_comments'];
    $rowRecipe[$key]['created_at'] = creation_date($value['created_at']);
    $rowRecipe[$key]['profile_pic'] = profile_image($value['user_id']);
    $rowRecipe[$key]['recipe_imgs'] = recipe_pics($value['id']);

    $rowRecipe[$key]['title'] = htmlspecialchars($rowRecipe[$key]['title']);
    $rowRecipe[$key]['introduction'] = htmlspecialchars($rowRecipe[$key]['introduction']);
    $rowRecipe[$key]['ingredients'] = htmlspecialchars($rowRecipe[$key]['ingredients']);
    $rowRecipe[$key]['steps'] = htmlspecialchars($rowRecipe[$key]['steps']);
  }
} else {
  foreach ($rowRecipe as $key => $value) {
    $rowRecipe[$key]['created_at'] = creation_date($value['created_at']);
    $rowRecipe[$key]['profile_pic'] = profile_image($value['user_id']);
    $rowRecipe[$key]['recipe_imgs'] = recipe_pics($value['id']);

    $rowRecipe[$key]['title'] = htmlspecialchars($rowRecipe[$key]['title']);
    $rowRecipe[$key]['introduction'] = htmlspecialchars($rowRecipe[$key]['introduction']);
    $rowRecipe[$key]['ingredients'] = htmlspecialchars($rowRecipe[$key]['ingredients']);
    $rowRecipe[$key]['steps'] = htmlspecialchars($rowRecipe[$key]['steps']);
  }
}


$message = [
  'message' => "Hecho",
  'user_logged_id' => (isset($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : null,
  'recipes' => $rowRecipe,
  'amt_recipes_page' => $amt_recipes_page,
  'amt_total_reg' => $amt_total_reg,

];

header("Content-Type: application/json; charset=utf-8");
return print_r(json_encode($message));
