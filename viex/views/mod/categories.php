<div class="container-v5" style="overflow: hidden;">
  <div class="container__submenu">
    <div class="container__submenu-accounts">
      <a href="../web/mod_accounts.php" aria-selected="false" id="submenu__item-recipes">Cuentas</a>
    </div>
    <div class="container__submenu--recipes">
      <a href="../web/mod_recipes_reported.php" aria-selected="false" id="submenu__item-recipes">Recetas report.</a>
    </div>
    <div class="container__submenu-comments">
      <a href="../web/mod_comments_reported.php" aria-selected="false" id="submenu__item-recipes">Comentarios report.</a>
    </div>
    <div class="container__submenu-categories">
      <a href="../web/mod_categories.php" aria-selected="true" id="submenu__item-recipes">Categorias</a>
    </div>
  </div>
</div>

<div class="container-v5 container__add--category ">
  <h5>En esta pantalla podes ver, editar, eliminar y/o </h5>
  <button type="button" class="btn btn-success ms-2" data-bs-toggle="modal" data-bs-target="#addCategory_Modal">Agregar una nueva categoría</button>

  <!-- Modal para crear nueva categoria -->
  <div class="modal fade" id="addCategory_Modal" tabindex="-1" aria-labelledby="addCategory_ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <form class="modal-content" id="form_add_category" action="" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="addCategory_ModalLabel">Crear categoría</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="modal-body">
          <div class="container__inputs-category">
            <div class="container__name-category">
              <h6 class="mb-1">Nombre de la categoria</h6>
              <input type="text" class="form-control" name="category_name" id="input-category_name" maxlength="50">
              <p class="errormessage__form"></p>
            </div>
            <div class="container__img-category mt-3">
              <h6 class="mb-1">Ingrese una imagen para la categoria (JPEG, PNG, GIF o WEBP)</h6>
              <input type="file" accept="image/jpeg,image/png,image/webp,image/gif" name="category_img" id="input-category_img" class="form-control">
              <p class="errormessage__form"></p>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-light">Descartar</button>
          <button type="submit" class="btn btn-warning">Crear nueva categoría</button>
        </div>
      </form>
    </div>
  </div>

</div>

<div id="container__specific"></div>

<script src="../../js/mod/categories.js" type="text/javascript"></script>
<script src="../../js/delete.js" type="text/javascript"></script>
<script src="../../js/mod/add_category.js" type="text/javascript"></script>
<script src="../../js/mod/highlight_category.js" type="text/javascript"></script>