<?php

require_once "../../../includes/config.php";
require_once "../../../includes/functions.php";


if ($_SESSION['user']['role_id'] != 1) {
    if (!empty($_POST)) {
        $user_id = $_POST['user_banned_id'];

        if (is_numeric($user_id)) {

            $sqlIfBanned = "SELECT * FROM bans WHERE user_id= '" . $user_id . "' AND (end_at > now() OR permaban IS NOT NULL)";
            $resIfBanned = mysqli_query($conn, $sqlIfBanned);
            if (!$resIfBanned) {
                die('Error de Consulta ' . mysqli_error($conn));
            }

            if (mysqli_num_rows($resIfBanned) == 0) {
                // banear
                $reportid = $_POST['report_id'];
                if (is_numeric($user_id)) {
                    if($_POST['ban_ended']){
                        $end = date("Y-m-d H:i:s", $_POST['ban_ended'] + time());
                    } else {
                        $permaban = $_POST['permaban'];
                    }

                    $sqlBanUser = "UPDATE reports 
                                        SET verdict = '" . $_POST['verdict'] . "' , admin_id = " . $_SESSION['user']['id'] . ", resolved_at = now() 
                                    WHERE id = " . $reportid ."; 
                                    UPDATE reports
                                        SET verdict = 'Reporte resuelto en reporte con id " . $reportid . "', admin_id = " . $_SESSION['user']['id'] . ", resolved_at = now() 
                                    WHERE reported_user_id = " . $user_id . " AND id != " . $reportid . ";  
                                    INSERT INTO bans (user_id, report_id, start_at, end_at, permaban) VALUES ($user_id, $reportid, now(), ". (isset($end) ? "'$end'" : 'NULL') .", '". (isset($permaban) ? $permaban : 'NULL') ."');";
                    $resBanUser = mysqli_multi_query($conn, $sqlBanUser);
                    $userEmail = "SELECT email FROM users WHERE id = ". $user_id ;
                    $resEmail = mysqli_query($conn, $userEmail);
                    mail($resEmail, "Baneado de Fooder.", "Hola, nos comunicamos desde Viex para informarte de tu suspensión. razón: " . $_POST['verdict'] . ".");
                    if (!$resBanUser) {
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
                //desbanear
                $sqlUnbanUser = "UPDATE bans SET end_at = now(), permaban = NULL";
                $resUnbanUser = mysqli_query($conn, $sqlUnbanUser);
                if (!$resUnbanUser) {
                    die('Error de Consulta ' . mysqli_error($conn));
                }
                $message = [
                    'message' => "Hecho",
                    'action' => "Unban"
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
