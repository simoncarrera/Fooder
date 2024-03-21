<div class="container-v5 d-grid grid-template-rows">
  <div class="mb-5 mt-4 ms-5 d-flex align-items-center">
    <a href="../web/profile.php?id=<?php echo $_GET['id'] ?>"><i class="bi bi-arrow-left-short me-3"></i></a>
    <h4 class="mb-1"><?php echo $rowUsername['username']; ?></h4>
  </div>
  <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-around">
    <a href="../web/users_followers.php?id=<?php echo $_GET['id'] ?>" aria-selected="false">Seguidores</a>
    <a href="../web/users_followeds.php?id=<?php echo $_GET['id'] ?>" aria-selected="true">Seguidos</a>
  </div>
</div>

<div id="container__profiles"></div>


<script src="../../js/miniprofiles.js" type="text/javascript"></script>
<script src="../../js/follows.js" type="text/javascript"></script>