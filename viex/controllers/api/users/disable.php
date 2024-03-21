<?php



require_once "../../../includes/config.php";

if (isset($_SESSION['user'])) {

  // Solo en esta se hace un soft delete de los, follows y likes (buscar forma mas sencilla?)
  $sqlDisable = "UPDATE users
                        LEFT JOIN recipes
                            ON users.id = recipes.user_id
                        LEFT JOIN comments
                            ON users.id = comments.user_id
                        LEFT JOIN comments_likes
                            ON users.id = comments_likes.user_id
                        LEFT JOIN recipes_likes
                            ON users.id = recipes_likes.user_id
                    SET users.deleted_at= now(), recipes.deleted_at= now(), comments.deleted_at= now()
                    WHERE users.id = " . $_SESSION['user']['id'] . "; 
                    DELETE categories_recipes FROM categories_recipes 
                      INNER JOIN recipes ON categories_recipes.recipe_id = recipes.id 
                    WHERE recipes.user_id = " . $_SESSION['user']['id'];
  $resDisable = mysqli_multi_query($conn, $sqlDisable);
  if (!$resDisable) {
    die('Error de Consulta ' . mysqli_error($conn));
  }

  session_unset();
  session_destroy();
}

header('Location: ../../web/login.php');
