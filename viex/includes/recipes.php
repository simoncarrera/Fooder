<?php
foreach ($rowRecipe as $key => $value) {
?>

  <div class="container-v3 recipe" id="recipe_<?php echo $value['id']; ?>">
    <div class="container__user">
      <div>
        <a class="container__user--profilepicture" href="profile.php?id=<?php echo $value['user_id']; ?>">
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
    <div class="container__recipe">

      <div class="container__recipe--title">
        <span>
          <h5><?php echo $value['title']; ?></h5>
        </span>
      </div>
      <div class="container__all-imgs">
        <?php
        $recipes_imgs = recipe_pics($value['id']);
        if ($recipes_imgs) {
          foreach ($recipes_imgs as $ruta) { ?>
            <div class="container__img-recipe">
              <img class="recipe__img-item" src="../../images/recipes/<?php echo $value['id'] . "/" . $ruta; ?>" alt="foto receta">
            </div>
        <?php
          }
        } ?>
      </div>
      <div class="container__recipe--content">
        <?php if ($value['introduction']) { ?>
          <div class="container__recipe--introduction">
            <span><?php echo $value['introduction'] ?></span>
          </div>
        <?php } ?>

        <div class="container__recipe--ingredients">
          <h6>Ingredientes</h6>
          <span><?php echo $value['ingredients']; ?></span>
        </div>
      </div>

      <div class="container__recipe--see-more">
        <a href="publication.php?id=<?php echo $value['id']; ?>" class="btn">Ver más</a>
      </div>
    </div>

    <div class="container__feedback">

      <div class="container__likes-comments">
        <?php
        // Like
        if (!isset($_SESSION['user'])) { ?>
          <!-- No esta logueado -->
          <div class="container__feedback--likes">
            <a class="btn" id="<?php echo $value['id']; ?>" href="login.php" role="button">
              <img src="../../images/icons/nolike.png" width="22px" alt="likes_icon">
              <!---<i class="bi bi-heart"></i>-->
              <span><?php echo $value['cant_likes']; ?></span>
            </a>
          </div>
        <?php
        } else { ?>
          <!--- Verificar si le dio o no like    -->
          <div class="container__feedback--likes ">
            <a class="btn recipe_like" id="<?php echo $value['id']; ?>" role="button">
              <img id="recipe_img_<?php echo $value['id']; ?>" src="../../images/icons/<?php echo ($value['verify_like'] == 0) ? "nolike" : "like"; ?>.png" width="22px" alt="likes_icon">
              <span id="recipe_likes_<?php echo $value['id']; ?>"><?php echo $value['cant_likes']; ?></span>
            </a>
          </div>
        <?php
        } ?>


        <div class="container__feedback--comments">
          <a class="btn" href="publication.php?id=<?php echo $value['id']; ?>" role="button">
            <img src="../../images/icons/comments.png" width="22px" alt="comments_icon">
            <span><?php echo $value['cant_comments']; ?></span>
          </a>
        </div>

      </div>

      <!--- Boton de eliminar -->

      <?php

      if (isset($_SESSION['user'])) {
        //si esta logeado
        if ($_SESSION['user']['id'] == $value['user_id']) { ?>
          <div class="dropdown ps-2" data-bs-toggle="modal" data-bs-target="#miModal">
            <button class="btn p-0 dropbtn2" id="delete-edit_<?php echo $value['id']; ?>"><i class="bi bi-three-dots"></i></button>
            <div id="myDropdownDeleteEdit<?php echo $value['id']; ?>" class="dropdown-content2" style="right: -19px; top: 40px;">
              <a class="dropdown-content__edit" href="../controllers/edit_recipe.php?id=<?php echo $value['id']; ?>"><i class="bi bi-pencil-square"></i> Editar</a>
              <a class="dropdown-content__delete" href="../controllers/recipes/disable.php?id=<?php echo $value['id']; ?>"><i class="bi bi-trash3"></i> Eliminar</a>
            </div>
          </div>
        <?php
        } else { ?>

          <div class="container__feedback--report">
            <a class="btn" data-bs-toggle="modal" data-bs-target="#modal-report<?php echo $value['id']; ?>"><i class="bi bi-flag"></i></a>
          </div>

          <!-- Modal -->
          <div id="modal-report<?php echo $value['id']; ?>" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <form action="../controllers/reports.php?recipe_id=<?php echo $value['id']; ?>&user_id=<?php echo $_SESSION['user']['id']; ?>" method="POST" id="form_report">
                  <div class="modal-header">
                    <h5 class="modal-title">Denunciar receta</h5>
                    <button class="btn-close" type="reset" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <div class="radio">
                      <input type="radio" name="rep_why" id="cont_sex" value="cont_sex">
                      <label for="cont_sex">Engañoso o con spam</label><br>
                      <input type="radio" name="rep_why" id="abus_men" value="abus_men">
                      <label for="abus_men">Contenido plagiado</label><br>
                      <input type="radio" name="rep_why" id="fomen_terr" value="fomen_terr">
                      <label for="fomen_terr">No tiene relacion con comida</label><br>
                      <input type="radio" name="rep_why" id="cont_copi" value="cont_copi">
                      <label for="cont_copi">Contenido sexual</label><br>
                      <input type="radio" name="rep_why" id="inf_err" value="inf_err">
                      <label for="inf_err">Venta de articulos ilegales</label><br>
                      <input type="radio" name="rep_why" id="cont_ofens" value="cont_ofens">
                      <label for="cont_ofens">Fomenta el odio y/o el terrorismo</label><br>
                      <textarea name="description" cols="30" rows="10" class="modal_form_textarea" placeholder="Bríndranos más detalles" maxlength="500" required></textarea>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <div class="container-buttons">
                      <button class="btn" type="reset" data-bs-dismiss="modal">Cancelar</button>
                    </div>

                    <div class="container-buttons">
                      <button class="btn" type="submit" id="btn_subm_report">Siguiente</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        <?php
        }
      } else { ?>
        <div class="container__feedback--report">
          <a class="btn" href="../controllers/login.php"><i class="bi bi-flag"></i></a>
        </div>

      <?php
      } ?>



    </div>
  </div>


<?php 
} ?>
