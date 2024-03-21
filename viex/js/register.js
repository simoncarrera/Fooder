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

window.addEventListener('load', () => {
  const name = document.getElementById("name");
  const email = document.getElementById("email");
  const username = document.getElementById("username");
  const password = document.getElementById("password-field");
  const confirmpass = document.getElementById("confirmpassword-field");
  const form = document.getElementById("form");



  form.addEventListener('submit', (e) => {
    e.preventDefault()
    validaCampos()

  })
  const validaCampos = () => {
    //caputrar los valores ingresados :)
    const usernameValue = username.value.trim()
    const nameValue = name.value.trim()
    const emailValue = email.value.trim()
    const passwordValue = password.value.trim()
    const confirmValue = confirmpass.value.trim()


    habilitar = 0;
    //validacion de username
    if (!usernameValue) {
      validafalla(username, 'Por favor ingrese un nombre de usuario')
    } else if (usernameValue.length > 30) {
      validafalla(username, 'Nombre de usuario demasiado largo')
    } else {
      validaOk(username)
      habilitar = habilitar + 1;
    }
    //validar email
    if (!emailValue || !validaEmail(emailValue)) {
      validafalla(email, 'Por favor ingrese un correo electronico valido')
    } else if (emailValue.length > 300) {
      validafalla(email, 'Correo demasiado largo')
    }
    else {
      validaOk(email)
      habilitar = habilitar + 1;
    }
    //validar password
    if (!passwordValue || passwordValue.length < 8) {
      validafalla(password, 'Ingrese una combinacion con al menos ocho caracteres ')
    } else if (passwordValue.length > 50) {
      validafalla(password, 'Contraseña demasiado larga')
    } else {
      validaOk(password)
      //habilitar = habilitar + 1;
    }
    //validar confirmacion
    if (!confirmValue) {
      validafalla(confirmpass, 'Por favor confirme su contraseña')
    }
    else if (passwordValue != confirmValue) {
      validafalla(confirmpass, 'Las contraseñas no coinciden')
    }
    else {
      validaOk(confirmpass)
      //habilitar = habilitar + 1;
    }
    //validacion del nombre

    if (!nameValue) {
      validafalla(name, 'Por favor ingrese un nombre')
    }
    else if (nameValue.length > 50) {
      validafalla(name, 'Nombre demasiado largo')
    } else {
      validaOk(name)
      //habilitar = habilitar + 1;
    }
    // validación para enviar el form
    if (habilitar > 0) {
      register(usernameValue, nameValue, emailValue, passwordValue, confirmValue);

      //document.getElementById("form").submit()
    }
  }
  const validafalla = (input, msje) => {
    const form = input.parentElement
    const warning = form.querySelector('p')
    warning.innerText = msje
    form.classList = 'form-group fail'
  }
  const validaOk = (input, msje) => {
    const form = input.parentElement
    const warning = form.querySelector('p')
    warning.innerText = null
    form.classList = 'form-group success'
  }

  const validaEmail = (email) => {
    return /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,3}$/i.test(email);
  }

  function register(usernameValue, nameValue, emailValue, passwordValue, confirmValue) {
    $.ajax({
      url: '../api/users/register_validation.php',
      type: 'POST',
      data: { username: usernameValue, name: nameValue, email: emailValue, password: passwordValue, confirmpassword: confirmValue },
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        if (data.name != null) {
          validafalla(name, data.name);
        } else {
          validaOk(name);
        }
        if (data.username != null) {
          validafalla(username, data.username);
        } else {
          validaOk(username);
        }
        if (data.password != null) {
          validafalla(password, data.password);
        } else {
          validaOk(password);
        }
        if (data.cpassword != null) {
          validafalla(confirmpass, data.cpassword);
        } else {
          validaOk(confirmpass);
        }
        if (data.email != null) {
          validafalla(email, data.email);
        } else {
          validaOk(email);
        }

        if (data.message == "Se ha registrado correctamente") {
          let timerInterval
          Swal.fire({
            html: 'Se registro con exito',
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

        } else{
          let timerInterval
          Swal.fire({
            html: 'Error al registrarse',
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
      }
    });
  }
  /*const expresiones = (password) => {
   return  / ^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])$/i.test(password)
  }*/
})
