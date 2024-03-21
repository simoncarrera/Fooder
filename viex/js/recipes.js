var num_page = 1;
var recipes;
var rutaRelativa = location.href.split("/").pop();
var forWhat = rutaRelativa.split(".")[0];

if (forWhat == "profile") {
	var profile_id = rutaRelativa.split("=")[1];
} else if (forWhat == "searches") {
	// Consigo el valor de lo que quiere buscar y su filtro
	var search = $("#principal__seeker--search").val();
	var filter = rutaRelativa.includes("&filter=")
		? rutaRelativa.split("&filter=").pop()
		: "titles";

	// Cambio href de los botones del submenu (le agrego el filtro)
	$("#item__submenu--recipes").attr(
		"href",
		`../web/searches.php?search=${search}&filter=${filter}`
	);

	// Cambio el valor "seleccionado" del dropdown dependiendo del valor del filtro
	if (filter == "titles") {
		$("#item_actual").html("Títulos");
	} else if (filter == "categories") {
		$("#item_actual").html("Categorías");
	} else {
		$("#item_actual").html("Ingredientes");
	}

	$("#principal__seeker").submit(function (event) {
		event.preventDefault();

		// Reestablesco valores del numero de paginas y vacio al contenedor
		num_page = 1;
		$("#container__recipes").html("");

		// Nuevo valor de busqueda
		search = $("#principal__seeker--search").val();

		// Cambio parametros de la url
		window.history.pushState(null, "", `?search=${search}&filter=${filter}`);

		// Cambio href de los botones del submenu (le agrego la nueva busqueda)
		$("#item__submenu--accounts").attr(
			"href",
			`../web/searches.php?search=${search}&for=user`
		);
		$("#item__submenu--recipes").attr(
			"href",
			`../web/searches.php?search=${search}&filter=${filter}`
		);

		loadRecipes();
	});

	$(".dropdown-item").click(function () {
		// Reestablesco valores del numero de paginas y vacio al contenedor
		num_page = 1;
		$("#container__recipes").html("");

		// Consigo el valor por el cual quiere buscar, o sea, lo que selecciona en el dropdown
		item = $(this).html();
		// Cambio el valor "seleccionado" del dropdown y coloco el elegido por el user
		$("#item_actual").html(item);

		// Cambio parametros del URL dependiendo del item
		if (item == "Títulos") {
			window.history.pushState(null, null, `?search=${search}&filter=titles`);
			filter = "titles";
		} else if (item == "Categorías") {
			window.history.pushState(
				null,
				null,
				`?search=${search}&filter=categories`
			);
			filter = "categories";
		} else {
			window.history.pushState(
				null,
				null,
				`?search=${search}&filter=ingredients`
			);
			filter = "ingredients";
		}

		// Cambio href de los botones del submenu (le agrego el nuevo filtro)
		$("#item__submenu--recipes").attr(
			"href",
			`../web/searches.php?search=${search}&filter=${filter}`
		);

		loadRecipes();
	});
}

loadRecipes();

$(window).on("scroll", function () {
	var scrollHeight = $(document).height();
	var scrollPosition = $(window).height() + $(window).scrollTop();
	if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
		if (data_recipes.amt_recipes_page >= num_page) {
			loadRecipes();
		}
	}
});

var data_recipes;
function loadRecipes() {
	$.ajax({
		url: `../api/recipes/show.php`,
		type: "POST",
		data: {
			page: num_page,
			for: forWhat,
			search: search,
			profile_id: profile_id,
			filter_for: filter,
		},
		dataType: "JSON",
		beforeSend: function () {
			var icon_html = `<svg id="preload_recipes" class="w-100 " style="margin: 7px auto 0 auto;" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="20px" height="20px" viewBox="0 0 128 128" xml:space="preserve"><g><linearGradient id="linear-gradient"><stop offset="0%" stop-color="#ffffff"/><stop offset="100%" stop-color="#000000"/></linearGradient><path d="M63.85 0A63.85 63.85 0 1 1 0 63.85 63.85 63.85 0 0 1 63.85 0zm.65 19.5a44 44 0 1 1-44 44 44 44 0 0 1 44-44z" fill="url(#linear-gradient)" fill-rule="evenodd"/><animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64" dur="1080ms" repeatCount="indefinite"/></g></svg>`;
			$("#container__recipes").append(icon_html);
		},
		success: function (data) {
			setTimeout(function () {
				$("#preload_recipes").remove();
				data_recipes = data;
				recipes = data_recipes.recipes;
				let code_html = "";
				console.log(data);

				if (typeof search != "undefined") {
					code_html += `<p class="resultmessage">${
						data_recipes.amt_total_reg
					} Resultados para la busqueda "${search}" filtrada por ${$(
						"#item_actual"
					)
						.html()
						.toLowerCase()}</p>`;
				}

				recipes.forEach((recipe) => {
					var profile_extencion = (recipe.profile_pic).split(".");
          //../../imagenes/profiles/profile_pic/miniprofile_image.${profile_extencion[5]}
          var a = (recipe.profile_pic).split("/")
          code_html += `
          <div class="container-v3 recipe" id="recipe_${recipe.id}">
            <div class="container__user">
              <div>`

              if(a[4] == "default.png"){
                code_html +=`
                <a class="container__user--profilepicture" href="profile.php?id=${recipe.user_id}">
                  <img src="${recipe.profile_pic}" alt="foto perfil">
                </a>`
              }else{
                code_html += `
                <a class="container__user--profilepicture" href="profile.php?id=${recipe.user_id}">
                  <img src="../../images/profiles/${recipe.user_id}/profile_pic/profile_image.${profile_extencion[5]}" alt="foto perfil">
                </a>`
              }
              code_html +=
              `</div>
              <div class="container__user--name-date">
                <div class="container__user--username">
                  <a href="profile.php?id=${recipe.user_id}">${recipe.username}</a>
                </div>
                <div class="container__user--separator">
                  <span>•</span>
                </div>
                <div class="container__user--date">
                  <span for="dateUp">
                    ${recipe.created_at}
                  </span>
                </div>

              </div>`;
					if (
						data_recipes.user_logged_id != null &&
						data_recipes.user_logged_id == recipe.user_id
					) {
						code_html += `
              <div class="dropdown ps-2 ms-auto">
                <button class="btn p-0 dropbtn" id="btn_delete-edit-${recipe.id}"><i class="bi bi-three-dots"></i></button>
                <div id="dropdown_delete-edit-${recipe.id}" class="dropdown-content" style="right: -10px; top: 32px;">
                  <a class="dropdown-content__edit" href="../web/edit_recipe.php?id=${recipe.id}"><i class="bi bi-pencil-square"></i> Editar</a>
                  <a class="dropdown-content__delete" id="${recipe.id}" role="button" data-bs-toggle="modal" data-bs-target="#exampleModal_${recipe.id}"><i class="bi bi-trash3"></i> Eliminar</a>
                </div>
              </div>
              
              <div class="modal fade" id="exampleModal_${recipe.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">¿Seguro que quieres eliminar la receta?</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Una vez eliminada la receta no podras volver a recuperarla.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary button-modal" data-bs-dismiss="modal">Cancelar</button>
                      <a role="button" id="${recipe.id}" class="btn btn-warning button-modal recipe_delete" data-bs-dismiss="modal">Confirmar</a>
                    </div>
                  </div>
                </div>
              </div>`;
					}
					code_html += `
            </div>
            
            <div class="container__recipe">

              <div class="container__recipe--title">
                  <h5>${recipe.title}</h5>
              </div>`;

					if (recipe.recipe_imgs != null) {
						code_html += `
              <div class="container__all-imgs">`;
						recipe.recipe_imgs.forEach((value) => {
							code_html += `
                  <div class="container__img-recipe">
                    <img class="recipe__img-item" src="../../images/recipes/${recipe.id}/${value}" alt="foto receta">
                  </div>`;
						});
						code_html += `
              </div>`;
					}

					code_html += `<div class="container__recipe--content">`;

					if (recipe.introduction != "") {
						code_html += `
                <div class="container__recipe--introduction">
                  <span>${recipe.introduction}</span>
                </div>`;
					}

					code_html += `<div class="container__recipe--ingredients">
                  <h6>Ingredientes</h6>
                  <span>${recipe.ingredients}</span>
                </div>
              </div>

              <div class="container__recipe--see-more">
                <a href="publication.php?id=${recipe.id}" class="btn">Ver más</a>
              </div>
            </div>

            <div class="container__feedback">

              <div class="container__likes-comments">`;

					if (data_recipes.user_logged_id == null) {
						code_html += `
                <!-- No esta logueado -->
                <div class="container__feedback--likes">
                  <a class="btn" id="${recipe.id}" href="login.php" role="button">
                    <i class="bi bi-heart"></i>
                    <!--<img src="../../images/icons/nolike.png" width="22px" alt="likes_icon">-->
                    <span>${recipe.cant_likes}</span>
                  </a>
                </div>`;
					} else {
						code_html += `
                <!--- Verificar si le dio o no like    -->
                <div class="container__feedback--likes ">
                  <a class="btn recipe_like" id="${recipe.id}" role="button">
                    <i id="recipe_img_${recipe.id}" class="bi bi-heart${recipe.verify_like == null ? "" : "-fill"}"></i>
                    <!--<img  src="../../images/icons/${recipe.verify_like == null ? "nolike" : "like"}.png" width="22px" alt="likes_icon">-->
                    <span id="recipe_likes_${recipe.id}">${recipe.cant_likes}</span>
                  </a>
                </div>`;
					}

					code_html += `
                  <div class="container__feedback--comments">
                      <a class="btn" href="publication.php?id=${recipe.id}#link-comment" role="button">
                        <i class="bi bi-chat"></i>
                        <!--<img src="../../images/icons/comments.png" width="22px" alt="comments_icon">-->
                        <span>${recipe.cant_comments}</span>
                      </a>
                    </div>
                    <div class="container__feedback--share">
                      <a class="btn" data-bs-toggle="modal" data-bs-target="#share_recipe_${recipe.id}" href="#" role="button">
                        <i class="bi bi-share"></i>
                        <!--<img src="../../images/icons/share.png" width="22px" alt="share_icon">--> 
                      </a>
                    </div>
                  </div>

                <!-- Modal compartir-->
                <div class="modal fade" id="share_recipe_${recipe.id}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Compartir receta en tus redes sociales</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
                      </div>
                      <div class="modal-body">
                        <div class="container_pages_share">
                          <div class="container_whatsapp">
                            <a href="https://api.whatsapp.com/send?text=http://localhost/22-4.10-proyectos/viex/controllers/web/publication.php?id=${recipe.id}" target="_blank" ><i class="bi bi-whatsapp "></i> <span>WhatsApp</span></a>
                            
                          </div>
                          <div class="container_twitter">
                            <a href="https://twitter.com/intent/tweet?text=${recipe.title}&url=http://localhost/22-4.10-proyectos/viex/controllers/web/publication.php?id=${recipe.id}&via=Fooder&hashtags=#Comida" target="_blank"><i class="bi bi-twitter"></i>Twitter</a>
                            
                          </div>
                          <div class="container_facebook">
                            <a href="http://www.facebook.com/sharer.php?u=http://localhost/22-4.10-proyectos/viex/controllers/web/publication.php?id=${recipe.id}" target="_blank"><i class="bi bi-facebook"></i> Facebook</a> 
                            
                          </div>
                          <div class="container_link-recipe">
                            <input type="text" value="http://localhost/22-4.10-proyectos/viex/controllers/web/publication.php?id=${recipe.id}" id="TextoACopiar_${recipe.id}" style="position: absolute; left: -9999px;">
                            <button id="BotonCopiar_${recipe.id}" class="btn link_recipe" >
                              <i class="bi bi-link-45deg"></i>
                              <p class="m-0" style="font-weight: 400;">Copiar link</p>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>`;

					if (data_recipes.user_logged_id != null) {
						if (data_recipes.user_logged_id != recipe.user_id) {
							code_html += `
                  <div class="container__feedback--report">
                    <a class="btn" data-bs-toggle="modal" data-bs-target="#modal-report-recipe_${recipe.id}"><i class="bi bi-flag"></i></a>           
                  </div>
                  
                  <div id="modal-report-recipe_${recipe.id}" class="modal fade form-report" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <form method="POST" id="form-report-recipe_${recipe.id}" class="modal-report-recipes">
                        <div class="modal-header">
                          <h5 class="modal-title" >Denunciar receta</h5>
                          <button class="btn-close" type="reset" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></button>
                        </div>
                        <div class="modal-body">
                          <div class="radio">
                              <input type="radio" name="rep_why" id="cont_sex" value="cont_sex" checked>
                              <label for="cont_sex">Contenido sexual</label><br>
                              <input type="radio" name="rep_why" id="abus_men" value="abus_men">
                              <label for="abus_men">Abuso de menores</label><br>
                              <input type="radio" name="rep_why" id="fomen_terr" value="fomen_terr">
                              <label for="fomen_terr">Fomenta el terrorismo</label><br>
                              <input type="radio" name="rep_why" id="cont_copi" value="cont_copi">
                              <label for="cont_copi">Contenido plagiado</label><br>
                              <input type="radio" name="rep_why" id="inf_err" value="inf_err">
                              <label for="inf_err">Informacion errónea</label><br>
                              <input type="radio" name="rep_why" id="cont_ofens" value="cont_ofens">
                              <label for="cont_ofens">Contenido ofensivo</label><br>
                              <textarea id="recipe-report-description_${recipe.id}" required cols="30" rows="10" class="form-control modal_form_textarea" placeholder="Agregar descripcion especifica de la infraccion" maxlength="500"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                          <div class="container-buttons">
                              <button class="btn" type="reset" data-bs-dismiss="modal">Cancelar</button>
                          </div>
                          
                          <div class="container-buttons">
                              <button id="btn_submit_report" class="btn" type="submit" >Siguiente</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                `;
						}
					} else {
						code_html += `
                  <div class="container__feedback--report">
                    <a class='btn' href="../web/login.php" role="button"><i class="bi bi-flag"></i></a>
                  </div>`;
					}

					code_html += `
            </div>
          </div>`;
				});

				$("#container__recipes").append(code_html);
				num_page++;
			}, 250);
		},
	});
}
