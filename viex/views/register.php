<section class="ftco-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-6">
        <div class="wrap">
          <div class="img" style="background-image: url(../../images/frutas.jpg);"></div>
          <div class="login-wrap p-4 p-md-5">
            <div class="d-flex">
              <div class="w-100">
                <h3 class="mb-4"><b>Registrate en Fooder</b> </h3>
              </div>
              <div class="w-100">
                <p class="social-media d-flex justify-content-end">
                  <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-facebook"></span></a>
                  <a href="#" class="social-icon d-flex align-items-center justify-content-center"><span class="fa fa-google"></span></a>
                </p>
              </div>
            </div>

            <form method="post" action="" class="signup-form mt-3" id="form">
              <div class="form-group ">
                <input type="text" class="form-control" name="email" id="email" maxlength="300">
                <label class="form-control-placeholder" for="email">Email</label>
                <p class="errormessage__form"></p>
              </div>
              <div class="form-group">
                <input type="text" class="form-control" name="name" id="name" maxlength="50">
                <label class="form-control-placeholder" for="name">Nombre</label>
                <p class="errormessage__form"></p>
              </div>
              <div class="form-group ">
                <input type="text" class="form-control" name="username" id="username" maxlength="30">
                <label class="form-control-placeholder" for="username">Nombre de usuario</label>
                <p class="errormessage__form"></p>
              </div>
              <div class="form-group ">
                <input id="password-field" type="password" class="form-control " name="password">
                <label class="form-control-placeholder" for="password">Contraseña</label>
                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                <p class="errormessage__form"></p>
              </div>
              <div class="form-group ">
                <input id="confirmpassword-field" type="password" class="form-control form" name="confirmpassword">
                <label class="form-control-placeholder" for="confirmpassword">Confirmar contraseña</label>
                <span toggle="#confirmpassword-field" class="fa fa-fw fa-eye field-icon toggle-confirmpassword"></span>
                <p class="errormessage__form"></p>
              </div>

              <p class="text-center">Al registrarte, aceptas los <a class="terms" href="#terminosycondiciones"><b>terminos y condiciones</b></a></p>

              <div class="form-group">
                <button type="submit" class="form-control btn btn-primary rounded submit px-3" name="button submit">Registrarse</button>
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

            <p class="text-center">¿Ya tenes cuenta? <a class="links" href="login.php">Iniciar sesión</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="../../js/register.js" type="text/javascript"></script>