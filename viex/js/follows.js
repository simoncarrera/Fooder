window.addEventListener('load', function () {
  $("#container__profiles").on("click", ".user_follow", function () {
    var id = this.id.split("_")[1];

    $.ajax({
      url: '../api/users/follow.php',
      type: 'POST',
      data: { id: id },
      dataType: 'JSON',
      success: function (data) {
        var follows = data['follow'];
        var cant_followers = $(`#cant_followers_${id}`).text();
        if (follows == 'agregar') {
          $(`#user_follow_${id}`).html("Dejar de Seguir");
          $(`#container-follow_${id}`).removeClass("container__user--follow");
          $(`#container-follow_${id}`).addClass("container__user--unfollow");
          $(`#cant_followers_${id}`).html(parseInt(cant_followers) + 1);
        } else if (follows == 'sacar') {
          $(`#user_follow_${id}`).html("Seguir");
          $(`#container-follow_${id}`).removeClass("container__user--unfollow");
          $(`#container-follow_${id}`).addClass("container__user--follow");
          $(`#cant_followers_${id}`).html(parseInt(cant_followers) - 1);
        }
      }
    });

  });
});