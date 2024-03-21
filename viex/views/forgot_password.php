<section class="ftco-section">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-6">
        <div class="wrap">
          <div class="img" style="background-image: url(../../images/frutas.jpg);"></div>
          <div class="login-wrap p-4 p-md-5">
            <div class="d-flex">
              <div class="w-100">
                <h3 class="mb-4"><b>¿Olvidaste tu contraseña?</b></h3>
                <p class="text-left">Ingresa tu correo electrónico y te enviaremos un enlace para que recuperes el acceso a tu
                  cuenta.</p>
              </div>
            </div>
            <form method="post" action="../web/forgot_password.php" class="forgotpassword-form">
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="token" required>
                <label class="form-control-placeholder" for="token">Email</label>
              </div>
              <div class="form-group">
                <button type="submit" class="form-control btn btn-primary rounded submit px-3">Enviar enlace para restablecer contraseña</button>
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

            <p class="text-center"><a class="links2" href="login.php">Volver al inicio de sesión</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="../../js/main.js" type="text/javascript"></script>