<div class="container-v3 ">
  <form id="form" method="post" action="../web/edit_recipe.php?id=<?php echo $_GET['id']; ?>" class="form" enctype="multipart/form-data">
    <div class="form__container--content">
      <h4 class="mb-5 mt-4">Editar receta</h4>
    </div>

    <div class="form__container--content <?php echo (isset($errormessage_title)) ? "fail" : "success"; ?>">
      <span class="form__container--span ">Titulo</span>
      <textarea id="title" class="form__container--textarea-title form-control" name="title" maxlength="75"><?php echo $datos_Old['title']; ?></textarea>
      <p class="errormessage__form"><?php echo (isset($errormessage_title)) ? $errormessage_title : null; ?></p>
    </div>

    <div class="form__container--content <?php echo (isset($errormessage_intro)) ? "fail" : "success"; ?>">
      <span class="form__container--span ">Introducción</span>
      <textarea id="intro" class="form__container--textarea-introduction form-control" name="introduction" maxlength="250"><?php echo $datos_Old['introduction']; ?></textarea>
      <p class="errormessage__form"><?php echo (isset($errormessage_intro)) ? $errormessage_intro : null; ?></p>
    </div>

    <div class="form__container--content <?php echo (isset($errormessage_ingredients)) ? "fail" : "success"; ?>">
      <span class="form__container--span">Ingredientes</span>
      <textarea id="ingredients" class="form__container--textarea-ingredients form-control" name="ingredients" maxlength="500"><?php echo $datos_Old['ingredients']; ?></textarea>
      <p class="errormessage__form"><?php echo (isset($errormessage_ingredients)) ? $errormessage_ingredients : null; ?></p>
    </div>

    <div class="form__container--content <?php echo (isset($errormessage_steps)) ? "fail" : "success"; ?>">
      <span class="form__container--span ">Pasos</span>
      <textarea id="steps" class="form__container--textarea-steps form-control" name="steps" maxlength="2000"><?php echo $datos_Old['steps']; ?></textarea>
      <p class="errormessage__form"><?php echo (isset($errormessage_steps)) ? $errormessage_steps : null; ?></p>
    </div>

    <div class="form__container--content <?php echo (isset($errormessage_categories)) ? "fail" : "success"; ?>">
      <span class="form__container--span ">Categorias</span>
      <select id="categories" class="form__container--input-categories form-control" name="categories[]" multiple>
        <option value="Seleccione categorias" hidden disabled>Seleccione categorias</option>
      </select>
      <p class="errormessage__form"><?php echo (isset($errormessage_categories)) ? $errormessage_categories : null; ?></p>
    </div>


    <!-------------------  Agregar imagenes ----------------------------->
    <div id="wrapper" class="form__container">
      <div id="container-input">
        <div class="wrap-file">
          <div class="content-select-file">
            <span class="form__container--span m-0">Agregar imagenes o un video</span>
            <button type="button" id="selectfile" class="btn btn-warning form__container--select">Seleccionar archivo</button>
            <input id="file" type="file" accept="image/jpeg,image/png,image/webp,image/gif" multiple="4" name="file[]" hidden>
          </div>
          <div id="preview-images">

          </div>
        </div>
      </div>
      <div class="preload">
        <img src="../../images/icons/preload.gif" alt="preload">
      </div>
      <!--<h6 id="success" hidden="true"></h6>-->
    </div>
    <!-------------------  Termina agregar imagenes ----------------------------->

    <div class="text-end">
      <button class="btn btn-light form__container--discard " type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">Descartar</button>
      <button id="publish" class="btn btn-warning  form__container--post " type="submit">Publicar</button>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">¿Seguro que quieres descartar los cambios realizados?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Una vez descartados los cambios no podras volver a recuperar los cambios ingresados.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary button-modal" data-bs-dismiss="modal">Cancelar</button>
            <button type="reset" class="btn btn-warning button-modal" data-bs-dismiss="modal">Confirmar</button>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<script src="../../js/edit_recipe.js" type="text/javascript"></script>