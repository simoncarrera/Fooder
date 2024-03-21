<?php
require_once('../../includes/config.php');

if (!empty($_POST)) {

  $password = sha1($_POST['password']);
  $cpassword = sha1($_POST['confirmpassword']);

  if ($password == $cpassword) {
    $sql = "UPDATE users SET password = '$password', modified_at= now() WHERE token='aLbK?48ai?n5jD7'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      header('Location: login.php');
    }
  } else {
    /* Contraseñas no coinciden */
  }
}


$page = "Nueva contraseña";
$section = "new_password";
require_once('../../views/layout2.php');
