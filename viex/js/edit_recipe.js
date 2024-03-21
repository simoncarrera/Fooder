var file = document.getElementById('file');
var cant_files = 0;
var aux = 0;
var formData = new FormData();

var rutaAbsoluta = location.href;
var id = rutaAbsoluta.split("=").pop();

getImgs();

function getImgs() {
  $.ajax({
    url: '../api/recipes/has_imgs.php?id=' + id,
    dataType: 'JSON',
    success: function (data) {
      if (data) {
        var keys = Object.keys(data)
        for (i = 0; i < keys.length; i++) {
          createThumbnail(data[keys[i]], i, data[keys[i]], 'img_server');
          cant_files++;
        }
        if (cant_files == 4) {
          $("#selectfile").attr("disabled", true);
        }
      }
    }
  });
}

////////////////////////// Categorias con select2 //////////////////////////
loadCategories()

function loadCategories() {
  $.ajax({
    url: '../api/categories/show.php',
    type: 'POST',
    data: { for: 'edit_recipe', recipe_id: id},
    dataType: 'JSON',
    success: function (data) {
      console.log(data)
      data_categories = data
      let categories = data_categories.categories
      let recipe_categories = data_categories.recipe_categories
      let code_html = ''

      categories.forEach(category => {
        code_html += `
            <option value="${category.name}" id="category_${category.id}" `
        recipe_categories.forEach(recipe_category => {
          if (category.id == recipe_category.id) {
            code_html += `selected`
          }
        })
        code_html += `>${category.name}</option>`
      });
      $('#categories').append(code_html)
      //Agrego funcion selec2
      $.fn.select2.defaults.set('language', 'es')
      $('#categories').select2({ maximumSelectionSize: 15 })
    }
  });
}
  ////////////////////////// Categorias con select2 //////////////////////////


$("#selectfile").click(function () {
  $(file).click();
});

file.addEventListener('change', function (e) {
  if (cant_files < 4) {
    if (cant_files + file.files.length < 5) {
      // Agrego a la cantidad de archivos que ya hay "subidos", los que quiere subir
      cant_files += file.files.length;

      for (var i = 0; i < file.files.length; i++) {
        // Creo nombre ramdom para cada imagen que "sube"
        var thumbnail_id = Math.floor(Math.random() * 30000) + '_' + Date.now();
        createThumbnail(file, i, thumbnail_id);
        // Agrego cada imagen al formData
        formData.append(thumbnail_id, file.files[i]);

      }
      if (cant_files == 4) {
        $("#selectfile").attr("disabled", true);
      }

      e.target.value = '';
    } else {
      // Esta intentando subir mas fotos de las que puede
      message_imgs = "Elige hasta 4 fotos"
    }

  }

});

// Mandar a traves de un fetch con un formData, los datos del formulario
function editRecipe(title, intro = null, ingredients, steps, categories = null) {
  formData.append('title', title);
  formData.append('introduction', intro);
  formData.append('ingredients', ingredients);
  formData.append('steps', steps);
  formData.append(`categories`, JSON.stringify(categories));
  formData.append('id', id);

  fetch('../api/recipes/edit.php', {
    method: 'POST',
    body: formData
  })
    .then(function (response) {
      return response.json();
    })
    .then(function (data) {
      console.log(data);
      setTimeout(() => {
        $(`#publish`).html(`Publicar`)
        
        if (data.message == 'Se actualizó correctamente la receta') {
          let timerInterval
          Swal.fire({
            html: 'Receta editada con exito',
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
              clearImgToRemoveAndThumbnails();
            }
          })
         
        } else {
          // Este alert es temporal
          console.log(data.message + " " + data.message_img)
          let timerInterval
          Swal.fire({
            html: 'Error al editar receta ',
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
      }, "500")

    })
    .catch(function (err) {
      console.log(err);
    });
}

var createThumbnail = function (file_or_img_server, iterator = '', thumbnail_id, type = 'file') {
  var thumbnail = document.createElement('div');
  thumbnail.classList.add('thumbnail', thumbnail_id, type);
  thumbnail.dataset.id = thumbnail_id

  thumbnail.setAttribute('style', `background-image: url(${(type != 'file') ? `../../images/recipes/${id}/${file_or_img_server}` : URL.createObjectURL(file_or_img_server.files[iterator])})`);
  document.getElementById('preview-images').appendChild(thumbnail);
  createCloseButton(thumbnail_id);
}

// Crear boton para cerrar cada imagen
var createCloseButton = function (thumbnail_id) {
  var closeButton = document.createElement('div');
  closeButton.classList.add('close-button');
  closeButton.innerHTML = '<i class="bi bi-x"></i>';
  document.getElementsByClassName(thumbnail_id)[0].appendChild(closeButton);
}

var clearImgToRemoveAndThumbnails = function () {
  // Guardo en un array todas las claves del formData
  keys = [...formData.keys()];
  // Borro todo el contenido del formData
  for (i = 0; i < keys.length; i++) {
    if (keys[i] != 'title' && keys[i] != 'introduction' && keys[i] != 'ingredients' && keys[i] != 'steps' && keys[i] != 'id') {
      formData.delete(keys[i]);
    }
  }

  $("#selectfile").attr("disabled", false);
  aux = 0;
  form.reset();
  // Dejo de mostrar las imagenes
  document.querySelectorAll('.thumbnail').forEach(function (thumbnail) {
    thumbnail.remove();
  });

  cant_files = 0;
  getImgs();
  // Mostrar aviso que diga que se actualizó correctamente la receta y darle dos opciones, ir a su perfil (para verla) y seguir editando
}

document.body.addEventListener('click', function (e) {
  // e = evento que ocurre
  // e.target = el elemento al cual le pasa el evento  
  // parentNode = al padre del elemento
  if (e.target.classList.contains('bi-x')) {
    e.target.parentNode.parentNode.remove();
    // El dataset.id tiene el valor del respectivo thumbnail_id
    if (e.target.parentNode.parentNode.classList.contains('img_server')) {
      // Las imagenes que ya estaban en la receta, si son agregadas al formData, significa que el usuario las quiere eliminar
      formData.append(`imgs_to_remove[${aux}]`, e.target.parentNode.parentNode.dataset.id);
      aux++;
    } else {
      formData.delete(e.target.parentNode.parentNode.dataset.id);
    }

    if (cant_files == 4) {
      $("#selectfile").attr("disabled", false);
    }
    cant_files--;
  }
});




window.addEventListener('load', () => {
  const form = document.getElementById('form')
  const title = document.getElementById('title')
  const intro = document.getElementById('intro')
  const steps = document.getElementById('steps')
  const ingredients = document.getElementById('ingredients')

  form.addEventListener('submit', (e) => {
    e.preventDefault()
    validarango()
  })

  const validarango = () => {
    const titlevalue = title.value.trim()
    const ingredientsvalue = ingredients.value.trim()
    const introvalue = intro.value.trim()
    const stepsvalue = steps.value.trim()
    let categoriesvalue = []

    $("#categories").children(":selected").each((key, category_selected) => {
      //categoriesvalue[category_selected.id] = [category_selected.value]
      categoriesvalue.push({
        id: category_selected.id.split("_").pop(),
        name: category_selected.value
      })
    })
    habilitar = 0;

    //revisa los ingredientes
    if (!ingredientsvalue) {
      falla(ingredients, 'Ingrese los ingredientes sin caracteres especiales')
    } else if (ingredientsvalue.length > 500) {
      falla(ingredients, 'Demasiado largo')
    } else {
      ok(ingredients)
      habilitar++;
    }
    //revisa el titulo
    if (!titlevalue) {
      falla(title, 'Ingrese un titulo sin caracteres especiales')
    } else if (titlevalue.length > 75) {
      falla(title, 'El titulo debe ser más pequeño')
    } else {
      ok(title)
      habilitar++;
    }

    //revisa la introducción
    if (introvalue.length > 250) {
      falla(intro, 'La introducción debe ser menor')
    } else {
      ok(intro)
      habilitar++;
    }

    //revisa los pasos
    if (!stepsvalue) {
      falla(steps, 'Ingrese los pasos a seguir sin caracteres especiales')
    } else if (stepsvalue.length > 2000) {
      falla(steps, 'Ingrese pasos más cortos')
    } else {
      ok(steps)
      habilitar++;
    }

    if (habilitar == 4) {
      // Animacion de preload
      $(`#publish`).html(`
        <svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="52px" height="13px" viewBox="0 0 128 32" xml:space="preserve" style="&#10;">
          <circle fill="#ffffff" cx="0" cy="0" r="11" transform="translate(16 16)">
            <animateTransform attributeName="transform" type="scale" additive="sum" values="1;1.42;1;1;1;1;1;1;1;1" dur="1350ms" repeatCount="indefinite"/></circle>
          <circle fill="#ffffff" cx="0" cy="0" r="11" transform="translate(64 16)">
            <animateTransform attributeName="transform" type="scale" additive="sum" values="1;1;1;1;1.42;1;1;1;1;1" dur="1350ms" repeatCount="indefinite"/></circle>
          <circle fill="#ffffff" cx="0" cy="0" r="11" transform="translate(112 16)">
            <animateTransform attributeName="transform" type="scale" additive="sum" values="1;1;1;1;1;1;1;1.42;1;1" dur="1350ms" repeatCount="indefinite"/>
          </circle>
        </svg>`)
      
      // Llamo a funcion para editar receta
      editRecipe(titlevalue, introvalue, ingredientsvalue, stepsvalue, categoriesvalue);
    }
  }

  const falla = (textarea, msj) => {
    const form = textarea.parentElement
    const warning = form.querySelector('p')
    warning.innerText = msj
    form.classList = 'form__container--content fail'
  }
  const ok = (textarea, msj) => {
    const form = textarea.parentElement
    const warning = form.querySelector('p')
    form.classList = 'form__container--content success'
  }
})