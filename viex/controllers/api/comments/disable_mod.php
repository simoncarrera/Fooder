<?php

require_once "../../../includes/config.php";
require_once "../../../includes/functions.php";


if ($_SESSION['user']['role_id'] != 1) {
    if (!empty($_POST)) {
        $comment_id = $_POST['comment_to_delete_id'];

        if (is_numeric($comment_id)) {

            $sqlIfDeleted = "SELECT * FROM comments WHERE id= '" . $comment_id . "' AND deleted_at IS NULL";
            $resIfDeleted = mysqli_query($conn, $sqlIfDeleted);
            if (!$resIfDeleted) {
                die('Error de Consulta ' . mysqli_error($conn));
            }

            if (mysqli_num_rows($resIfDeleted) == 1) {
                $reportid = $_POST['report_id'];
                if (is_numeric($comment_id)) {

                    $sqlDeleteRecipe = "UPDATE reports 
                                        SET verdict = '" . $_POST['verdict'] . "' , admin_id = " . $_SESSION['user']['id'] . ", resolved_at = now() 
                                    WHERE id = " . $reportid . "; 
                                    UPDATE reports
                                        SET verdict = 'Reporte resuelto en reporte con id " . $reportid . "', admin_id = " . $_SESSION['user']['id'] . ", resolved_at = now() 
                                    WHERE reported_comment_id = " . $comment_id . " AND id != " . $reportid . ";  
                                    UPDATE comments SET deleted_at = now() WHERE id = " . $comment_id;
                    $resDeleteRecipe = mysqli_multi_query($conn, $sqlDeleteRecipe);
                    if (!$resDeleteRecipe) {
                        die('Error de Consulta ' . mysqli_error($conn));
                    }
                    $message = [
                        'message' => "Hecho",
                        'action' => "Ban"
                    ];
                } else {
                    $message = [
                        'message' => "Error",
                        'reason' => "El id del report tiene que ser un valor numerico"
                    ];
                }
            } else {
                $message = [
                    'message' => "Error",
                    'reason' => "El comentario ya se encuentra eliminado"
                ];
            }
        } else {
            //no pasa valor numerico en el id del usuario
            $message = [
                'message' => "Error",
                'reason' => "El id del usuario tiene que ser un valor numerico"
            ];
        }
    }
} else {
    //no tiene rol permitido
    $message = [
        'message' => "Error",
        'reason' => "No tienes permisos"
    ];
}

header("Content-Type: application/json; charset=utf-8");
return print_r(json_encode($message));
