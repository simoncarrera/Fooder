<?php

require_once "../../includes/config.php";
require_once "../../includes/functions.php";

$sqlFeaturedCategories = "SELECT id, name FROM categories WHERE featured IS NOT NULL";
$resFeaturedCategories = mysqli_query($conn, $sqlFeaturedCategories);
if(!$resFeaturedCategories){
    die("Error en la consulta: " . mysqli_error($conn));
}
$cant_featured_categories = mysqli_num_rows($resFeaturedCategories);
$rowFeaturedCategories = mysqli_fetch_all($resFeaturedCategories, MYSQLI_ASSOC);

$page = "Inicio";
$section = "home";
require_once "../../views/layout.php";
