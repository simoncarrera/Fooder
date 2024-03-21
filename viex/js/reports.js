$(document).ready(function () {

  $("#container__recipes").on("submit", ".modal-report-recipes", function (e) {
    e.preventDefault();
    var recipe_reported_id = this.id.split("_")[1];
    var rep_why = $('input[name=rep_why]:checked').val();
    var justification = $(`#recipe-report-description_${recipe_reported_id}`).val();

    $.ajax({
      url: '../api/recipes/reports.php',
      type: 'POST',
      data: { recipe_reported_id: recipe_reported_id, rep_why: rep_why, justification: justification },
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        $(`#form-report-recipe_${recipe_reported_id}`)[0].reset()
        $(`#modal-report-recipe_${recipe_reported_id}`).modal('hide')
        if (data.message == 'Hecho') {
          let timerInterval
          Swal.fire({
            html: 'Receta reportada con exito',
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
        } else {
          let timerInterval
          Swal.fire({
            html: 'Error al reportar la receta',
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
    })

  });

  $("#container__comments").on("submit", ".modal-report-comments", function (e) {
    e.preventDefault();
    var comment_reported_id = this.id.split("_")[1];
    var rep_why = $('input[name=rep_why]:checked').val();
    var justification = $(`#comment-report-description_${comment_reported_id}`).val();

    $.ajax({
      url: '../api/comments/reports.php',
      type: 'POST',
      data: { comment_reported_id: comment_reported_id, rep_why: rep_why, justification: justification },
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        $(`#form-report-comment_${comment_reported_id}`)[0].reset()
        $(`#modal-report-comment_${comment_reported_id}`).modal('hide')
        if (data.message == 'Hecho') {
          let timerInterval
          Swal.fire({
            html: 'Comentario reportado con exito',
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
        } else {
          let timerInterval
          Swal.fire({
            html: 'Error al reportar el comentario',
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
    })

  });

  $("#container__profiles").on("submit", ".modal-report-profile", function (e) {
    e.preventDefault();
    var profile_reported_id = this.id.split("_")[1];
    var rep_why = $('input[name=rep_why]:checked').val();
    var justification = $(`#profile-report-description_${profile_reported_id}`).val();

    $.ajax({
      url: '../api/users/reports.php',
      type: 'POST',
      data: { profile_reported_id: profile_reported_id, rep_why: rep_why, justification: justification },
      dataType: 'JSON',
      success: function (data) {
        console.log(data);
        $(`#form-report-profile_${profile_reported_id}`)[0].reset()
        $(`#modal-report-profile_${profile_reported_id}`).modal('hide')
        if (data.message == 'Hecho') {
          let timerInterval
          Swal.fire({
            html: 'Usuario reportado con exito',
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
        } else {
          let timerInterval
          Swal.fire({
            html: 'Error al reportar al usuario',
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
    })

  });
});
