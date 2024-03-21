<div class="container-v5 d-grid grid-template-rows">
  <h4 class="mb-5 mt-4 ms-5">Ajustes de usuario</h4>
  <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-around">
    <a href="../web/edit_profile.php" aria-selected="true">Editar perfil</a>
    <a href="../web/change_password.php" aria-selected="false">Cambiar contraseña</a>
  </div>
</div>
<div class="container-v3">

  <form method="POST" action="../api/users/upload_photo.php" enctype="multipart/form-data" class="form">
    <div class="form__container">
      <a class="p-0 form__container--img" data-bs-toggle="modal" data-bs-target="#Cambiarfoto"><img class="form__container--img" id="user_profile_pic" src="<?php echo profile_image($_SESSION['user']['id']); ?>" alt="foto de perfil"></a>
      <div class="form__container--content">

        <label class="user_data_id" id="<?php echo $_SESSION['user']['id']; ?>"><?php echo $_SESSION['user']['username']; ?></label>
        <input id="form__container--file" type="file" accept="image/jpeg,image/png,image/gif,image/webp" name="avatar">
        <a class="form__container--a" data-bs-toggle="modal" data-bs-target="#Cambiarfoto">Cambiar foto de perfil</a>
      </div>
    </div>
    <!--Modal -->
    <div class="modal fade" id="Cambiarfoto">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="cambiarfoto">Cambiar foto de perfil</h5>
            <a role="button" class="btn-close" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></a>
          </div>
          <div class="modal-body">
            <button type="button" id="change_profile_pic" class="form__container--button btn ">Cambiar foto</button>
            <hr>
            <button type="button" id="delete_profile_pic" class="form__container--button btn ">Eliminar foto</button>
            <hr>
            <a role="button" class="form__container--button btn " data-bs-dismiss="modal">Cancelar</a>
          </div>
        </div>
      </div>
    </div>
    <!--Modal -->
  </form>


  <form method="POST" action="" id="form" class="form">
    <div class="form__container">
      <div class="form__container--content <?php echo (isset($errormessage_name)) ? "fail" : "success"; ?>">
        <label class="form__container--text">Nombre</label>
        <input id="name" class="form-control form__container--input" type="text" maxlength="50" name="name" value="<?php echo (isset($name)) ? $name : $_SESSION['user']['name']; ?>">
        <p class="errormessage__form"><?php echo (isset($errormessage_name)) ? $errormessage_name : null; ?></p>
      </div>
    </div>

    <div class="form__container">
      <div class="form__container--content <?php echo (isset($errormessage_username)) ? "fail" : "success"; ?>">
        <label class="form__container--text">Nombre de usuario</label>
        <input id="username" class="form-control form__container--input" type="text" maxlength="30" name="username" value="<?php echo (isset($username)) ? $username : $_SESSION['user']['username']; ?>">
        <p class="errormessage__form"><?php echo (isset($errormessage_username)) ? $errormessage_username : null; ?></p>
      </div>
    </div>

    <div class="form__container">
      <div class="form__container--content">
        <label class="form__container--text">Biografía</label>
        <textarea id="biography" class="form__container--textarea-biografy form-control" name="biography"><?php echo (isset($biography)) ? $biography : $_SESSION['user']['biography']; ?></textarea>
        <p class="errormessage__form"></p>
      </div>
    </div>

    <div class="form__container">
      <div class="form__container--content <?php echo (isset($errormessage_email)) ? "fail" : "success"; ?>">
        <label class="form__container--text">Correo electronico</label>
        <input id="email" class="form-control form__container--input" type="text" maxlength="50" name="email" value="<?php echo (isset($email)) ? $email : $_SESSION['user']['email']; ?>">
        <p class="errormessage__form"><?php echo (isset($errormessage_email)) ? $errormessage_email : null; ?></p>
      </div>
    </div>

    <div class="form__container">
      <div class="form__container--content">
        <label class="form__container--text">Genero</label>
        <select name="gender" id="gender" class="form-control form__container--input" required>
          <!--<option value="null" selected disabled hidden>Seleccione su genero</option>-->
          <option value="male" <?php echo ($_SESSION['user']['gender'] == "male") ? "selected" : null; ?>>Masculino</option>
          <option value="female" <?php echo ($_SESSION['user']['gender'] == "female") ? "selected" : null; ?>>Femenino</option>
          <option value="other" <?php echo ($_SESSION['user']['gender'] == "other") ? "selected" : null;  ?>>Otro</option>
          <option value="no" <?php echo ($_SESSION['user']['gender'] == "no") ? "selected" : null; ?>>Prefiero no contestar</option>
        </select>
      </div>
    </div>

    <div class="form__container">
      <button id="btn-submit" class="form__container--button btn btn-warning " type="submit" name="confirm">Confirmar</button>
      <a class="form__container--a  ms-6" data-bs-toggle="modal" data-bs-target="#exampleModal" role="button">Desactivar mi cuenta</a>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">¿Seguro que quieres desactivar tú cuenta?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Si desactivas tu cuenta no podras volver a activarla nuevamente.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary button-modal" data-bs-dismiss="modal">Cancelar</button>
            <a class="btn btn-warning button-modal" href="../api/users/disable.php">Confirmar</a>
          </div>
        </div>
      </div>
    </div>

  </form>
</div>

<script src="../../js/edit_profile.js" type="text/javascript"></script>