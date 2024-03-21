<?php


require_once "../../../includes/config.php";

header("Content-Type: application/json; charset=utf-8");
// Valido si estan enviando un valor numerico
if (is_numeric($_POST['id'])) {
    $sqlCategory = "SELECT * FROM categories WHERE id= " . $_POST['id'];
    $resCategory = mysqli_query($conn, $sqlCategory);
    if (!$resCategory) {
        die('Error de Consulta ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($resCategory) == 1) {
        if (is_dir($dir = "../../../" . RUTA_IMG_CATEGORIES . "/" . $_POST['id'])) {
            // Borrar foto de categoria en archivos
            $files = scandir($dir, 1);
            for ($i = 0; $i < count($files) - 2; $i++) {
                if (file_exists($dir . "/" . $files[$i])) {
                    unlink($dir . "/" . $files[$i]);
                }
            }
            // Eliminar directorio (necesita antes estar vacio para poder eliminarlo, por eso lo anterior)
            rmdir($dir);
        }

        $sqlDisableCategory = "DELETE FROM categories WHERE id= " . $_POST['id'];
        $resDisableCategory = mysqli_query($conn, $sqlDisableCategory);
        if (!$resDisableCategory) {
            die('Error de Consulta ' . mysqli_error($conn));
        }
        echo json_encode(array('message' => 'Hecho', 'action' => 'borrar'));
    } else {
        // No existe la categoria
        echo json_encode(array('message' => 'Error', 'reason' => 'Error al intentar eliminar la categoria. La categoria no existe'));
    }
} else {
    echo json_encode(array('message' => 'Error', 'reason' => 'Error al intentar eliminar la categoria. El id no es numerico'));
}
