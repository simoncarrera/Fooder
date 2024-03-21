window.addEventListener('load', () => {
  const oldpass = document.getElementById("oldpass");
  const newpass = document.getElementById("newpass");
  const cnewpass = document.getElementById("cnewpass");
  const form = document.getElementById("form");

  // Capto el evento submit y prevengo su evento por defecto, luego llamo a la funcion que valida los campos
  form.addEventListener('submit', (e) => {
    e.preventDefault()
    validaCampos()
  })
  const validaCampos = () => {
    //caputrar los valores ingresados :)
    const oldpassValue = oldpass.value.trim()
    const newpassValue = newpass.value.trim()
    const cnewpassValue = cnewpass.value.trim()
    var expresiones = /[^\x20\x2D0-9A-z\x5Fa-z\xC0-\xD6/xD8-\xF6\xF8-\xFF]/g;
    habilitar = 0;

    if (!oldpassValue) {
      validafalla(oldpass, 'Por favor ingrese su contraseña actual')
    } else {
      validaOk(oldpass)
      habilitar++;
    }
    //validar newpass
    if (!newpassValue || newpassValue.length < 8 || newpassValue.match(expresiones)) {
      validafalla(newpass, 'Ingrese una combinacion con al menos ocho caracteres y sin caracteres especiales')
    } else {
      validaOk(newpass)
      habilitar++;
    }
    //validar cnewpassacion
    if (!cnewpassValue) {
      validafalla(cnewpass, 'Por favor confirme su nueva contraseña')
    } else if (newpassValue != cnewpassValue) {
      validafalla(cnewpass, 'Asegurate de que ambas contraseñas coincidan.')
    } else {
      validaOk(cnewpass)
      habilitar++;
    }

    // Hago submit si todo salio bien
    if (habilitar == 3) {
      changePassword(oldpassValue, newpassValue, cnewpassValue);
    } else {
      let timerInterval
      Swal.fire({
        html: 'Error al intentar cambiar contraseña',
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
  const validafalla = (input, msje) => {
    const form = input.parentElement
    const warning = form.querySelector('p')
    warning.innerText = msje
    form.classList = 'form__container--content  fail'
  }
  const validaOk = (input, msje) => {
    const form = input.parentElement
    const warning = form.querySelector('p')
    form.classList = 'form__container--content success'
  }

  function changePassword(oldpassValue, newpassValue, cnewpassValue) {
    $.ajax({
      url: "../api/users/change_password.php",
      type: "POST",
      data: { oldpass: oldpassValue, newpass: newpassValue, cnewpass: cnewpassValue },
      dataType: "JSON",
      success: function (data) {
        console.log(data);
        if (data.error_oldpass != null) {
          validafalla(oldpass, data.error_oldpass);
        } else {
          validaOk(oldpass);
        }
        if (data.error_newpass != null) {
          validafalla(newpass, data.error_newpass);
        } else {
          validaOk(newpass);
        }
        if (data.error_cnewpass != null) {
          validafalla(cnewpass, data.error_cnewpass);
        } else {
          validaOk(cnewpass);
        }

        if (data.message == "Hecho") {
          let timerInterval
          Swal.fire({
            html: 'Se ha actualizad correctamente la contraseña',
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
            }

          })
        } else {
          let timerInterval
          Swal.fire({
            html: 'Error al intentar cambiar contraseña',
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
})