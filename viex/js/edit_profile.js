// ES IGUAL QUE RIGSTER.JS, PERO SIN PASSWORD Y CONFIRM PASSWORD

window.addEventListener('load', () => {
  const name = document.getElementById("name");
  var oldnameValue = document.getElementById("name").value.trim();
  const email = document.getElementById("email");
  var oldemailValue = document.getElementById("email").value.trim();
  const username = document.getElementById("username");
  var oldusernameValue = document.getElementById("username").value.trim();
  const biography = document.getElementById('biography')
  var oldbiographyValue = document.getElementById("biography").value.trim();
  var oldgenderValue = $('#gender').val()
  const form = document.getElementById("form");

  form.addEventListener('submit', (e) => {
    e.preventDefault()
    validaCampos()
  })
  const validaCampos = () => {
    //caputrar los valores ingresados :)
    const usernameValue = username.value.trim()
    const nameValue = name.value.trim()
    const emailvalue = email.value.trim()
    const bioValue = biography.value.trim()
    const genderValue = $('#gender').val()
    var expresiones = /[^\x20\x2D0-9A-z\x5Fa-z\xC0-\xD6/xD8-\xF6\xF8-\xFF]/g;
    habilitar = 0;

    //validación de la biografia
    if (bioValue.length > 300) {
      validafalla(biography, 'La biografia demasiado larga')
    }
    else {
      validaOk(biography)
      habilitar++;
    }


    //Validacion de username
    if (!usernameValue || usernameValue.match(expresiones)) {
      validafalla(username, 'Por favor ingrese un nombre de usuario sin caracteres especiales')
    }
    else if (usernameValue.length > 30) {
      validafalla(username, 'Nombre de usuario demasiado largo')
    }
    else {
      validaOk(username)
      habilitar++;
    }

    //Validar email
    if (!emailvalue || !validaEmail(emailvalue)) {
      validafalla(email, 'Por favor ingrese un correo electronico valido')
    } else if (emailvalue.length > 300) {
      validafalla(email, 'Correo demasiado largo')
    }
    else {
      validaOk(email)
      habilitar++;
    }

    //Validacion del nombre
    if (!nameValue || nameValue.match(expresiones)) {
      validafalla(name, 'Por favor ingrese un nombre sin caracteres especiales')
    }
    else if (nameValue.length > 50) {
      validafalla(name, 'Nombre demasiado largo')
    }
    else {
      validaOk(name)
      habilitar++;
    }
    // validación para enviar el form
    if (oldnameValue != nameValue || oldusernameValue != usernameValue || oldbiographyValue != bioValue || oldemailValue != emailvalue || oldgenderValue != genderValue) {
      editProfile(emailvalue, usernameValue, nameValue, bioValue, genderValue)
    } 
  }
  const validafalla = (input, msje) => {
    const form = input.parentElement
    const warning = form.querySelector('p')
    warning.innerText = msje
    form.classList = 'form__container--content fail'
  }
  const validaOk = (input, msje) => {
    const form = input.parentElement
    const warning = form.querySelector('p')
    form.classList = 'form__container--content success'
  }

  const validaEmail = (email) => {
    return /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,3}$/i.test(email);
  }

  function editProfile(emailValue, usernameValue, nameValue, bioValue, genderValue) {
    $.ajax({
      url: "../api/users/edit.php",
      type: "POST",
      data: { email: emailValue, username: usernameValue, name: nameValue, biography: bioValue, gender: genderValue },
      dataType: "JSON",
      success: function (data) {
        console.log(data);
        if (data.error_email != null) {
          validafalla(email, data.error_email);
        } else {
          validaOk(email);
        }
        if (data.error_username != null) {
          validafalla(username, data.error_username);
        } else {
          validaOk(username);
        }
        if (data.error_name != null) {
          validafalla(name, data.error_name);
        } else {
          validaOk(name);
        }
        if (data.error_biography != null) {
          validafalla(biography, data.error_biography);
        } else {
          validaOk(biography);
        }

        if (data.message == "Hecho") {
          oldnameValue = nameValue
          oldemailValue = emailValue
          oldgenderValue = genderValue
          oldbiographyValue = bioValue
          oldusernameValue = usernameValue
          // Cambios realizados con exito
          let timerInterval
          Swal.fire({
            html: 'Se realizaron los cambios con exito',
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
          // Error al realizar los cambios
          let timerInterval
          Swal.fire({
            html: 'Error a intentar realizar los cambios',
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
        }
      }
    });
  }


  // Cambiar foto de perfil
  $("#change_profile_pic").click(function () {
    document.getElementById('form__container--file').click()
  })

  $("#form__container--file").change(function () {  
    var formData = new FormData();
    var file = document.getElementById('form__container--file');
    //for (var i = 0; i < file.files.length; i++) {
    // Agrego cada imagen al formData
    formData.append(file.files[0]['name'], file.files[0]);
    //}
    fetch('../api/users/upload_photo.php', {
      method: 'POST',
      body: formData
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        console.log(data)
        // Guardo en un array todas las claves del formData
        keys = [...formData.keys()];
        // Borro todo el contenido del formData
        for (i = 0; i < keys.length; i++) {
          formData.delete(keys[i]);
        }
        if (data.message == "Hecho") {
          console.log(data)
          id_img = (data.action).split(" ").pop();
          var extencion = (file.files[0]['name']).split(".");
          console.log((extencion[1] == "jpg" ? "jpeg" : extencion[1]))
          console.log(extencion)
          $("#user_profile_pic").attr("src", "../../images/profiles/" + id_img + "/profile_pic/" + file.files[0]['name'])
          $("#menu_profile_pic").attr("src", "../../images/profiles/" + id_img + "/profile_pic/" + file.files[0]['name'])
          $("#Cambiarfoto").modal('hide')
          //$("#menu_profile_pic").attr("src", "../../images/profiles/" + file.files[0]['name'])
          let timerInterval
          Swal.fire({
            html: 'Se cambio la foto de perfil con exito',
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
        } else {
          // Error
          let timerInterval
          Swal.fire({
            html: 'Error al cambiar la foto de perfil',
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
      })
  })

  // Eliminar foto de perfil
  $("#delete_profile_pic").click(function () {
    $.ajax({
      url: "../api/users/delete_photo.php",
      dataType: "JSON",
      success: function (data) {
        console.log(data)
        if (data.message == "Hecho") {
          $("#user_profile_pic").attr("src", "../../images/profiles/default.png")
          $("#menu_profile_pic").attr("src", "../../images/profiles/default.png")
          $("#Cambiarfoto").modal('hide')
          let timerInterval
          Swal.fire({
            html: 'Se elimino correctamente la foto de perfil',
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
        } else {
          // Error
          let timerInterval
          Swal.fire({
            html: 'Error al intentar eliminar la foto de perfil',
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
    })
  })
})
