<?php



require_once "../../../includes/config.php";
require_once "../../../includes/functions.php";

$page = (isset($_POST['page'])) ? $_POST['page'] : 1;

if ($_SESSION['user']['role_id'] != 1) {
  if ($_POST['for'] == 'reports_accounts_mod') {
    //Para cuentas reportadas
    $sqlReports = "SELECT reports.id, reports.created_at, reports.reason, reports.justification, reports.reported_user_id, reports.reporter_user_id, tbl_user_reported.username AS username_reported, tbl_user_reporter.username AS username_reporter  
                        FROM reports 
                    INNER JOIN users AS tbl_user_reported 
                        ON reports.reported_user_id = tbl_user_reported.id
                    INNER JOIN users AS tbl_user_reporter 
                        ON reports.reporter_user_id = tbl_user_reporter.id
                    WHERE reports.resolved_at IS NULL AND reports.reported_user_id =" . $_POST['account_id'];
  } else if ($_POST['for'] == 'reports_recipes_mod') {
    //Para cuentas reportadas
    $sqlReports = "SELECT reports.id, reports.created_at, reports.reason, reports.justification, reports.reported_recipe_id, reports.reporter_user_id, tbl_user_reported.username AS username_reported, tbl_user_reporter.username AS username_reporter 
                      FROM reports 
                  INNER JOIN recipes 
                      ON reports.reported_recipe_id = recipes.id
                  INNER JOIN users AS tbl_user_reported 
                        ON recipes.user_id = tbl_user_reported.id
                    INNER JOIN users AS tbl_user_reporter 
                        ON reports.reporter_user_id = tbl_user_reporter.id
                  WHERE reports.resolved_at IS NULL AND reports.reported_recipe_id = " . $_POST['recipe_id'];
  } else if ($_POST['for'] == 'reports_comments_mod') {
    //Para cuentas reportadas
    $sqlReports = "SELECT reports.id, reports.created_at, reports.reason, reports.justification, reports.reported_comment_id, reports.reporter_user_id, tbl_user_reported.username AS username_reported, tbl_user_reporter.username AS username_reporter 
                      FROM reports 
                  INNER JOIN comments 
                      ON reports.reported_comment_id = comments.id
                  INNER JOIN users AS tbl_user_reported 
                        ON comments.user_id = tbl_user_reported.id
                    INNER JOIN users AS tbl_user_reporter 
                        ON reports.reporter_user_id = tbl_user_reporter.id
                  WHERE reports.resolved_at IS NULL AND reports.reported_comment_id = " . $_POST['comment_id'];
  }
}

$resultReports = mysqli_query($conn, $sqlReports);
if (!$resultReports) {
  die('Error de Consulta' . mysqli_error($conn));
}

/*$amt_reports_page = ceil(mysqli_num_rows($resultReports) / CANT_REG_PAG);

$sqlReports .= " LIMIT " . CANT_REG_PAG * ($page - 1) . ", " . CANT_REG_PAG;
$resultReports = mysqli_query($conn, $sqlReports);
if (!$resultReports) {
  die('Error de Consulta' . mysqli_error($conn));
}*/
$rowReports = mysqli_fetch_all($resultReports, MYSQLI_ASSOC);

foreach ($rowReports as $key => $value) {
  $rowReports[$key]['created_at'] = creation_date($value['created_at']);
  $rowReports[$key]['reason'] = reasonReport($value['reason']);

  $rowReports[$key]['reason'] = htmlspecialchars($rowReports[$key]['reason']);
  $rowReports[$key]['justification'] = htmlspecialchars($rowReports[$key]['justification']);
}


if ($_POST['for'] == 'reports_accounts_mod') {
  $message = [
    'message' => "Hecho",
    'reports' => $rowReports,
    'username_reported' => (!empty($rowReports)) ? $rowReports[0]['username_reported'] : null,
    'user_reported_id' => (!empty($rowReports)) ? $rowReports[0]['reported_user_id'] : null
  ];
} else if ($_POST['for'] == 'reports_recipes_mod') {
  $message = [
    'message' => "Hecho",
    'reports' => $rowReports,
    'username_reported' => (!empty($rowReports)) ? $rowReports[0]['username_reported'] : null,
    'recipe_reported_id' => (!empty($rowReports)) ? $rowReports[0]['reported_recipe_id'] : null
  ];
} else {
  $message = [
    'message' => "Hecho",
    'reports' => $rowReports,
    'username_reported' => (!empty($rowReports)) ? $rowReports[0]['username_reported'] : null,
    'comment_reported_id' => (!empty($rowReports)) ? $rowReports[0]['reported_comment_id'] : null
  ];
}

header("Content-Type: application/json; charset=utf-8");
return print_r(json_encode($message));
