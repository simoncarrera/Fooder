window.addEventListener("load", () => {
  ////////////////////////// Categorias con select2 //////////////////////////
  loadCategories();

  function loadCategories() {
    $.ajax({
      url: "../api/categories/show.php",
      type: "POST",
      data: { for: "post_recipe" },
      dataType: "JSON",
      success: function (data) {
        data_categories = data;
        let categories = data_categories.categories;
        let code_html = "";

        categories.forEach((category) => {
          code_html += `
            <option value="${category.name}" id="category_${category.id}">${category.name}</option>`;
        });
        $("#categories").append(code_html);
        $.fn.select2.defaults.set("language", "es");
        $("#categories").select2({ maximumSelectionSize: 15 });
      },
    });
  }
  ////////////////////////// Categorias con select2 //////////////////////////

  ////////////////////////// Agregar foto //////////////////////////
  $("#selectfile").click(function () {
    $(file).click();
  });

  var file = document.getElementById("file");
  var cant_files = 0;
  var formData = new FormData();

  file.addEventListener("change", function (e) {
    if (cant_files < 4) {
      if (cant_files + file.files.length < 5) {
        // Agrego a la cantidad de archivos que ya hay "subidos", los que quiere subir
        cant_files += file.files.length;

        for (var i = 0; i < file.files.length; i++) {
          // Creo nombre ramdom para cada imagen que "sube"
          var thumbnail_id =
            Math.floor(Math.random() * 30000) + "_" + Date.now();
          createThumbnail(file, i, thumbnail_id);
          // Agrego cada imagen al formData
          formData.append(thumbnail_id, file.files[i]);
        }
        if (cant_files == 4) {
          $("#selectfile").attr("disabled", true);
        }

        e.target.value = "";
      } else {
        // Esta intentando subir mas fotos de las que puede
        message_imgs = "Elige hasta 4 fotos";
      }
    }
  });

  // Mandar a traves de un fetch con un formData, los datos del formulario
  function postRecipe(title, intro = null, ingredients, steps, categories = null) {
    formData.append("title", title);
    formData.append("introduction", intro);
    formData.append("ingredients", ingredients);
    formData.append("steps", steps);
    formData.append(`categories`, JSON.stringify(categories));

    fetch("../api/recipes/post.php", {
      method: "POST",
      body: formData,
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (data) {
        console.log(data);
        setTimeout(() => {
          $(`#publish`).html(`Publicar`);

          if (data.message == "Se publico correctamente la receta") {
            clearFormDataAndThumbnails();
            let timerInterval;
            Swal.fire({
              html: "Receta publicada con exito",
              timer: 1200,
              timerProgressBar: false,
              position: "bottom-start",
              showConfirmButton: false,
              width: "auto",
              padding: "2px",
              grow: "row",
              backdrop: true,
              toast: true,
              allowOutsideClick: false,
              allowEscapeKey: false,
              stopKeydownPropagation: false,
              background: "#fdb801",
              color: "#ffffff",
              willClose: () => {
                clearInterval(timerInterval);
              },
            }).then((result) => {
              /* Read more about handling dismissals below */
              if (result.dismiss === Swal.DismissReason.timer) {
                window.location.href = "../web/home.php";
              }
            });
          } else {
            // Este alert es temporal
            let timerInterval;
            Swal.fire({
              html: (typeof data.message_img != 'undefined') ? data.message_img : 'Error al publicar receta',
              timer: 1200,
              timerProgressBar: false,
              position: "bottom-start",
              showConfirmButton: false,
              width: "auto",
              padding: "2px",
              grow: "row",
              backdrop: true,
              toast: true,
              allowOutsideClick: false,
              allowEscapeKey: false,
              stopKeydownPropagation: false,
              background: "#fdb801",
              color: "#ffffff",
              willClose: () => {
                clearInterval(timerInterval);
              },
            });
          }
        }, "500");
      })
      .catch(function (err) {
        console.log(err);
      });
  }

  // Crear un div donde se muestra las imagenes que agrega el user a traves de un blob
  var createThumbnail = function (file, iterator, thumbnail_id) {
    var thumbnail = document.createElement("div");
    thumbnail.classList.add("thumbnail", thumbnail_id);
    thumbnail.dataset.id = thumbnail_id;

    thumbnail.setAttribute(
      "style",
      `background-image: url(${URL.createObjectURL(file.files[iterator])})`
    );
    document.getElementById("preview-images").appendChild(thumbnail);
    createCloseButton(thumbnail_id);
  };

  // Crear boton para cerrar cada imagen
  var createCloseButton = function (thumbnail_id) {
    var closeButton = document.createElement("div");
    closeButton.classList.add("close-button");
    closeButton.innerHTML = '<i class="bi bi-x"></i>';
    document.getElementsByClassName(thumbnail_id)[0].appendChild(closeButton);
  };

  var clearFormDataAndThumbnails = function () {
    // Guardo en un array todas las claves del formData
    keys = [...formData.keys()];
    // Borro todo el contenido del formData
    for (i = 0; i < keys.length; i++) {
      formData.delete(keys[i]);
    }

    $("#selectfile").attr("disabled", false);
    cant_files = 0;
    form.reset();

    // Dejo de mostrar las imagenes
    document.querySelectorAll(".thumbnail").forEach(function (thumbnail) {
      thumbnail.remove();
    });

    // Mostrar aviso que diga que se publico correctamente la receta y darle dos opciones, ir a su perfil (para verla) y seguir publicando
  };

  document.body.addEventListener("click", function (e) {
    // e = evento que ocurre
    // e.target = el elemento al cual le pasa el evento
    // parentNode = al padre del elemento
    if (e.target.classList.contains("bi-x")) {
      e.target.parentNode.parentNode.remove();
      formData.delete(e.target.parentNode.parentNode.dataset.id);
      if (cant_files == 4) {
        $("#selectfile").attr("disabled", false);
      }
      cant_files--;
    }
  });

  ////////////////////////// Termina agregar foto //////////////////////////

  ////////////////////////// Validaciones //////////////////////////

  const form = document.getElementById("form");
  const title = document.getElementById("title");
  const intro = document.getElementById("intro");
  const ingredients = document.getElementById("ingredients");
  const steps = document.getElementById("steps");

  form.addEventListener("submit", (e) => {
    e.preventDefault();
    validaRango();
  });

  const validaRango = () => {
    const titlevalue = title.value.trim();
    const ingredientsvalue = ingredients.value.trim();
    const introvalue = intro.value.trim();
    const stepsvalue = steps.value.trim();
    let categoriesvalue = [];

    $("#categories")
      .children(":selected")
      .each((key, category_selected) => {
        //categoriesvalue[category_selected.id] = [category_selected.value]
        categoriesvalue.push({
          id: category_selected.id.split("_").pop(),
          name: category_selected.value,
        });
      });
    habilitar = 0;

    //revisa los ingredientes
    if (!ingredientsvalue) {
      fail(ingredients, "Ingrese los ingredientes");
    } else if (ingredientsvalue.length > 500) {
      fail(ingredients, "Demasiado largo");
    } else {
      success(ingredients);
      habilitar++;
    }
    //revisa el titulo
    if (!titlevalue) {
      fail(title, "Ingrese un titulo");
    } else if (titlevalue.length > 75) {
      fail(title, "El titulo debe ser más pequeño");
    } else {
      success(title);
      habilitar++;
    }
    //revisa la introducción

    if (introvalue.length > 250) {
      fail(intro, "La introducción debe ser menor");
    } else {
      success(intro);
      habilitar++;
    }
    //revisa los pasos
    if (!stepsvalue) {
      fail(steps, "Ingrese los pasos a seguir");
    } else if (stepsvalue.length > 2000) {
      fail(steps, "Ingrese pasos más cortos");
    } else {
      success(steps);
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
				</svg>`);
      // Llamo a funcion para publicar receta
      postRecipe(titlevalue, introvalue, ingredientsvalue, stepsvalue, categoriesvalue);
    }
  };
  const fail = (textarea, msj) => {
    const form = textarea.parentElement;
    const warning = form.querySelector("p");
    warning.innerText = msj;
    form.classList = "form__container--content fail";
  };
  const success = (textarea, msj) => {
    const form = textarea.parentElement;
    const warning = form.querySelector("p");
    form.classList = "form__container--content success";
  };
  ////////////////////////// Terminan las validaciones //////////////////////////
});
