<div class="container-v5 d-flex justify-content-center">
  <span class="alert-recipes-followed ">
    <?php
    echo (isset($_SESSION['user'])) ? "En esta pantalla podras ver solo las recetas de las personas que sigues!" :  'Debes <a class="login-for-view text-decoration-underline" href="register.php">registrarte</a> o <a class="login-for-view text-decoration-underline" href="login.php">iniciar sesión</a> en Fooder, para poder ver las recetas de las personas a las que sigues';
    ?>
  </span>
</div>

<div id="container__recipes">

</div>


<?php
if (isset($_SESSION['user'])) { ?>
  <script src="../../js/recipes.js" type="text/javascript"></script>
  <script src="../../js/likes.js" type="text/javascript"></script>
<?php
} ?>