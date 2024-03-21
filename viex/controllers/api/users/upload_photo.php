<?php


require_once "../../../includes/config.php";

$message = ["message" => "Error"];
if (isset($_SESSION['user'])) {
  if (!empty($_FILES)) {
    /*return print_r(json_encode($_FILES));
    die;*/
    foreach ($_FILES as $key => $file) {

      if (strpos($file['type'], "jpeg") || strpos($file['type'], "jpg") ||strpos($file['type'], "png") || strpos($file['type'], "gif") || strpos($file['type'], "webp")) {
        if ($file['size'] < 3000000 /*3MB*/) {
          // Verifico si existe una carpeta en images/profile. Si no existe, la creo. Si existe entro y borro los archivos que tiene (no las carpetas), luego lo cierro
          $dir = "../../../images/profiles/" . $_SESSION['user']['id'];
          $profile_pic = $dir."/profile_pic";
          if (!is_dir($dir)) {
            mkdir($dir);
            mkdir($profile_pic);
          } else {
            $files = scandir($dir, 1);
            $files2 = scandir($profile_pic, 1);

            for ($i = 0; $i < (count($files)) - 2; $i++) {
              if (is_file($dir . "/" . $files[$i])) {
                unlink($dir . "/" . $files[$i]);
              }
            }

            if(!is_dir($profile_pic)){
              mkdir($profile_pic);
            } else {
              for ($i = 0; $i < (count($files2)) - 2; $i++) {
                if (is_file($profile_pic . "/" . $files2[$i])) {
                  unlink($profile_pic . "/" . $files2[$i]);
                }
              }
            }
            
          }

          $ruta = "images/profiles/" . $_SESSION['user']['id'] . "/" . $file['name'];

          if (move_uploaded_file($file['tmp_name'], "../../../" . $ruta) && is_dir($profile_pic)) {
            //las medidas las cuales queremos aplicar a la img 
            $profile_width = 250;
            $profile_height = 250;

            //dependiendo el formato cambian algunas cosas pero es basicamente lo mismo
            if (strpos($file['type'], "webp")) {
              $resource_org = imagecreatefromwebp("../../../" . $ruta); // tomo la imagen a copiar
              $profile_image =  $profile_pic . "/" . $file['name']; // creo la ruta donde se va a guardar la img de profile con el nuevo resize
              
              $profile_scalated = imagescale($resource_org, $profile_width, $profile_height); // configuro las medidas de la img de profile

              imagewebp($profile_scalated, $profile_image); // guardo la img profile en la direccion antes declarada

            } elseif (strpos($file['type'], "jpeg") || strpos($file['type'], "jpg")) {
              $resource_org = imagecreatefromjpeg("../../../" . $ruta); //idem
              $profile_image = $profile_pic . "/" . $file['name'];

              $profile_scalated = imagescale($resource_org, $profile_width, $profile_height);

              imagejpeg($profile_scalated, $profile_image);

            } elseif (strpos($file['type'], "png")) {
              $resource_org = imagecreatefrompng("../../../" . $ruta); //idem
              $profile_image =  $profile_pic . "/" . $file['name'];

              $profile_scalated = imagescale($resource_org, $profile_width, $profile_height);

              imagepng($profile_scalated, $profile_image);

            } elseif (strpos($file['type'], "gif")) {
              $resource_org = imagecreatefromgif("../../../" . $ruta); //idem
              $profile_image = $profile_pic . "/" . $file['name'];

              $profile_scalated = imagescale($resource_org, $profile_width, $profile_height);
              
              imagegif($profile_scalated, $profile_image);

            }

            $message = [
              'message' => "Hecho",
              'action' => "Se ha cambiado correctamente la foto de perfil ".$_SESSION['user']['id']
            ];
          } else {
            $message['reason'] = "Problema al intentar subir la imagen";
          }
        } else {
          // El archivo pesa mas de 3MB. Sirve para los mensajes de error
          $message['reason'] = "El archivo debe pesar como maximo 3MB";
        }
      } else {
        // El archivo no es jpeg, png o gif. Sirve para los mensajes de error
        $message['reason'] = "El archivo debe ser JPEG, PNG, GIF o WEBP";
      }
    }
  }
} else {
  // No esta logueado
  $message['reason'] = "No estas lgueado";
}

header("Content-Type: application/json; charset=utf-8");
return print_r(json_encode($message));
