<section class="ftco-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-6">
        <div class="wrap">
          <div class="img" style="background-image: url(../../images/frutas.jpg);"></div>
          <div class="login-wrap p-4 p-md-5">
            <div class="d-flex">
              <div class="w-100">
                <h3 class="mb-2	"><b>Inicia sesión en Fooder</b></h3>
              </div>
              <div class="w-100">
                <p class="social-media d-flex justify-content-end">
                  <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
                  <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-google"></span></a>
                </p>
              </div>
            </div>

            <form method="POST" action="" id="form" class="signin-form mt-3">
              <div class="form-group">
                <input type="text" id="email" class="form-control" name="email">
                <label class="form-control-placeholder" for="email">Email</label>
                <p class="errormessage__form"></p>
              </div>
              <div class="form-group">
                <input id="password-field" type="password" class="form-control" name="password">
                <label class="form-control-placeholder" for="password">Contraseña</label>
                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                <p class="errormessage__form"></p>
              </div>
              <div class="form-group">
                <button type="submit" class="form-control btn btn-primary rounded submit px-3">Iniciar sesión</button>
              </div>
              <div class="form-group d-md-flex">
                <div class="w-50 text-left">
                  <label class="checkbox-wrap checkbox-primary mb-0">Recordarme
                    <input type="checkbox" id="remember" name="remember" value="1">
                    <span class="checkmark"></span>
                  </label>
                </div>
                <div class="w-100 mt-1 text-md-right">
                  <a class="links2" href="../web/forgot_password.php">¿Olvidaste tu contraseña?</a>
                </div>
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

            <p class="text-center">¿No tenes cuenta? <a class="links" href="../web/register.php">Registrarse</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="../../js/login.js" type="text/javascript"></script>