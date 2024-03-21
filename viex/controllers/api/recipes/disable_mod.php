<?php

require_once "../../../includes/config.php";
require_once "../../../includes/functions.php";


if ($_SESSION['user']['role_id'] != 1) {
    if (!empty($_POST)) {
        $recipe_id = $_POST['recipe_to_delete_id'];

        if (is_numeric($recipe_id)) {

            $sqlIfDeleted = "SELECT * FROM recipes WHERE id= '" . $recipe_id . "' AND deleted_at IS NULL";
            $resIfDeleted = mysqli_query($conn, $sqlIfDeleted);
            if (!$resIfDeleted) {
                die('Error de Consulta ' . mysqli_error($conn));
            }

            if (mysqli_num_rows($resIfDeleted) == 1) {
                $reportid = $_POST['report_id'];
                if (is_numeric($recipe_id)) {

                    $user_email = "SELECT users.email, reports.reason, reports.justification FROM reports 
                        INNER JOIN recipes on reports.reported_recipe_id = recipes.id 
                        INNER JOIN users on users.id = recipes.user_id 
                    WHERE reports.reported_recipe_id =".$recipe_id;

                    $resUser_email = mysqli_query($conn,$user_email);

                    if (!$resUser_email) {
                        die('Error de Consulta ' . mysqli_error($conn));
                    }
                    
                    if($data = mysqli_fetch_assoc($resUser_email)) {
                        $encabezado = "Te han eliminado una receta de fooder";
                        $cuerpo ="Te han eliminado una receta de fuder, luego de ser denunciado por ".$data['reason']." con la siguiente justificacion : ".$data['justification'];
    
                        $correo = mail($data['email'],$encabezado,$cuerpo);
                        if(!$correo){
                            echo $correo."<br>" .$encabezado . "<br>" . $cuerpo;
                            die('error de consulta mail'. mysqli_error($conn));
                        }
                    }




                    $sqlDeleteRecipe = "UPDATE reports 
                                        SET verdict = '" . $_POST['verdict'] . "' , admin_id = " . $_SESSION['user']['id'] . ", resolved_at = now() 
                                    WHERE id = " . $reportid . "; 
                                    UPDATE reports
                                        SET verdict = 'Reporte resuelto en reporte con id " . $reportid . "', admin_id = " . $_SESSION['user']['id'] . ", resolved_at = now() 
                                    WHERE reported_recipe_id = " . $recipe_id . " AND id != " . $reportid . ";  
                                    UPDATE recipes SET deleted_at = now() WHERE id = " . $recipe_id;
                    $resDeleteRecipe = mysqli_multi_query($conn, $sqlDeleteRecipe);
                    if (!$resDeleteRecipe) {
                        die('Error de Consulta ' . mysqli_error($conn));
                    }
                
                    
                    $message = [
                        'message' => "Hecho",
                        'action' => "Ban",
                        'to_mail' => $data['email']
                    ];


                } else {
                    $message = [
                        'message' => "Error",
                        'reason' => "El id del report tiene que ser un valor numerico",
                    ];
                }
            } else {
                $message = [
                    'message' => "Error",
                    'reason' => "La receta ya se encuentra eliminada"
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
