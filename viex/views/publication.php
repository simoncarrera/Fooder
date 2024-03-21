<!-- Publicacion -->
<div id="container__recipes">
  <div class="container-v3" id="recipe_<?php echo $rowRecipe['id']; ?>">
    <div class="container__user">
      <div class="me-1">
        <button onclick="window.history.back();" class="btn btn-volver">
          <i class="bi bi-arrow-left-short"></i>
        </button>
      </div>
      <div>
        <a class="container__user--profilepicture" href="profile.php?id=<?php echo $rowRecipe['user_id']; ?>">
          <img src="<?php echo profile_pic($rowRecipe['user_id']); ?>" alt="foto perfil">
        </a>
      </div>
      <div class="container__user--name-date">
        <div class="container__user--username">
          <a href="profile.php?id=<?php echo $rowRecipe['user_id']; ?>"><?php echo htmlspecialchars($rowRecipe['username']); ?></a>
        </div>
        <div class="container__user--separator">
          <span>•</span>
        </div>
        <div class="container__user--date">
          <span for="dateUp">
            <?php echo creation_date($rowRecipe['created_at']); ?>
          </span>
        </div>
      </div>
      <?php
      if (isset($_SESSION['user']) && $_SESSION['user']['id'] == $rowRecipe['user_id']) { ?>
        <!--- Boton de eliminar -->
        <div class="dropdown ps-2 ms-auto">
          <button class="btn p-0 dropbtn" id="btn_delete-edit-<?php echo $rowRecipe['id'] ?>"><i class="bi bi-three-dots"></i></button>
          <div id="dropdown_delete-edit-<?php echo $rowRecipe['id'] ?>" class="dropdown-content" style="right: -10px; top: 32px;">
            <a class="dropdown-content__edit" href="../web/edit_recipe.php?id=<?php echo $rowRecipe['id'] ?>"><i class="bi bi-pencil-square"></i> Editar</a>
            <a class="dropdown-content__delete recipe_delete" id="recipe_id_<?php echo $rowRecipe['id'] ?>" role="button"><i class="bi bi-trash3"></i> Eliminar</a>
          </div>
        </div>

      <?php
      } ?>
    </div>
    <div class="container__recipe">
      <div class="container__recipe--title">
        <h5><?php echo htmlspecialchars($rowRecipe['title']); ?></h5>
      </div>
      <div class="container__all-imgs">
        <?php
        $recipes_imgs = recipe_pics($rowRecipe['id']);
        if ($recipes_imgs) {
          foreach ($recipes_imgs as $ruta) { ?>
            <div class="container__img-recipe">
              <img class="recipe__img-item" src="../../images/recipes/<?php echo $rowRecipe['id'] . "/" . $ruta; ?>" alt="foto receta">
            </div>
        <?php
          }
        } ?>
      </div>
      <div class="container__recipe--content">
        <div class="container__recipe--introduction">
          <span><?php echo htmlspecialchars($rowRecipe['introduction']) ?></span>
        </div>

        <div class="container__recipe--ingredients">
          <h6>Ingredientes</h6>
          <span><?php echo htmlspecialchars($rowRecipe['ingredients']) ?></span>
        </div>

        <div class="container__recipe--steps">
          <h6>Pasos</h6>
          <span><?php echo htmlspecialchars($rowRecipe['steps']) ?></span>
        </div>
      </div>
    </div>
    <div class="container__feedback">

      <div class="container__likes-comments">

        <?php
        if (!isset($_SESSION['user'])) { ?>
          <div class="container__feedback--likes">
            <a class="btn" id="<?php echo $rowRecipe['id']; ?> " href="login.php" role="button">
              <i class="bi bi-heart"></i>
              <!--<img src="../../images/icons/nolike.png" width="22px" alt="">-->
              <span><?php echo $rowRecipe['cant_likes']; ?></span>
            </a>
          </div>
        <?php
        } else { ?>
          <!--- Verificar si le dio o no like    -->
          <div class="container__feedback--likes ">
            <a class="btn recipe_like" id="<?php echo $rowRecipe['id']; ?>" role="button">
              <i id="recipe_img_<?php echo $rowRecipe['id']; ?>" class="bi bi-heart<?php echo ($rowRecipe['verify_like'] == 0) ? null : "-fill"; ?>"></i>
              <!--<img id="recipe_img_<?php echo $rowRecipe['id']; ?>" src="../../images/icons/<?php echo ($rowRecipe['verify_like'] == 0) ? "nolike" : "like"; ?>.png" width="22px" alt="likes_icon">-->
              <span id="recipe_likes_<?php echo $rowRecipe['id']; ?>"><?php echo $rowRecipe['cant_likes']; ?></span>
            </a>
          </div>
        <?php
        } ?>

        <div class="container__feedback--comments">
          <a class="btn" role="button">
            <i class="bi bi-chat"></i>
            <!--<img src="../../images/icons/comments.png" width="22px" alt="">-->
            <span><?php echo $rowRecipe['cant_comments']; ?></span>
          </a>

        </div>
        <div class="container__feedback--share">
          <a class="btn" data-bs-toggle="modal" data-bs-target="#share_recipe_<?php $rowRecipe['id'] ?>" href="#" role="button">
            <i class="bi bi-share"></i>
            <!--<img src="../../images/icons/share.png" width="22px" alt="share_icon">-->
          </a>
        </div>
      </div>
      <!-- Modal compartir-->
      <div class="modal fade" id="share_recipe_<?php $rowRecipe['id'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Compartir receta en tus redes sociales</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="modal-body">
              <div class="container_pages_share">
                <div class="container_whatsapp">
                  <a href="https://api.whatsapp.com/send?text=http://localhost/22-4.10-proyectos/viex/controllers/web/publication.php?id=<?php echo $rowRecipe['id'] ?>#link-comment" target="_blank"><i class="bi bi-whatsapp "></i> <span>WhatsApp</span></a>

                </div>
                <div class="container_twitter">
                  <a href="https://twitter.com/intent/tweet?text=Fooder&url=http://localhost/22-4.10-proyectos/viex/controllers/web/publication.php?id=<?php echo $rowRecipe['id'] ?>}#link-comment&via=Viex&hashtags=#Comida" target="_blank"><i class="bi bi-twitter"></i>Twitter</a>

                </div>
                <div class="container_facebook">
                  <a href="http://www.facebook.com/sharer.php?u=http://localhost/22-4.10-proyectos/viex/controllers/web/publication.php?id=<?php echo $rowRecipe['id'] ?>#link-comment" target="_blank"><i class="bi bi-facebook"></i> Facebook</a>

                </div>
                <div class="container_link-recipe">
                  <input type="text" value="http://localhost/22-4.10-proyectos/viex/controllers/web/publication.php?id=<?php echo $rowRecipe['id'] ?>" id="TextoACopiar_<?php echo $rowRecipe['id'] ?>" style="position: absolute; left: -9999px;">
                  <button id="BotonCopiar_<?php echo $rowRecipe['id'] ?>" class="btn link_recipe">
                    <i class="bi bi-link-45deg"></i>
                    <p class="m-0" style="font-weight: 400;">Copiar link</p>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php
      if (isset($_SESSION['user'])) {
        if ($_SESSION['user']['id'] != $rowRecipe['user_id']) { ?>
          <div class="container__feedback--report">
            <a class="btn" data-bs-toggle="modal" data-bs-target="#modal-report_<?php echo $rowRecipe['id'] ?>"><i class="bi bi-flag"></i></a>
          </div>

          <!-- Modal reporte -->
          <div id="modal-report_<?php echo $rowRecipe['id'] ?>" class="modal fade form-report " role="dialog">
            <div class="modal-dialog">
              <div class="modal-content">
                <form method="POST" id="form-report-recipe_<?php echo $rowRecipe['id']; ?>" class="modal-report-recipes">
                  <div class="modal-header">
                    <h5 class="modal-title">Denunciar receta</h5>
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
                      <textarea id="recipe-report-description_<?php echo $rowRecipe['id']; ?>" required cols="30" rows="10" class="modal_form_textarea" placeholder="Agregar descripcion especifica de la infraccion" maxlength="500"></textarea>
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
        <?php
        }
      } else { ?>
        <div class="container__feedback--report">
          <a class="btn" href="../web/login.php" role="button"><i class="bi bi-flag"></i></a>
        </div>
      <?php
      } ?>
    </div>

  </div>
</div>

<!-- Opcion agregar comentario -->
<a name="link-comment"></a>
<div class="container-v3">

  <form id="form" method="post" action="../web/publication.php?id=<?php echo $rowRecipe['id']  ?>" class="form__comment">
    <div class="container__user--profilepicture">
      <img src="<?php echo (isset($_SESSION['user'])) ? profile_pic($_SESSION['user']['id']) : "../../images/profiles/default.png"; ?>" alt="foto perfil" width="50px">
    </div>
    <div class="container__textarea-comment">
      <textarea id="textarea-comment" class="textarea-comment" name="comment" maxlength="1000" placeholder="Agrega un comentario..." <?php echo (!isset($_SESSION['user'])) ? "disabled" : null ?>></textarea>
      <p class="errormessage__form" style="position: absolute;"></p>
    </div>
    <button type="submit" id="btn-publish-comment" class="btn btn-warning " <?php echo (!isset($_SESSION['user'])) ? "disabled" : null ?>>Publicar</button>
  </form>

</div>


<div id="container__comments"></div>
</div>



<script src="../../js/comments.js" type="text/javascript"></script>
<script src="../../js/reports.js" type="text/javascript"></script>
<script src="../../js/likes.js" type="text/javascript"></script>
<script src="../../js/delete.js" type="text/javascript"></script>