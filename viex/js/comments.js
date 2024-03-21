// Paginador de comentarios
var num_page = 1;
var comments;
var rutaAbsoluta = location.href;
var recipe_id = rutaAbsoluta.split("=")[1];

loadComments();
$(window).on("scroll", function () {
	var scrollHeight = $(document).height();
	var scrollPosition = $(window).height() + $(window).scrollTop();
	if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
		if (data_comments.amt_comments_page >= num_page) {
			loadComments();
		}
	}
});

var data_comments;
function loadComments() {
	$.ajax({
		url: `../api/comments/show.php`,
		type: "POST",
		data: { page: num_page, recipe_id: recipe_id, for: "comments_publication" },
		dataType: "JSON",
		beforeSend: function () {
			var icon_html = `<svg id="preload_comments" class="w-100 " style="margin: 7px auto 0 auto;" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="20px" height="20px" viewBox="0 0 128 128" xml:space="preserve"><g><linearGradient id="linear-gradient"><stop offset="0%" stop-color="#ffffff"/><stop offset="100%" stop-color="#000000"/></linearGradient><path d="M63.85 0A63.85 63.85 0 1 1 0 63.85 63.85 63.85 0 0 1 63.85 0zm.65 19.5a44 44 0 1 1-44 44 44 44 0 0 1 44-44z" fill="url(#linear-gradient)" fill-rule="evenodd"/><animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64" dur="1080ms" repeatCount="indefinite"/></g></svg>`;
			$("#container__comments").append(icon_html);
		},
		success: function (data) {
			setTimeout(function () {
				$("#preload_comments").remove();
				data_comments = data;
				comments = data_comments.comments;

				comments.forEach((comment) => {
					var code_html = `
          <div class="container-v3" id="comment_${comment.id}">
            <div class="container__user">
              <div class="container__user--profilepicture">
                <a href="profile.php?id=${comment.user_id}">
                  <img src="${comment.profile_pic}" alt="foto perfil">
                </a>
              </div>
              <div class="container__user--name-date">
                <div class="container__user--username">
                  <a href="profile.php?id=${comment.user_id}">${comment.username}</a>
                </div>
                <div class="container__user--separator">
                  <span>•</span>
                </div>
                <div class="container__user--date">
                  <span for="dateUp">
                    ${comment.created_at}
                  </span>
                </div>
              </div>`;
					if (
						data_comments.user_logged_id != null &&
						data_comments.user_logged_id == comment.user_id
					) {
						code_html += `
              <div class="dropdown ps-2 ms-auto">
                <button class="btn p-0 dropbtn" id="btn_delete-edit-${comment.id}"><i class="bi bi-three-dots"></i></button>
                <div id="dropdown_delete-edit-${comment.id}" class="dropdown-content dropdown-content-comments" style="right: -10px; top: 32px;">
                  <a class="dropdown-content__delete " id="${comment.id}" role="button" data-bs-toggle="modal" data-bs-target="#exampleModal_${comment.id}" ><i class="bi bi-trash3" ></i> Eliminar</a>
                </div>
              </div>
              
              <div class="modal fade" id="exampleModal_${comment.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">¿Seguro que quieres eliminar la receta?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        Una vez eliminado el comentario no podras volver a recuperarla.
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary button-modal" data-bs-dismiss="modal">Cancelar</button>
                        <a role="button" id="${comment.id}" class="btn btn-warning button-modal comment_delete" data-bs-dismiss="modal">Confirmar</a>
                      </div>
                    </div>
                  </div>
              </div>`;
					}

					code_html += `
            </div>
            <div class="container__comment">
              <span>${comment.comment}</span>
            </div>

            <div class="container__feedback">`;

					if (data_comments.user_logged_id == null) {
						code_html += `
              <div class="container__feedback--likes">
                <a class="" id="${comment.id}" href="login.php" role="button">
                  <i class="bi bi-heart"></i>
                  <!--<img src="../../images/icons/nolike.png" width="22px" alt="like_icon">-->
                  <span>${comment.cant_likes}</span>
                </a>
              </div>
              <div class="container__feedback--report">
                <a class='btn' href="../web/login.php" role="button"><i class="bi bi-flag"></i></a>
              </div>`;
					} else {
						code_html += `
              <!--- Verificar si le dio o no like -->
              <div class="container__feedback--likes">
                <a class="btn comment_like" id="${comment.id}" role="button">
                  <i id="comment_img_${comment.id}" class="bi bi-heart${comment.verify_like == null ? "" : "-fill"}"></i>
                  <!--<img id="comment_img_${comment.id}" src="../../images/icons/${comment.verify_like == null ? "nolike" : "like"}.png" width="22px" alt="like_icon">-->
                  <span id="comment_likes_${comment.id}">${comment.cant_likes}</span>
                </a>
              </div>`;
						if (data_comments.user_logged_id != comment.user_id) {
							code_html += `
                <div class="container__feedback--report">
                  <a class="btn" data-bs-toggle="modal" data-bs-target="#modal-report-comment_${comment.id}"><i class="bi bi-flag"></i></a>           
                </div>
                
                <div id="modal-report-comment_${comment.id}" class="modal fade form-report" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form method="POST" id="form-report-comment_${comment.id}" class="modal-report-comments">
                      <div class="modal-header">
                        <h5 class="modal-title" >Denunciar comentario</h5>
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
                            <textarea id="comment-report-description_${comment.id}" required cols="30" rows="10" class="form-control modal_form_textarea" placeholder="Agregar descripcion especifica de la infraccion" maxlength="500"></textarea>
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
					}

					code_html += `
            </div>
          </div>`;

					$("#container__comments").append(code_html);
				});

				num_page++;
			}, 250);
		},
	});
}

// Validaciones y posteo de comentario
window.addEventListener("load", () => {
	const comment = document.getElementById("textarea-comment");

	form.addEventListener("submit", (e) => {
		e.preventDefault();
		validaCampos();
	});
	const validaCampos = () => {
		//caputrar los valores ingresados :)
		const commentvalue = comment.value.trim();
		var habilitar = 0;
		//validacion de comentario
		if (!commentvalue) {
			validafalla(comment, "Ingrese un comentario");
		} else if (commentvalue.length > 1000) {
			validafalla(comment, "Comentario demasiado largo");
		} else {
			validaOk(comment);
			habilitar++;
		}
		// validación para enviar el form
		if (habilitar == 1) {
			$.ajax({
				url: "../api/comments/post.php",
				type: "POST",
				data: { recipe_id: recipe_id, comment: commentvalue },
				dataType: "JSON",
				success: function (data) {
					console.log(data.message);
					if (data.message == "Se ha publicado correctamente el comentario") {
						// Insertar codigo html dentro del div con id = 'container__comments' antes de su primer hijo, es decir, al principio
						var code_html = `
              <div class="container-v3" id="comment_${data.id}">
                <div class="container__user">
                  <div class="container__user--profilepicture">
                    <a href="profile.php?id=${data.user_logged_id}">
                      <img src="${data.profile_pic}" alt="foto perfil">
                    </a>
                  </div>
                  <div class="container__user--name-date">
                    <div class="container__user--username">
                      <a href="profile.php?id=${data.user_logged_id}">${data.username}</a>
                    </div>
                    <div class="container__user--separator">
                      <span>•</span>
                    </div>
                    <div class="container__user--date">
                      <span for="dateUp">
                        ${data.created_at}
                      </span>
                    </div>
                  </div>
                  <div class="dropdown ps-2 ms-auto">
                    <button class="btn p-0 dropbtn" id="btn_delete-edit-${data.id}"><i class="bi bi-three-dots"></i></button>
                    <div id="dropdown_delete-edit-${data.id}" class="dropdown-content dropdown-content-comments" style="right: -10px; top: 32px;">
                      <a class="dropdown-content__delete " id="${data.id}" role="button" data-bs-toggle="modal" data-bs-target="#exampleModal_${data.id}" ><i class="bi bi-trash3" ></i> Eliminar</a>
                    </div>
                  </div>
                  
                  <div class="modal fade" id="exampleModal_${data.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">¿Seguro que quieres eliminar la receta?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            Una vez eliminado el comentario no podras volver a recuperarla.
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary button-modal" data-bs-dismiss="modal">Cancelar</button>
                            <a role="button" id="${data.id}" class="btn btn-warning button-modal comment_delete" data-bs-dismiss="modal">Confirmar</a>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
                <div class="container__comment">
                  <span>${data.comment}</span>
                </div>
                <div class="container__feedback">
                  <!--- Verificar si le dio o no like -->
                  <div class="container__feedback--likes">
                    <a class="btn comment_like" id="${data.id}" role="button">
                      <img id="comment_img_${data.id}" src="../../images/icons/nolike.png" width="22px" alt="like_icon">
                      <span id="comment_likes_${data.id}">0</span>
                    </a>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="exampleModal_${data.id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">¿Seguro que quieres eliminar la receta?</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      Una vez eliminado el comentario no podras volver a recuperarla.
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary button-modal" data-bs-dismiss="modal">Cancelar</button>
                      <a role="button" id="${data.id}" class="btn btn-warning button-modal comment_delete" data-bs-dismiss="modal">Confirmar</a>
                    </div>
                  </div>
                </div>
            </div>`;
						document.getElementById("container__comments").insertAdjacentHTML("afterbegin", code_html);
						document.getElementById("textarea-comment").value = "";

						let timerInterval;
						Swal.fire({
							html: "Comentario publicado con exito",
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
							}
						});
					} else {
						validafalla(comment, data.error_comment);
						if (data.error_comment != null) {
							let timerInterval;
							Swal.fire({
								html: "Error al publicar comentario",
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
								}
							});
						}
					}
				},
			});
		}
	};
	const validafalla = (input, msje) => {
		const form = input.parentElement;
		const warning = form.querySelector("p");
		warning.innerText = msje;
		form.classList = "container__textarea-comment fail";
	};
	const validaOk = (input, msje) => {
		const form = input.parentElement;
		const warning = form.querySelector("p");
		warning.innerText = "";
		form.classList = "container__textarea-comment success";
	};
});
