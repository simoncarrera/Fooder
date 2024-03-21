<?php

require_once "../../../includes/config.php";
//require_once "../../../includes/functions.php";

header("Content-Type: application/json; charset=utf-8");


if (isset($_SESSION['user']) && $_SESSION['user']['role_id'] != 1) {
    $message = ['message' => 'Error al intentar agregar la nueva categoria'];

    if (!empty($_POST['category']) && strlen($_POST['category']) < 50 && !empty($_FILES)) {

        $sqlCategories = "SELECT name FROM categories WHERE name = '" . trim($_POST['category']) . "'";
        $resultCategories = mysqli_query($conn, $sqlCategories);
        if (!$resultCategories) {
            die('Error de Consulta ' . mysqli_error($conn));
        }
        if(mysqli_num_rows($resultCategories) != 0){
            $message['status'] = http_response_code(500);
            $message['error_category'] = 'La categoria "' . trim($_POST['category']) . '" ya existe';
            return print_r(json_encode($message));
        }

        $file = $_FILES['img_category'];

        if (!strpos($file['type'], "jpeg") && !strpos($file['type'], "png") && !strpos($file['type'], "gif") && !strpos($file['type'], "webp")) {
            // La extension no esta permitida
            $message['status'] = http_response_code(500);
            $message['error_img_category'] = 'La imagen "' . $file['name'] . '" debe ser JPEG, PNG, GIF o WEBP';
            return print_r(json_encode($message));
        } else if ($file['size'] > 3000000) {
            // Excede el tamaño limite
            $message['status'] = http_response_code(500);
            $message['error_img_category'] = 'La imagen "' . $file['name'] . '" excede el tamaño limite (3MB)';
            return print_r(json_encode($message));
        }

        $sqlAddCategory = "INSERT INTO categories (name) VALUES ('" . trim($_POST['category']) . "')";
        $resultAddCategory = mysqli_query($conn, $sqlAddCategory);
        if ($resultAddCategory) {
            $sqlId = "SELECT LAST_INSERT_ID() AS category_id;";
            $resultId = mysqli_query($conn, $sqlId);
            $rowId = mysqli_fetch_assoc($resultId);

            if (!is_dir('../../../images/categories/' . $rowId['category_id'])) mkdir('../../../images/categories/' . $rowId['category_id']);
            // Muevo los archivos subidos por el usuario a la ruta deseada, si no es posible, arrojo mensaje ded error
            if (!move_uploaded_file($file['tmp_name'], '../../../images/categories/' . $rowId['category_id'] . '/' . $file['name'])) {
                $sqlDeleteCategory = "DELETE FROM categories WHERE id=" . $rowId['category_id'];
                $resultDeleteCategory = mysqli_query($conn, $sqlDeleteCategory);
                if (!$resultDeleteCategory) {
                    die('Error de Consulta ' . mysqli_error($conn));
                }
                $message['status'] = http_response_code(500);
                $message['error_img_category'] = 'No fue posible subir la imagen';
                return print_r(json_encode($message));
            }
            
            // Salio todo bien
            return print_r(json_encode($message = [
                'message' => "Hecho",
                'action' => "Se ha creado correctamente la categoria",
                'category_id' => $rowId['category_id'],
                'status' => http_response_code(200)
            ]));
        } else {
            die('Error de Consulta ' . mysqli_error($conn));
        }
    } else {
        $message['status'] = http_response_code(500);
        if (empty($_POST['category'])) $message['error_category'] = "Ingrese una categoria";
        if (strlen($_POST['category']) > 100) $message['error_category'] = "Nombre de categoria demasiado largo";
        if (empty($_FILES)) $message['error_img_category'] = "Ingrese una imagen a la categoria";

        return print_r(json_encode($message));
    }
} else {
    // No tiene permisos
    return print_r(json_encode($message = [
        'message' => 'Error',
        'reason' => "No tiene los permisos necesarios",
        'status' => http_response_code(500)
    ]));
} 

