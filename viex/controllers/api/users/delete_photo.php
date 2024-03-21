<?php

require_once "../../../includes/config.php";

$message = ["message" => "Error"];

$dir = "../../../images/profiles/" . $_SESSION['user']['id'];
$profile_pic = $dir . "/profile_pic";

if (is_dir($dir)) {
  $files = scandir($dir, 1);
  $files2 = scandir($profile_pic, 1);
  //return print_r(json_encode($files2));

  for ($i = 0; $i < (count($files)) - 2; $i++) {
    if (is_file($dir . "/" . $files[$i])) {
      unlink($dir . "/" . $files[$i]);
    }
  }

  for ($i = 0; $i < (count($files2)) - 2; $i++) {
    if (is_file($profile_pic . "/" . $files2[$i])) {
      unlink($profile_pic . "/" . $files2[$i]);
    }
  }
  rmdir($profile_pic);
  rmdir($dir);

  $message = [
    'message' => "Hecho",
    'action' => "Se ha eliminado correctamente la foto de perfil"
  ];
} else {
  $message['reason'] = "No tienes foto de perfil";
}

header("Content-Type: application/json; charset=utf-8");
return print_r(json_encode($message));
