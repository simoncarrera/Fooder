window.addEventListener('load', function () {
  $("#container__recipes").on("click", ".recipe_like", function () {
    var id = this.id;

    $.ajax({
      url: '../api/recipes/likes.php',
      type: 'POST',
      data: { id: id },
      dataType: 'JSON',
      success: function (data) {
        var likes = data['like'];
        var cant_likes = $(`#recipe_likes_${id}`).text();
        if (likes == 'sumar') {
          $(`#recipe_likes_${id}`).html(parseInt(cant_likes) + 1);
          //$(`#recipe_img_${id}`).attr("src", "../../images/icons/like.png");
          $(`#recipe_img_${id}`).removeClass("bi-heart")
          $(`#recipe_img_${id}`).addClass("bi-heart-fill")
        } else if (likes == 'restar') {
          $(`#recipe_likes_${id}`).html(parseInt(cant_likes) - 1);
          //$(`#recipe_img_${id}`).attr("src", "../../images/icons/nolike.png");
          $(`#recipe_img_${id}`).removeClass("bi-heart-fill")
          $(`#recipe_img_${id}`).addClass("bi-heart")
        }
      }
    });

  });

  $("#container__comments").on("click", ".comment_like", function () {
    var id = this.id;

    $.ajax({
      url: '../api/comments/likes.php',
      type: 'POST',
      data: { id: id },
      dataType: 'JSON',
      success: function (data) {
        var likes = data['like'];
        var cant_likes = $(`#comment_likes_${id}`).text();
        if (likes == 'sumar') {
          $(`#comment_likes_${id}`).html(parseInt(cant_likes) + 1);
          //$(`#comment_img_${id}`).attr("src", "../../images/icons/like.png");
          $(`#comment_img_${id}`).removeClass("bi-heart")
          $(`#comment_img_${id}`).addClass("bi-heart-fill")
        } else if (likes == 'restar') {
          $(`#comment_likes_${id}`).html(parseInt(cant_likes) - 1);
          //$(`#comment_img_${id}`).attr("src", "../../images/icons/nolike.png");
          $(`#comment_img_${id}`).removeClass("bi-heart-fill")
          $(`#comment_img_${id}`).addClass("bi-heart")
        }
      }
    });

  })
});
