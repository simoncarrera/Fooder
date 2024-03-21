<?php


require_once("../../../includes/config.php");

if (isset($_SESSION['user'])) {
  if (isset($_POST['recipe_reported_id']) && is_numeric($_POST['recipe_reported_id'])) {
    if (isset($_POST['justification']) && $_POST['justification'] && isset($_POST['rep_why']) && $_POST['rep_why']) {
      $insert_report = "INSERT INTO reports(reported_recipe_id,reporter_user_id,reason,justification,created_at) 
                          VALUES(" . $_POST['recipe_reported_id'] . "," . $_SESSION['user']['id'] . ",'" . $_POST['rep_why'] . "','" . $_POST['justification'] . "', now())";
      $insert_report_query = mysqli_query($conn, $insert_report);
      if (!$insert_report_query) {
        die("error en consulta");
      }

      $message = [
        'message' => "Hecho",
        'action' => "Se reporto correctamente la receta con id " . $_POST['recipe_reported_id']
      ];
    } else {
      // Valores vacios para justification o reason
      if (!isset($_POST['justification']) || !$_POST['justification']) $message = [
        'message' => "Error",
        'reason' => "No supero la validacion",
        'justification_error' => "Ingrese una justificacion para su reporte"
      ];

      if (!isset($_POST['justification']) || !$_POST['rep_why']) $message = [
        'message' => "Error",
        'reason' => "No supero la validacion",
        'rep_why_error' => "Seleccione una razon para reportar"
      ];
    }
  } else {
    $message = [
      'message' => "Error",
      'reason' => "El id de la receta debe ser un valor numerico"
    ];
  }
} else {
  $message = [
    'message' => "Error",
    'reason' => "Debe estar iniciado sesión para poder reportar una receta"
  ];
}

header("Content-Type: application/json; charset=utf-8");
return print_r(json_encode($message));
