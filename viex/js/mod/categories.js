var num_page = 1;

loadCategories();

var data_categories;

$(window).on("scroll", function () {
	var scrollHeight = $(document).height();
	var scrollPosition = $(window).height() + $(window).scrollTop();
	if ((scrollHeight - scrollPosition) / scrollHeight === 0) {
		if (data_categories.amt_categories_page >= num_page) {
			loadCategories();
		}
	}
});

function loadCategories() {
	// Cargar cuentas reportadas

	$.ajax({
		url: `../api/categories/show.php`,
		type: "POST",
		data: { page: num_page, for: "categories_mod" },
		datatype: "JSON",
		beforeSend: function () {
			var icon_html = `<svg id="preload_categories" class="w-100 " style="margin: 7px auto 0 auto;" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.0" width="20px" height="20px" viewBox="0 0 128 128" xml:space="preserve"><g><linearGradient id="linear-gradient"><stop offset="0%" stop-color="#ffffff"/><stop offset="100%" stop-color="#000000"/></linearGradient><path d="M63.85 0A63.85 63.85 0 1 1 0 63.85 63.85 63.85 0 0 1 63.85 0zm.65 19.5a44 44 0 1 1-44 44 44 44 0 0 1 44-44z" fill="url(#linear-gradient)" fill-rule="evenodd"/><animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64" dur="1080ms" repeatCount="indefinite"/></g></svg>`;
			$("#container__specific").append(icon_html);
		},
		success: function (data) {
			setTimeout(function () {
				$("#preload_categories").remove();

				console.log(data);
				data_categories = data;
				categories = data_categories.categories;
				var code_html = ``;

				categories.forEach((category) => {
					code_html += `
						<div class="container-v3" id="category_${category.id}">
							<div class="container-all">`;

					if (category.category_img != null) {
						code_html += `
								<div class="container__img">
									<img src="../../images/categories/${category.id}/${category.category_img[0]}" alt="foto perfil">
								</div>`;
						}
						code_html += `
								<div class="container__userdata">
									<div class="container__userdata--username">
									<span>${category.name}</span>
									</div>
								</div>
								<div class="container__options--categories">
									<div class="container__highlight--category">
										<button class="btn p-0 highlight_category" id="highlight_category_id_${category.id}"><i class="bi bi-star${(category.featured == 'YES') ? '-fill' : ''}"></i></button>
									</div>
									<!--<div class="container__edit--category">
										<a href="#" class="btn btn-light" role="button">Editar</a>
									</div>-->
									<div class="container__delete--category">
										<button class="btn btn-danger category_delete" id="category_delete_id_${category.id}" role="button">Eliminar</button>
									</div>
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
