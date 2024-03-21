let num_page = 1;
//let num_page_reports = 1;
let data_recipes_reported;

loadRecipesReported();

$(window).on("scroll", function () {
	var scrollHeight = $(document).height();
	var scrollPosition = $(window).height() + $(window).scrollTop();
	if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
		if (data_recipes_reported.amt_recipes_page >= num_page) {
			loadRecipesReported();
		}
	}
});

$(document).ready(function () {
	$("#container__specific").on("click", ".recipe_reports", function () {
		var id = this.id.split("_").pop();
		if (typeof $(`#modalReportsRecipes_${id}`)[0] == "undefined") {
			loadReportsRecipes(id);
		}

		if (!document.getElementById(`modalReportsRecipes_${id}`).classList.contains("show")) {
			$(`#modalReportsRecipes_${id}`).modal("show");
		}
	});

	$("#container__specific").on("click", ".btn_see-more", function () {
		let recipe_id = this.id.split("_")[1];
		document.getElementById(`container-steps_${recipe_id}`).classList.toggle("d-none");

		if (this.innerText == "Ver más") {
			this.innerText = "Ver menos";
		} else {
			this.innerText = "Ver más";
		}
	});

	$("#container__specific").on("click", ".btn-close-modal-reports", function () {
		if (this.dataset.closeType == "btn-x") {
			// Boton de x, cierro todo el modal
			$(this).modal("hide");
			var modal = this.parentNode.parentNode.parentNode.parentNode;
			num_page_reports = 1;
		} else {
			// Cancelar (cierro el modal-footer)
			var modal = this.parentNode.parentNode.parentNode;
		}
		$(modal).remove();
	}
	);

	$("#container__specific").on("click", ".report-discard-ban", function () {
		if (typeof $(`.modal-footer`)[0] != "undefined") {
			$(`.modal-footer`).remove();
		}

		let id = this.id.split("_").pop();
		let code_html = `
			<div class="modal-footer modal-footer-reports" id="modal-footer_${id}">
			<h6 class="m-0 mb-2">Sobre reporte: ${id}</h6>
			<form class="container__report--verdict form" id="form-verdict_${id}">
				<div class="container__inputs--reports">
					<div class="container__item--inputs">
						<span>Veredicto</span>
						<textarea class="form-control" id="textarea-verdict_${id}" placeholder="Ingrese un veredicto" name="verdict" required></textarea>
					</div>
				</div>
				<div class="container__options--submit">
					<button type="button" class="btn btn-secondary btn-close-modal-reports" data-close-type="btn-cancel">Cancelar</button>
					<button type="submit" class="btn btn-primary" id="${this.id.includes("ban") ? "btn_delete_recipe_" + id : "btn_discard_report_" + id}">${this.id.includes("ban") ? "Eliminar receta" : "Descartar reporte"}</button>
				</div>
			</form>
			</div>`;
		$(this.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode).append(code_html);
	});

	// BOTON DE VER MAS EN LAS JUSTIFICACIONES DE LOS REPORTES
	$("#container__specific").on("click", ".btn-view-more-reports", function () {
		let id = this.id.split("_").pop();
		document
			.getElementById(`text-view-more-report_${id}`)
			.classList.toggle("d-none");

		if (this.innerText == "Ver más") {
			this.innerText = "Ver menos";
		} else {
			this.innerText = "Ver más";
		}
	});
});


// Cargar recetas reportadas
function loadRecipesReported() {
	$.ajax({
		url: `../api/recipes/show.php`,
		type: "POST",
		async: false,
		data: { page: num_page, for: "recipes_reported_mod" },
		dataType: "JSON",
		beforeSend: function () {
			var icon_html = `<svg id="preload_recipes_reported" class="w-100 " style="margin: 7px auto 0 auto;" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="20px" height="20px" viewBox="0 0 128 128" xml:space="preserve"><g><linearGradient id="linear-gradient"><stop offset="0%" stop-color="#ffffff"/><stop offset="100%" stop-color="#000000"/></linearGradient><path d="M63.85 0A63.85 63.85 0 1 1 0 63.85 63.85 63.85 0 0 1 63.85 0zm.65 19.5a44 44 0 1 1-44 44 44 44 0 0 1 44-44z" fill="url(#linear-gradient)" fill-rule="evenodd"/><animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64" dur="1080ms" repeatCount="indefinite"/></g></svg>`;
			$("#container__specific").append(icon_html);
		},
		success: function (data) {
			setTimeout(function () {
				$("#preload_recipes_reported").remove();
				data_recipes_reported = data;
				recipes_reported = data_recipes_reported.recipes;
				let code_html = "";
				recipes_reported.forEach((recipe) => {
					code_html += `
						<div class="container-v3 recipe" id="recipe_${recipe.id}">
							<div class="container__user">
							<div>
								<a class="container__user--profilepicture" href="profile.php?id=${recipe.user_id}">
								<img src="${recipe.profile_pic}" alt="foto perfil">
								</a>
							</div>
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

							</div>
							</div>
							<div class="container__recipe">

							<div class="container__recipe--title">
								<span>
								<h5>${recipe.title}</h5>
								</span>
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

					code_html += `
							<div class="container__recipe--content">`;

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

							<div class="container__recipe--steps d-none" id="container-steps_${recipe.id}">
								<h6>Pasos</h6>
								<span>${recipe.steps}</span>
							</div>
							
							<div class="container__recipe--see-more">
								<a id="btn-see-more_${recipe.id}"  class="btn btn_see-more" role="button">Ver más</a>
							</div>

							</div>
							<div class="container__options--mod d-flex">
							<div class="recipe_reports container__btn--view-reports mt-2 " id="container-recipe-reports_${recipe.id}">
								<a id="recipe_reports_${recipe.id}" class="btn btn-light" role="button">Ver reportes</a>
							</div>
							</div>
						</div>`;
				});
				$("#container__specific").append(code_html);
				num_page++;
			}, 250);
		},
	});
}

function loadReportsRecipes(recipe_id) {
	$.ajax({
		url: `../api/reports/show.php`,
		type: "POST",
		async: false,
		data: {
			page: num_page_reports,
			for: "reports_recipes_mod",
			recipe_id: recipe_id,
		},
		dataType: "JSON",
		success: function (data) {
			console.log(data);
			data_reports_recipes = data;
			reports_recipes = data_reports_recipes.reports;

			var code_html = `
				<div class="modal fade" id="modalReportsRecipes_${recipe_id}" data-bs-backdrop="static" data-modal-type="modal-view-reports" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
				<div class="modal-dialog " style="max-width: 800px;">
					<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="staticBackdropLabel">Reportes de la receta de ${data_reports_recipes.username_reported}</h5>
						<button type="button" class="btn-close btn-close-modal-reports" data-bs-dismiss="modal" data-close-type="btn-x" aria-label="Close"><i class="bi bi-x-lg"></i></button>
					</div>
					<div class="modal-body">`;

			reports_recipes.forEach((report_recipe) => {
				code_html += `
					<div class="container__report" id="container-report_${report_recipe.id}">
							<div class="container__data--report">
								<div class="report__username--date">
									<div class="report__username">
										${report_recipe.username_reporter} (${report_recipe.reporter_user_id})
									</div>
									•
									<div class="report__date">
										${report_recipe.created_at}
									</div>
								</div>
								<div class="report__about">
									Reporte: ${report_recipe.id}
								</div>
								<div class="report__reason--justification">
									<div class="report__reason">
										<span class="report__reason--title">Razon</span>
										<span class="report__reason--content">${report_recipe.reason}</span>
									</div>
									<div class="report__justification">
										<span class="report__justification--title">Justificacion</span>
										<span class="report__justification--content">${report_recipe.justification.slice(0, 220)}`;
				if (report_recipe.justification.slice(220, 1000)) {
					code_html += `...<span id="text-view-more-report_${report_recipe.id}" class="d-none">${report_recipe.justification.slice(220, 1000)}</span> <button type="button" class="btn btn-view-more-reports p-0" id="view-more-report_${report_recipe.id}">Ver más</button>`;
				}

				code_html += `     </span>
                                </div>
                            </div>
                        </div>
                        <!-- Descartar/Eliminar -->
                        <div class="container__options--report">
                          <div class="dropdown ps-2 ms-auto">
                            <button title="Opciones de moderacion" class="btn p-0 dropbtn" id="btn_delete-edit-${report_recipe.id}"><i class="bi bi-three-dots"></i></button>
                            <div id="dropdown_delete-edit-${report_recipe.id}" class="dropdown-content" style="right: -10px; top: 32px;">
                              <a class="dropdown-content__edit report-discard-ban" id="btn-discard-report_${report_recipe.id}" role="button"><i class="bi bi-recycle"></i> Descartar reporte</a>
                              <a class="dropdown-content__delete report-discard-ban" id="btn-ban-recipe_${report_recipe.id}" role="button" ><i class="bi bi-trash3"></i> Eliminar receta</a>
                            </div>
                          </div>
                        </div>
                    </div>`;
			});

			code_html += `
                </div>
            </div>
          </div>
        </div>`;

			$(`#recipe_${recipe_id}`).append(code_html);
			num_page_reports++;
		},
	});
}

// FUNCIONALIDAD DE DESCARTAR REPORTE O BANEAR CUENTA
$("#container__specific").on("submit", ".container__report--verdict", function (e) {
	e.preventDefault();
	let report_id = this.id.split("_").pop();
	let verdict = $(`#textarea-verdict_${report_id}`).val();
	let modal = this.parentNode.parentNode.parentNode.parentNode;
	let modal_footer = this.parentNode;
	let report_html = $(`#container-report_${report_id}`)[0];

	if (document.getElementById(`btn_delete_recipe_${report_id}`) == null) {
		// Descartar reporte
		$.ajax({
			url: "../api/reports/discard.php",
			type: "POST",
			data: { verdict: verdict, id: report_id },
			dataType: "JSON",
			success: function (data) {
				console.log(data);

				report_html.remove();
				if (document.getElementsByClassName("container__report").length == 0) {
					$(modal).modal("hide");
					$(`#recipe_${data_reports_recipes.recipe_reported_id}`).remove();
				}
				modal_footer.remove();
				num_page_reports = 1;
			},
		});
	} else {
		// Eliminar receta

		$.ajax({
			url: `../api/recipes/disable_mod.php`,
			type: "POST",
			data: {
				for: "delete_recipe",
				recipe_to_delete_id: data_reports_recipes.recipe_reported_id,
				report_id: report_id,
				verdict: verdict,
			},
			dataType: "JSON",
			success: function (data) {
				console.log(data);

				$(modal).modal("hide");
				modal.remove();
				$(`#recipe_${data_reports_recipes.recipe_reported_id}`).remove();
				num_page_reports = 1;
			},
		});
	}
}
);
