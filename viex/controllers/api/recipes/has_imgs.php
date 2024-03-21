<?php



require_once "../../../includes/config.php";
require_once "../../../includes/functions.php";

if (is_dir("../../../images/recipes/" . $_GET['id'])) {
  $imgs = recipe_pics($_GET['id']);
  header("Content-Type: application/json; charset=utf-8");
  return print_r(json_encode($imgs));
}
