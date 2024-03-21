window.addEventListener('load', function () {
  $("#container__recipes").on("click", ".recipe_delete", function () {
    var id = this.id.split("_").pop();

    $.ajax({
      url: '../api/recipes/disable.php',
      type: 'POST',
      data: { id: id },
      dataType: 'JSON',
      success: function (data) {
        if (data['aux'] != 'publication') {
          $(`#recipe_${id}`).remove();
        }
        if (data['estado'] == 'borrado') {
          let timerInterval
          Swal.fire({
            html: 'Receta eliminada con exito',
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
              if (data['aux'] == 'publication') {
                window.history.back();
              }
            }
          })
        } else {
          let timerInterval
          Swal.fire({
            html: 'Error al eliminar receta',
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
      }
    });

  });

  $("#container__comments").on("click", ".comment_delete", function () {
    var id = this.id.split("_").pop();

    $.ajax({
      url: '../api/comments/disable.php',
      type: 'POST',
      data: { id: id },
      dataType: 'JSON',
      success: function (data) {
        $(`#comment_${id}`).remove();
        console.log(data)
        if (data['estado'] == 'borrado') {
          let timerInterval
          Swal.fire({
            html: 'Comentario eliminado con exito',
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
          let timerInterval
          Swal.fire({
            html: 'Error al publicar comentario',
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
      }
    });

  })

  $("#container__specific").on("click", ".category_delete", function () {
    var id = this.id.split("_").pop();

    $.ajax({
      url: '../api/categories/delete.php',
      type: 'POST',
      data: { id: id },
      dataType: 'JSON',
      success: function (data) {
        console.log(data)
        if (data['action'] == 'borrar') {
          $(`#category_${id}`).remove();
          
          Swal.fire({
            html: 'Categoria eliminada con exito',
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
            html: 'Error al intentar borrar categoria',
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
      }
    });

  })
});