// Conseguir la pagina en la que se encuentra
var rutaRelativa = location.href.split("/").pop();

// Pintar de negro la pagina en la que estas (si esta se encuentra en la navbar)
if (rutaRelativa == "home.php") {
  document.getElementById("home").classList = 'bi bi-house-door-fill px-2'
} else if (rutaRelativa == "recipes_followed.php") {
  document.getElementById("recipes_followed").classList = 'bi bi-people-fill px-2'
} else if (rutaRelativa == "post_recipe.php") {
  document.getElementById("post_recipe").classList = 'bi bi-plus-circle-fill px-2'
}


$(document).ready(function () {

  /// MODO OSCURO //*
  const setTheme = (theme) => {
    document.documentElement.setAttribute("data-theme", theme)
    localStorage.setItem('theme', theme)

    if (theme == 'dark') {
      document.getElementById("dark_mode_switch").checked = true
    }
  }
  
  $("#dark_mode_switch").click(function () {
    let switchToTheme = (localStorage.getItem('theme') == 'dark') ? 'light' : 'dark';
    setTheme(switchToTheme)
  })
  
  setTheme(localStorage.getItem('theme') || 'light')
  /// TERMINA MODO OSCURO ////

  // Dropdowns de toda la pagina
  $("body").on("click", ".dropbtn", function () {
    var dropdown_id = this.id.split("_")[1];
    //document.getElementById(`dropdown_${dropdown_id}`).classList.toggle("show");
    $(`#dropdown_${dropdown_id}`).toggle("fast")
  })

  // Close the dropdown menu if the user clicks outside of it
  window.onclick = function (event) {
    if (!event.target.matches("#principal__seeker--search")) {
      $("#principal__seeker").removeClass("suggestions")
      $("#search_suggestions").removeClass("d-block")
    }

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;

    if (event.target.parentNode.matches(".dropbtn") || event.target.matches(".dropbtn") || event.target.parentNode.matches(".dropdown-content") || event.target.parentNode.parentNode.matches(".dropdown-content")) {
      if (event.target.parentNode.matches(".dropbtn")) {
        var dropdown_id = event.target.parentNode.id.split("_").pop()

      } else if (event.target.matches(".dropbtn")) {
        var dropdown_id = event.target.id.split("_").pop()

      } else if (event.target.parentNode.parentNode.matches(".dropdown-content")) {
        var dropdown_id = event.target.parentNode.parentNode.id.split("_").pop()

      } else {
        var dropdown_id = event.target.parentNode.id.split("_").pop()
      }
      var dropdown_selected = $(`#dropdown_${dropdown_id}`)[0]
    }

    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if ($(openDropdown).css("display") == "block") {
        if (dropdown_selected != openDropdown) {
          $(openDropdown).toggle("fast")
        }
      }
    }


    // Verifico si esta baneado
    $.ajax({
      url: "../api/users/is_banned.php",
      dataType: "JSON",
      success: function (data) {
        if (data.message == "Error") {
          // Se encuentra baneado
          let timerInterval
          Swal.fire({
            html: 'Actualmente te encuentras baneado, para más información, revisa tu correo',
            timer: 1500,
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
            // Read more about handling dismissals below 
            if (result.dismiss === Swal.DismissReason.timer) {
              window.location.href = "../web/login.php";
            }
          })

        }
      }
    })
  };

  //Boton scroll-up
  document.getElementById("scroll-up").addEventListener("click", scrollUp);

  function scrollUp() {
    var currentScroll = document.documentElement.scrollTop || document.body.scrollTop;

    if (currentScroll > 0) {
      window.requestAnimationFrame(scrollUp);
      window.scrollTo(0, currentScroll - (currentScroll / 7))
    }
  }

  window.onscroll = function () {
    var scroll = document.documentElement.scrollTop;

    if (scroll > 500) {
      document.getElementById("scroll-up").style.transform = "scale(1)";
    } else if (scroll < 500) {
      document.getElementById("scroll-up").style.transform = "scale(0)";
    }
  }



  // Barra de busqueda
  $(document).on('keyup', '#principal__seeker--search', function () {
    let search = $(this).val()
    if (search != "" && search.length > 0) {
      $("#search_suggestions-recipes").empty()
      $("#search_suggestions-categories").empty()
      $("#search_suggestions-accounts").empty()
      $("#suggestions_not-found").remove()
      $("#principal__seeker").addClass("suggestions")
      $("#search_suggestions").addClass("d-block")
      searchData(search)
    }
  })

  function searchData(search) {
    $.ajax({
      url: "../api/search_suggestions.php",
      type: "POST",
      data: { search: search },
      dataType: "JSON",
      success: function (data) {

        let data_recipes = data.recipes
        let code_html_recipes = ''
        let data_categories = data.categories
        let code_html_categories = ''
        let data_accounts = data.accounts
        let code_html_accounts = ''

        if (data_recipes.length > 0) {
          code_html_recipes += `<h6>Recetas</h6>`;
          data_recipes.forEach(recipe => {
            code_html_recipes += `<div><a href="../web/publication.php?id=${recipe.id}" >${recipe.title}</a></div>`
          });
        }

        if (data_categories.length > 0) {
          code_html_categories += `<h6>Categorías</h6>`;
          data_categories.forEach(category => {
            code_html_categories += `<div><a href="../web/searches.php?search=${category.name}&filter=categories" >${category.name}</a></div>`
          });
        }

        if (data_accounts.length > 0) {
          code_html_accounts += `<h6>Cuentas</h6>`;
          data_accounts.forEach(account => {
            code_html_accounts += `<div><a href="../web/profile.php?id=${account.id}" >${account.username}</a></div>`
          });
        }

        if (code_html_recipes == "" && code_html_categories == "" && code_html_accounts == "") {
          $(".container__suggestions--recipes").addClass("d-none")
          $(".container__suggestions--categories").addClass("d-none")
          $(".container__suggestions--accounts").addClass("d-none")

          if (typeof $("#suggestions_not-found")[0] == 'undefined') {
            $("#search_suggestions").append(`<div id="suggestions_not-found">No se encontro ningún resultado para esa busqueda</div>`)
          }
        } else {
          $(".container__suggestions--recipes").removeClass("d-none")
          $(".container__suggestions--categories").removeClass("d-none")
          $(".container__suggestions--accounts").removeClass("d-none")

          $("#search_suggestions-recipes").append(code_html_recipes);
          $("#search_suggestions-categories").append(code_html_categories);
          $("#search_suggestions-accounts").append(code_html_accounts);
        }
      }
    })
  }

  // Copiar link de receta
  $('#container__recipes').on('click', '.link_recipe', function () {
    let recipe_id = this.id.split("_").pop()
    var copyText = document.getElementById(`TextoACopiar_${recipe_id}`);
    copyText.select();
    copyText.setSelectionRange(0, 99999);
    /* navigator.clipboard.writeText(copyText.value); */
    try {
      var retVal = document.execCommand("copy");
      console.log('Copiado en el portapapeles ' + copyText.value);
      let timerInterval
      Swal.fire({
        html: 'Link copiado en el portapapeles',
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
    } catch (err) {
      console.log('Error mientras se copiaba al portapapeles: ' + err);
      let timerInterval
      Swal.fire({
        html: 'Error al copiar el link',
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