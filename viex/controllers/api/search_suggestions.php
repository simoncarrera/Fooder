<?php

require_once "../../includes/config.php";
require_once "../../includes/functions.php";

if (isset($_POST['search'])) {
  $sqlRecipes = "SELECT title, id FROM recipes WHERE title LIKE '%" . trim($_POST['search']) . "%' AND deleted_at IS NULL LIMIT 0, 5";
  $sqlCategories = "SELECT name FROM categories WHERE name LIKE '%" . trim($_POST['search']) . "%' LIMIT 0, 5";
  $sqlAccounts = "SELECT username, id FROM users WHERE username LIKE '%" . trim($_POST['search']) . "%' AND deleted_at IS NULL LIMIT 0, 5";

  $resRecipes = mysqli_query($conn, $sqlRecipes);
  if (!$resRecipes) {
    die('Error de Consulta' . mysqli_error($conn));
  }
  $resCategories = mysqli_query($conn, $sqlCategories);
  if (!$resCategories) {
    die('Error de Consulta' . mysqli_error($conn));
  }
  $resAccounts = mysqli_query($conn, $sqlAccounts);
  if (!$resAccounts) {
    die('Error de Consulta' . mysqli_error($conn));
  }

  $rowRecipes = mysqli_fetch_all($resRecipes, MYSQLI_ASSOC);
  $rowCategories = mysqli_fetch_all($resCategories, MYSQLI_ASSOC);
  $rowAccounts = mysqli_fetch_all($resAccounts, MYSQLI_ASSOC);

  $message = [
    'message' => "Hecho",
    'recipes' => $rowRecipes,
    'categories' => $rowCategories,
    'accounts' => $rowAccounts

  ];

  header("Content-Type: application/json; charset=utf-8");
  return print_r(json_encode($message));
}
