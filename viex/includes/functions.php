<?php

// Devolver nombre de foto de perfil
function profile_pic($id)
{
  if (is_dir($dir = "../../" . RUTA_AVATAR . "/" . $id) || is_dir($dir = "../../../" . RUTA_AVATAR . "/" . $id)) {
    $fotoperfil = scandir($dir, 1)[0];
    return "../../" . RUTA_AVATAR . "/" .  $id . "/" . $fotoperfil;
  } else {
    return "../../" . RUTA_AVATAR . "/default.png";
  }
}
//Devolver el profile_img de foto de perfil
function profile_image($id)
{
  if (is_dir($dir = "../../" . RUTA_AVATAR . "/".$id."/profile_pic") || is_dir($dir = "../../../" . RUTA_AVATAR . "/".$id."/profile_pic")) {
    $fotoperfil = scandir($dir, 1);
    return "../../". RUTA_AVATAR . "/".$id."/profile_pic/".$fotoperfil[0] ;
  } else {
    return "../../" . RUTA_AVATAR . "/default.png";
  }
}

// Devolver nombres de fotos de receta
function recipe_pics($id)
{
  if (is_dir($dir = "../../" . RUTA_IMG_RECIPES . "/" . $id) || is_dir($dir = "../../../" . RUTA_IMG_RECIPES . "/" . $id)) {
    $scan_folder = scandir($dir, 1);
    for ($i = 0; $i < count($scan_folder) - 2; $i++) {
      $recipes_imgs[] = $scan_folder[$i];
    }
    return $recipes_imgs;
  }
}

function category_pics($id)
{
  if (is_dir($dir = "../../" . RUTA_IMG_CATEGORIES . "/" . $id) || is_dir($dir = "../../../" . RUTA_IMG_CATEGORIES . "/" . $id)) {
    $scan_folder = scandir($dir, 1);
    for ($i = 0; $i < count($scan_folder) - 2; $i++) {
      $categories_imgs[] = $scan_folder[$i];
    }
    return (isset($categories_imgs)) ? $categories_imgs : null;
  }
}

// Cambiar formato de fecha
function creation_date($fecha)
{
  $fechaactual = date('Y-m-d H:i:s');
  $tsactual = strtotime($fechaactual);
  $creado = $fecha;
  $segtranscurridos = $tsactual - strtotime($creado);
  if ($segtranscurridos > 60) {
    $minstranscurridos = floor($segtranscurridos / 60);
    if ($minstranscurridos > 60) {
      $hstranscurridas = floor($minstranscurridos / 60);
      if ($hstranscurridas > 24) {
        $diastranscurridos = floor($hstranscurridas / 24);
        if ($diastranscurridos > 7) {
          $mes_num = substr($creado, 5, 2);

          if (substr($creado, 2, 2) == substr($fechaactual, 2, 2)) {
            return substr($creado, 8, 2) . " " . parseNumToAbrrMonth($mes_num);
          } else {
            return substr($creado, 8, 2) . " " . parseNumToAbrrMonth($mes_num) . " " . substr($creado, 2, 2);
          }
        } else {
          return "hace " . $diastranscurridos . "d";
        }
      } else {
        return "hace " . $hstranscurridas . "h";
      }
    } else {
      return "hace " . $minstranscurridos . "m";
    }
  } else {
    return "hace " . $segtranscurridos . "s";
  }
}

function reasonReport($reason) {
  switch ($reason) {
    case "cont_sex":
      return "Contenido sexual";
      break;
    case "abus_men":
      return "Abuso de menores";
      break;
    case "fomen_terr":
      return "Fomenta el terrorismo";
      break;
    case "cont_copi":
      return "Contenido plagiado";
      break;
    case "inf_err":
      return "Informacion errónea";
      break;
    case "cont_ofens":
      return "Contenido ofensivo";
      break;
  }
}


function parseNumToAbrrMonth($month)
{
  $months = ["ene.", "feb.", "mar.", "abr.", "may.", "jun.", "jul.", "ago.", "sep.", "oct.", "nov.", "dic."];
  if (intval($month) > 0 && intval($month) < 13) {
    return $months[$month - 1];
  }
}
