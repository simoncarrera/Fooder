var num_page = 1;
var miniprofiles;
var rutaAbsoluta = location.href;
var rutaRelativa = rutaAbsoluta.split("/").pop();
var forWhat = rutaRelativa.split(".")[0];
var profile_id = rutaRelativa.split("=")[1];

if (forWhat == "searches") {
	// Consigo el valor de lo que quiere buscar
	var search = $("#principal__seeker--search").val();

	$("#principal__seeker").submit(function (event) {
		event.preventDefault();

		// Reestablesco valores del numero de paginas y vacio al contenedor
		num_page = 1;
		$("#container__profiles").html("");

		// Nuevo valor de busqueda
		search = $("#principal__seeker--search").val();

		// Cambio parametros de la url
		window.history.pushState(null, null, `?search=${search}&for=user`);

		// Cambio href de los botones del submenu
		$("#item__submenu--accounts").attr(
			"href",
			`../web/searches.php?search=${search}&for=user`
		);
		$("#item__submenu--recipes").attr(
			"href",
			`../web/searches.php?search=${search}`
		);

		loadMiniProfiles();
	});
}

loadMiniProfiles();

$(window).on("scroll", function () {
	var scrollHeight = $(document).height();
	var scrollPosition = $(window).height() + $(window).scrollTop();
	if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
		if (data_miniprofiles.amt_accounts_page >= num_page) {
			loadMiniProfiles();
		}
	}
});

var data_miniprofiles;
function loadMiniProfiles() {
	$.ajax({
		url: `../api/users/show.php`,
		type: "POST",
		data: {
			page: num_page,
			for: forWhat,
			profile_id: profile_id,
			search: search,
		},
		dataType: "JSON",
		beforeSend: function () {
			var icon_html = `<svg id="preload_miniprofiles" class="w-100 " style="margin: 7px auto 0 auto;" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="20px" height="20px" viewBox="0 0 128 128" xml:space="preserve"><g><linearGradient id="linear-gradient"><stop offset="0%" stop-color="#ffffff"/><stop offset="100%" stop-color="#000000"/></linearGradient><path d="M63.85 0A63.85 63.85 0 1 1 0 63.85 63.85 63.85 0 0 1 63.85 0zm.65 19.5a44 44 0 1 1-44 44 44 44 0 0 1 44-44z" fill="url(#linear-gradient)" fill-rule="evenodd"/><animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64" dur="1080ms" repeatCount="indefinite"/></g></svg>`;
			$("#container__profiles").append(icon_html);
		},
		success: function (data) {
			setTimeout(function () {
				$("#preload_miniprofiles").remove();

				data_miniprofiles = data;
				accounts = data_miniprofiles.accounts;
				let code_html = "";
				console.log(data);

				if (typeof search != "undefined") {
					code_html += `
        <p class="resultmessage">${data_miniprofiles.amt_total_reg} Resultados para la busqueda "${search}"</p>`;
					console.log(code_html);
				}

				accounts.forEach((account) => {
					var profile_image = (account.profile_pic).split(".")[0]
					var users_img = (account.profile_pic).split("/")
					code_html += `
          <div class="container-v3">
            <div class="container-all">
              <div class="container__img">
                <a href="profile.php?id=${account.id}">
				<img src="${account.profile_pic}" alt="foto perfil"></img></a>
              </div>
              <div class="container__userdata">
                <div class="container__userdata--username">
                  <a href="profile.php?id=${account.id}">${account.username}</a>
                </div>`;

					if (account.biography != null) {
						code_html += `<div class="container__userdata--description">
                  <span>${account.biography.slice(0, 100)}</span>
                </div>`;
					}

					code_html += `
              </div>`;

					if (data_miniprofiles.user_logged_id != null) {
						if (data_miniprofiles.user_logged_id != account.id) {
							code_html += `
              <!--- Verificar si lo sigue o no -->
              <div id="container-follow_${
								account.id
							}" class="user_follow container__user--${
								account.verify_follow == null ? "follow" : "unfollow"
							}">
                <a id="user_follow_${
									account.id
								}" class="btn btn-dark" role="button">${
								account.verify_follow == null ? "Seguir" : "Dejar de Seguir"
							}</a>
              </div>`;
						}
					} else {
						code_html += `
              <div class="container__user--follow">
                <a class="btn btn-dark" href="login.php" role="button">Seguir</a>
              </div>`;
					}

					code_html += `
            </div>
          </div>`;
				});

				$("#container__profiles").append(code_html);
				num_page++;
			}, 250);
		},
	});
}
