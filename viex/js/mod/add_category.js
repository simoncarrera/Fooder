$(document).ready(function () {
    const input_name_category = document.getElementById('input-category_name')
    const input_img_category = document.getElementById('input-category_img')

    $('#form_add_category').on('submit', function (e) {
        e.preventDefault()

        var formData = new FormData();
        const name_category = $('#input-category_name').val()
        const img_category = document.getElementById('input-category_img')

        formData.append('category', name_category);
        formData.append('img_category', img_category.files[0]);

        fetch("../api/categories/add.php", {
            method: "POST",
            body: formData,
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                console.log(data);
                if (data.error_category != null) {
                    validafalla(input_name_category, data.error_category);
                } else {
                    validaOk(input_name_category);
                }
                if (data.error_img_category != null) {
                    validafalla(input_img_category, data.error_img_category);
                } else {
                    validaOk(input_img_category);
                }


                if (data.message == "Hecho") {
                    let code_html = `
						<div class="container-v3" id="category_${data.category_id}">
							<div class="container-all">
                                <div class="container__img">
                                    <img src="../../images/categories/${data.category_id}/${img_category.files[0]['name']}" alt="foto perfil">
                                </div>
                                <div class="container__userdata">
                                    <div class="container__userdata--username">
                                    <span>${name_category}</span>
                                    </div>
                                </div>
                                <div class="container__options--categories">
                                    <div class="container__highlight--category">
										<button class="btn p-0 highlight_category" id="highlight_category_id_${data.category_id}"><i class="bi bi-star"></i></button>
									</div>
                                    <!--<div class="container__edit--category">
                                        <a href="#" class="btn btn-light" role="button">Editar</a>
                                    </div>-->
                                    <div class="container__delete--category">
                                        <button class="btn btn-danger category_delete" id="category_delete_id_${data.category_id}" role="button">Eliminar</button>
                                    </div>
                                </div>
							</div>
						</div>`;

                    document.getElementById("container__specific").insertAdjacentHTML("afterbegin", code_html);
                    $('#form_add_category').trigger("reset")
                    $('#addCategory_Modal').modal('hide')

                    Swal.fire({
                        html: 'Categoria creada con exito',
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
            })
                
    })

    const validafalla = (input, msje) => {
        const form = input.parentElement;
        const warning = form.querySelector("p");
        warning.innerText = msje;
        form.classList = "form-group fail";
    };
    const validaOk = (input, msje) => {
        const form = input.parentElement;
        const warning = form.querySelector("p");
        warning.innerText = null;
        form.classList = "form-group success";
    };
})
