<!DOCTYPE html>
<html lang="es" data-theme="light">

<head>
  <title><?php echo $page; ?> • Fooder</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Viex Inc.">

  <link rel="icon" sizes="192x192" href="../../images/Logo Fooder icono.png">
  <link href="../../css/style_layout1.css" rel="stylesheet">

  <script src="https://kit.fontawesome.com/770a68900d.js" crossorigin="anonymous"></script>

  <!-- FONTS -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
  <!-- BOOTSTRAP -->
  <script src="../../js/bootstrap.bundle.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">
  <!-- JQUERY -->
  <script src="../../js/jquery.min.js"></script>

  <!-- SELECT2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/js/i18n/es.js"></script>
  <!--<script src="../../select2-4.1.0-beta.0/dist/js/select2.full.js"></script>
  <script src="../../select2-4.1.0-beta.0/dist/js/i18n/es.js"></script>-->
  <!-- ALERTS/POPUPS-->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- IS BANNED   -->
</head>

<body>

  <?php
  // Traigo todas las funciones necesarias
  require_once "../../includes/functions.php";
  // Traigo el menu
  require_once('../../includes/menu.php');
  ?>
  <!-- Empieza el contenido especifico -->
  <div class="container ">
    <?php require_once($section . ".php") ?>
  </div>
  <!-- Termina el contenido especifico -->

  <div id="scroll-up">
    <i class="bi bi-chevron-up"></i>
  </div>

  <script src="../../js/main.js" type="text/javascript"></script>
</body>

</html>