<div class="container-v5" style="overflow: hidden;">
  <div class="container__submenu">
    <div class="container__submenu-accounts">
      <a href="../web/mod_accounts.php" aria-selected="true" id=" submenu__item-recipes">Cuentas</a>
    </div>
    <div class="container__submenu--recipes">
      <a href="../web/mod_recipes_reported.php" aria-selected="false" id="submenu__item-recipes">Recetas report.</a>
    </div>
    <div class="container__submenu-comments">
      <a href="../web/mod_comments_reported.php" aria-selected="false" id="submenu__item-recipes">Comentarios report.</a>
    </div>
    <div class="container__submenu-categories">
      <a href="../web/mod_categories.php" aria-selected="false" id="submenu__item-recipes">Categorias</a>
    </div>
  </div>
</div>

<div class="container-v5 container__filter--seeker">
  <div class="filter_for">
    <span>Filtrado por</span>
    <div class="btn-group">
      <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="item_actual">Todas</button>
      <ul class="dropdown-menu">
        <li><button class="dropdown-item" type="button">Todas</button></li>
        <li><button class="dropdown-item" type="button">Reportadas</button></li>
        <li><button class="dropdown-item" type="button">Baneadas</button></li>
        <li><button class="dropdown-item" type="button">Usuarios Normales</button></li>
        <li><button class="dropdown-item" type="button">Mods</button></li>
        <li><button class="dropdown-item" type="button">Admins</button></li>
      </ul>
    </div>
  </div>
  <div class="submenu__seeker" style="min-width: 200px;">
    <form class="d-flex" id="select2_form">
      <!--<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">-->
      <select id="select2-accounts" class="form-control mr-2 select2js">
        <!--la clase select2js hace que se muestre el placeholder, si no se agrega se muestra la option default(la primera)-->
        <option></option>
      </select>
      <button class="btn btn-warning" type="submit" style="margin-left: 5px">Search <div id="h"></div></button>
    </form>
  </div>
</div>

<div id="container__specific"></div>


<script src="../../js/mod/accounts.js"></script>
<script src="../../js/mod/mod.js"></script>