$(document).ready(function () {
    $("#container__specific").on("click", ".highlight_category", function () {
        let category_id = this.id.split("_").pop();

        $.ajax({
            url: '../api/categories/highlight_category.php',
            type: 'POST',
            data: { category_id: category_id },
            dataType: 'JSON',
            success: function (data) {
                console.log(data)
                if (data.estado == 'Hecho') {
                    Swal.fire({
                        html: 'Categoría agregada a favoritas con exito',
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
                    Swal.fire({
                        html: data.reason,
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

                if (data.action == 'fav') {
                    $(`#highlight_category_id_${category_id} i`).removeClass('bi-star')
                    $(`#highlight_category_id_${category_id} i`).addClass('bi-star-fill')
                } else {
                    $(`#highlight_category_id_${category_id} i`).removeClass('bi-star-fill')
                    $(`#highlight_category_id_${category_id} i`).addClass('bi-star')
                }
            }
        })
    })
})