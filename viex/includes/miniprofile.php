<?php
foreach ($rowAccounts as $value) {
?>
  <div class="container-v3">
    <div class="container-all">
      <div class="container__img">
        <a href="profile.php?id=<?php echo $value['id']; ?>">
          <img src="<?php echo profile_pic($value['id']); ?>" alt="foto perfil">
        </a>
      </div>
      <div class="container__userdata">
        <div class="container__userdata--username">
          <a href="profile.php?id=<?php echo $value['id']; ?>"><?php echo $value['username']; ?></a>
        </div>
        <div class="container__userdata--description">
          <span><?php echo $value['biography']; ?></span>
        </div>
      </div>
      <?php
      if (isset($_SESSION['user'])) {
        if ($_SESSION['user']['id'] != $value['id']) { ?>
          <!--- Verificar si lo sigue o no -->
          <div id="<?php echo $value['id']; ?>" class="user_follow container__user--<?php echo ($value['verify_follow'] == 0) ? "follow" : "unfollow"; ?>">
            <a id="user_follow_<?php echo $value['id']; ?>" class="btn btn-dark" role="button">
              <?php echo ($value['verify_follow'] == 0) ? "Seguir" : "Dejar de Seguir"; ?>
            </a>
          </div>
        <?php
        }
      } else { ?>
        <div class="container__user--follow">
          <a class="btn btn-dark" href="login.php" role="button">Seguir</a>
        </div>
      <?php
      }
      ?>
    </div>
  </div>
<?php
}
?>