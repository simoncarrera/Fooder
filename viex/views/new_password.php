<section class="ftco-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-6">
        <div class="wrap">
          <div class="img" style="background-image: url(../../images/frutas.jpg);"></div>
          <div class="login-wrap p-4 p-md-5">
            <div class="d-flex">
              <div class="w-100">
                <h3 class="mb-4"><b>Nueva contraseña</b></h3>
                <p class="text-left">Crea una nueva contraseña con, al menos, 6 caracteres</p>
              </div>
            </div>
            <form method="post" action="../web/new_password.php" class="newpassword-form">
              <div class="form-group mt-3">
                <input id="password-field" type="password" class="form-control" name="password" required>
                <label class="form-control-placeholder" for="password">Contraseña</label>
                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
              </div>
              <div class="form-group">
                <input id="password-field" type="password" class="form-control" name="confirmpassword" required>
                <label class="form-control-placeholder" for="confirmpassword">Repetir contraseña</label>
                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
              </div>
              <div class="form-group">
                <button type="submit" class="form-control btn btn-primary rounded submit px-3">Restablecer contraseña</button>
              </div>
            </form>
            <!-- hr con o -->
            <div class="d-flex">
              <div class="w-45">
                <hr>
              </div>
              <div class="w-10">
                <h5 class="text-center" id="o">o</h5>
              </div>
              <div class="w-45">
                <hr>
              </div>
            </div>

            <p class="text-center"><a class="links2" href="../web/login.php">Ir al inicio de sesión</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>