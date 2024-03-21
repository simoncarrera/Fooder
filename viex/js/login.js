(function ($) {
  "use strict";

  $(".toggle-password").click(function () {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
})(jQuery);

(function ($) {
  "use strict";

  $(".toggle-confirmpassword").click(function () {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
})(jQuery);

window.addEventListener("load", () => {
  const email = document.getElementById("email");
  const password = document.getElementById("password-field");
  const form = document.getElementById("form");

  form.addEventListener("submit", (e) => {
    e.preventDefault();
    validaCampos();
  });
  const validaCampos = () => {
    //caputrar los valores ingresados :)
    const emailValue = email.value.trim();
    const passwordValue = password.value.trim();
    habilitar = 0;
    //validar email
    if (!emailValue) {
      validafalla(email, "Por favor ingrese un correo");
    } else {
      validaOk(email);
      habilitar++;
    }
    //validar password
    if (!passwordValue) {
      validafalla(password, "Por favor ingrese una contraseña");
    } else {
      validaOk(password);
    }

    if (habilitar > 0) {
      const remember = $("#remember").is(":checked") ? 1 : 0;
      login(emailValue, passwordValue, remember);
      //document.getElementById("form").submit()
    }
  };
  const validafalla = (input, msje) => {
    const form = input.parentElement;
    const warning = form.querySelector("p");
    warning.innerText = msje;
    form.classList = "form-group fail";
  };
  const validaOk = (input, msje) => {
    const form = input.parentElement;
    const warning = form.querySelector("p");
    warning.innerText = null;
    form.classList = "form-group success";
  };

  function login(emailValue, passwordValue, remember) {
    $.ajax({
      url: "../api/users/login_validation.php",
      type: "POST",
      data: { email: emailValue, password: passwordValue, remember: remember },
      dataType: "JSON",
      success: function (data) {
        console.log(data);
        if (data.email != null) {
          validafalla(email, data.email);
        } else {
          validaOk(email);
        }
        if (data.password != null) {
          validafalla(password, data.password);
        } else {
          validaOk(password);
        }

        if (data.message == "Se ha iniciado sesión correctamente") {
          let timerInterval
          Swal.fire({
            html: 'Se ha iniciado sesión correctamente',
            timer: 1200,
            timerProgressBar: false,
            position: 'bottom-start',
            showConfirmButton: false,
            width: 'auto',
            padding: '2px',
            grow: "row",
            backdrop: true,
            toast: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            stopKeydownPropagation: false,
            background: '#fdb801',
            color: '#ffffff',
            willClose: () => {
              clearInterval(timerInterval)
            }
          }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
              window.location.href = "../web/home.php";
            }

          })
        } else {
          let timerInterval
          Swal.fire({
            html: (typeof data.account != 'undefined') ? data.account : 'Error al iniciar sesión. ',
            timer: 1200,
            timerProgressBar: false,
            position: 'bottom-start',
            showConfirmButton: false,
            width: 'auto',
            padding: '2px',
            grow: "row",
            backdrop: true,
            toast: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            stopKeydownPropagation: false,
            background: '#fdb801',
            color: '#ffffff',
            willClose: () => {
              clearInterval(timerInterval)
            }
          })
        }
      },
    });
  }
});
