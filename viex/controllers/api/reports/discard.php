<?php

require_once "../../../includes/config.php";
require_once "../../../includes/functions.php";

if ($_SESSION['user']['role_id'] != 1) {
  $update = "UPDATE reports 
      SET verdict = '".$_POST['verdict']."' , admin_id = ".$_SESSION['user']['id'].", resolved_at = now() 
      WHERE id = ".$_POST['id'];
  
  $result_update = mysqli_query($conn, $update);
  if (!$result_update) {
    die('Error de Consulta' . mysqli_error($conn));
  }
  
  $select_user_email = "SELECT * FROM users INNER JOIN reports ON users.id = reports.id";
  $select_user_email_query = mysqli_query($conn,$select_user_email);

  if($select_user_email_query){
    mysqli_error($conn);
  }

  $user_emailed = mysqli_fetch_assoc($select_user_email_query);



}



$message = [
  'message' => "Hecho",
  'action' => "Descartar reporte"
];

header("Content-Type: application/json; charset=utf-8");
return print_r(json_encode($message));
