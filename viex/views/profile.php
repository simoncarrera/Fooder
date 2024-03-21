<!-- Datos del perfil -->
<div class="container-v3">
  <div class="container__profile" id="container__profiles">

    <div class="container__profilepicture">
      <img class="container__profilepicture" src="
      <?php echo profile_image($rowCreator['id']); ?>" alt="foto perfil">
    </div>

    <div class="container__data-feedback">
      <div class="container__name-feedback">
        <div class="container__name-edit">
          <div class="container__name">
            <label for="username"><?php echo $rowCreator['username']; ?></label>
          </div>

        </div>

        <div class="container__feedback-b">

          <?php
          if (isset($_SESSION['user'])) {
            if ($_SESSION['user']['id'] != $rowCreator['id']) {
              // Si NO es el usuario del perfil aparecerá esto:  href="users/follow.php?id=<?php echo $rowCreator['id']; 
          ?>
              <div class="dropdown pe-2 ms-auto">
                <button class="btn dropbtn" id="btn_options-user-<?php echo $rowCreator['id']; ?>"><i class="bi bi-three-dots"></i></button>
                <div id="dropdown_options-user-<?php echo $rowCreator['id']; ?>" class="dropdown-content" style="right: 8px; top: 33px; min-width: 150px;">
                  <a class="dropdown-content__edit" role="button" data-bs-toggle="modal" data-bs-target="#modal-report-profile_<?php echo $rowCreator['id']; ?>"><i class="bi bi-flag"></i>Reportar</a>
                </div>
              </div>

              <div id="modal-report-profile_<?php echo $rowCreator['id']; ?>" class="modal fade form-report" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form method="POST" id="form-report-profile_<?php echo $rowCreator['id']; ?>" class="modal-report-profile">
                      <div class="modal-header">
                        <h5 class="modal-title">Denunciar cuenta</h5>
                        <button class="btn-close" type="reset" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i></button>
                      </div>
                      <div class="modal-body">
                        <div class="radio">
                          <input type="radio" name="rep_why" id="cont_sex" value="cont_sex" checked>
                          <label for="cont_sex">Contenido sexual</label><br>
                          <input type="radio" name="rep_why" id="abus_men" value="abus_men">
                          <label for="abus_men">Abuso de menores</label><br>
                          <input type="radio" name="rep_why" id="fomen_terr" value="fomen_terr">
                          <label for="fomen_terr">Fomenta el terrorismo</label><br>
                          <input type="radio" name="rep_why" id="cont_copi" value="cont_copi">
                          <label for="cont_copi">Contenido plagiado</label><br>
                          <input type="radio" name="rep_why" id="inf_err" value="inf_err">
                          <label for="inf_err">Informacion errónea</label><br>
                          <input type="radio" name="rep_why" id="cont_ofens" value="cont_ofens">
                          <label for="cont_ofens">Contenido ofensivo</label><br>
                          <textarea id="profile-report-description_<?php echo $rowCreator['id']; ?>" required cols="30" rows="10" class="form-control modal_form_textarea" placeholder="Agregar descripcion especifica de la infraccion" maxlength="500"></textarea>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <div class="container-buttons">
                          <button class="btn" type="reset" data-bs-dismiss="modal">Cancelar</button>
                        </div>

                        <div class="container-buttons">
                          <button id="btn_submit_report" class="btn" type="submit">Siguiente</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>

              <!--- Verificar si lo sigue o no -->
              <div id="container-follow_<?php echo $rowCreator['id']; ?>" class="user_follow container__user--<?php echo ($rowCreator['verify_follow'] == 0) ? "follow" : "unfollow"; ?>">
                <a id="user_follow_<?php echo $rowCreator['id']; ?>" class="btn btn-dark" role="button">
                  <?php echo ($rowCreator['verify_follow'] == 0) ? "Seguir" : "Dejar de Seguir"; ?>
                </a>
              </div>
            <?php
            } else { // Si ES el usuario del perfil aparecerá esto:  
            ?>
              <div class="container__edit">
                <a href="edit_profile.php" class="btn ">Editar perfil</i></a>
              </div>
            <?php
            }
          } else { ?>
            <div class="container__user--follow">
              <a class="btn btn-dark" href="login.php" role="button">Seguir</a>
            </div>
          <?php } ?>
        </div>

      </div>

      <div class="container__description">
        <span><?php echo $rowCreator['biography']; ?></span>
      </div>
      <br>
      <ul class="list__interaction-data">
        <li>
          <span class="container__recipe-num"><?php echo $rowCreator['cant_recipes']; ?></span> Recetas
        </li>
        <li>
          <a href="../web/users_followers.php?id=<?php echo $rowCreator['id']; ?>">
            <span id="cant_followers_<?php echo $rowCreator['id']; ?>" class="container__followers-num"><?php echo $rowCreator['cant_followers']; ?></span>
            Seguidores
          </a>
        </li>
        <li>
          <a href="../web/users_followeds.php?id=<?php echo $rowCreator['id']; ?>">
            <span class="container__following-num"><?php echo $rowCreator['cant_followeds']; ?></span>
            Seguidos
          </a>
        </li>
      </ul>
    </div>

  </div>
</div>

<!-- Publicaciones del perfil -->
<div id="container__recipes"></div>

<script src="../../js/recipes.js" type="text/javascript"></script>
<script src="../../js/reports.js" type="text/javascript"></script>
<script src="../../js/likes.js" type="text/javascript"></script>
<script src="../../js/follows.js" type="text/javascript"></script>
<script src="../../js/delete.js" type="text/javascript"></script>