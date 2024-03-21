<?php

require_once "../../../includes/config.php";

if(isset($_SESSION['user']) && $_SESSION['user']['role_id'] != 1 && !empty($_POST)){
    $sqlFeaturedCategories = "SELECT id, name FROM categories WHERE featured IS NOT NULL AND id != " . $_POST['category_id'];
    $resFeaturedCategories = mysqli_query($conn, $sqlFeaturedCategories);
    if (!$resFeaturedCategories) {
        die("Error en la consulta: " . mysqli_error($conn));
    }

    $message = ['message' => 'Error al intentar agregar la categoria en favoritas'];

    if(mysqli_num_rows($resFeaturedCategories) < 5){
        $sqlIsFeatured = "SELECT * FROM categories WHERE featured IS NULL AND id = " . $_POST['category_id'];
        $resIsFeatured = mysqli_query($conn, $sqlIsFeatured);
        if (!$resIsFeatured) {
            die("Error en la consulta: " . mysqli_error($conn));
        }

        if(mysqli_num_rows($resIsFeatured) == 1){
            // No esta en favoritos
            $sqlHighlightCategory = "UPDATE categories SET featured = 'YES' WHERE id = " . $_POST['category_id'];
            $resHighlightCategory = mysqli_query($conn, $sqlHighlightCategory);
            if (!$resHighlightCategory) {
                die("Error en la consulta: " . mysqli_error($conn));
            }

            $message = [
                'estado' => 'Hecho',
                'message' => 'Se agrego la categoria a las favoritas',
                'action' => 'fav'
            ];

        } else {
            // Esta en favoritos
            $sqlNotHighlightCategory = "UPDATE categories SET featured = NULL WHERE id = " . $_POST['category_id'];
            $resNotHighlightCategory = mysqli_query($conn, $sqlNotHighlightCategory);
            if (!$resNotHighlightCategory) {
                die("Error en la consulta: " . mysqli_error($conn));
            }

            $message = [
                'estado' => 'Hecho',
                'message' => 'Se quito la categoria de las favoritas',
                'action' => 'unfav'
            ];
        }
    } else {
        // Excede del limite maximo de categorias favoritas posibles
        $message = ['reason' => 'No pueden haber más de 5 categorias favoritas'];
    }

    header("Content-Type: application/json; charset=utf-8");
    return print_r(json_encode($message));
}