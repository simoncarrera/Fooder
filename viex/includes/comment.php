<?php
foreach ($rowDataComment as $value) {
?>
  <div class="container-v3" id="comment_<?php echo $value['id']; ?>">
    <div class="container__user">
      <div class="container__user--profilepicture">
        <a href="profile.php?id=<?php echo $value['user_id']; ?>">
          <img src="<?php echo profile_image($value['user_id']); ?>" alt="foto perfil">
        </a>
      </div>
      <div class="container__user--name-date">
        <div class="container__user--username">
          <a href="profile.php?id=<?php echo $value['user_id']; ?>"><?php echo $value['username']; ?></a>
        </div>
        <div class="container__user--separator">
          <span>•</span>
        </div>
        <div class="container__user--date">
          <span for="dateUp">
            <?php echo creation_date($value['created_at']); ?>
          </span>
        </div>
      </div>
    </div>
    <div class="container__comment">
      <span><?php echo $value['comment']; ?></span>
    </div>

    <div class="container__feedback">
      <?php
      if (!isset($_SESSION['user'])) { ?>
        <div class="container__feedback--likes">
          <a class="" id="<?php echo $value['id']; ?>" href="login.php" role="button">
            <img src="../../images/icons/nolike.png" width="22px" alt="like_icon">
            <span><?php echo $value['cant_likes']; ?></span>
          </a>
        </div>
      <?php
      } else { ?>
        <!--- Verificar si le dio o no like -->
        <div class="container__feedback--likes">
          <a class="btn comment_like" id="<?php echo $value['id']; ?>" role="button">
            <img id="comment_img_<?php echo $value['id']; ?>" src="../../images/icons/<?php echo ($value['verify_like'] == 0) ? "nolike" : "like"; ?>.png" width="22px" alt="like_icon">
            <span id="comment_likes_<?php echo $value['id']; ?>"><?php echo $value['cant_likes']; ?></span>
          </a>
        </div>
      <?php
      }
      ?>
      <!--<div class="container__feedback--comments">
                <button class="btn"><span>Responder</span></button>
            </div>-->

      <?php
      if (isset($_SESSION['user'])) {
        if ($_SESSION['user']['id'] == $value['user_id']) { ?>
          <div class='container__delete-recipe'>
            <a class='btn btn-danger p-1 comment_delete' id="<?php echo $value['id']; ?>">Eliminar</a>
          </div>
        <?php } else { ?>
          <div class="container__feedback--report">
            <button class="btn"><i class="bi bi-flag"></i></button>
          </div>
      <?php
        }
      } ?>
    </div>

    <!--<div class="container__answers">
        <button class="btn">
            <span class="container__answers--text">Ver respuestas (25) <i class="bi bi-chevron-down" style="font-size: 13px;"></i></span>
        </button>
    </div>-->
  </div>
<?php } ?>