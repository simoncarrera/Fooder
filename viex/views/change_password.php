<div class="container-v5 d-grid grid-template-rows">
  <h4 class="mb-5 mt-4 ms-5">Ajustes de usuario</h4>
  <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-around">
    <a href="../web/edit_profile.php" aria-selected="false">Editar perfil</a>
    <a href="../web/change_password.php" aria-selected="true">Cambiar contraseña</a>
  </div>
</div>
<div class="container-v3">

  <form method="POST" action="../web/change_password.php" id="form" class="form">

    <div class="form__container">
      <div class="form__container--content <?php echo (isset($errormessage_oldpass)) ? "fail" : "success"; ?>">
        <label class="form__container--text" for="password">Contraseña anterior</label>
        <input type="password" id="oldpass" class="form-control form__container--input" name="oldpass" value="<?php echo (isset($_POST['oldpass'])) ? $_POST['oldpass'] : null; ?>">
        <p class="errormessage__form" style="width: 320px;"><?php echo (isset($errormessage_oldpass)) ? $errormessage_oldpass : null; ?></p>
      </div>
    </div>

    <div class="form__container">
      <div class="form__container--content <?php echo (isset($errormessage_newpass)) ? "fail" : "success"; ?>">
        <label class="form__container--text" for="password">Nueva contraseña</label>
        <input type="password" id="newpass" class="form-control form__container--input" name="newpass" value="<?php echo (isset($_POST['newpass'])) ? $_POST['newpass'] : null; ?>">
        <p class="errormessage__form" style="width: 320px;"><?php echo (isset($errormessage_newpass)) ? $errormessage_newpass : null; ?></p>
      </div>
    </div>

    <div class="form__container">
      <div class="form__container--content <?php echo (isset($errormessage_cnewpass)) ? "fail" : "success"; ?>">
        <label class="form__container--text" for="password">Repetir nueva contraseña</label>
        <input type="password" id="cnewpass" class="form-control form__container--input" name="cnewpass" value="<?php echo (isset($_POST['cnewpass'])) ? $_POST['cnewpass'] : null; ?>">
        <p class="errormessage__form" style="width: 320px;"><?php echo (isset($errormessage_cnewpass)) ? $errormessage_cnewpass : null; ?></p>
      </div>
    </div>

    <div class="form__container">
      <div class="form__container--content">
        <button type="submit" class="form__container--button btn btn-warning">Cambiar contraseña</button>
      </div>
    </div>

    <div class="form__container">
      <div class="form__container--content">
        <a class="form__container--a" href="forgot_password.php">¿Olvidaste tu contraseña?</a>
      </div>
    </div>
  </form>
</div>

<script src="../../js/change_password.js" type="text/javascript"></script>