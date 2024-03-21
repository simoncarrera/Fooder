<div class="container-v5">
  <div class="container__submenu">
    <div class="container__submenu--recipes">
      <a href="../web/searches.php?search=<?php echo $search; ?>" aria-selected="<?php echo ($option == 1) ? 'true' : 'false'; ?>" id="item__submenu--recipes">Recetas</a>
    </div>
    <div class="container__submenu-accounts">
      <a href="../web/searches.php?search=<?php echo $search; ?>&for=user" aria-selected="<?php echo ($option == 1) ? 'false' : 'true'; ?>" id="item__submenu--accounts">Cuentas</a>
    </div>
  </div>
</div>

<?php
if ($option == 1) { ?>
  <div class="container-v5 p-2">
    <span>Buscado por</span>
    <div class="btn-group">
      <button class="btn btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="item_actual">Títulos</button>
      <ul class="dropdown-menu">
        <li><button class="dropdown-item" type="button">Títulos</button></li>
        <li><button class="dropdown-item" type="button">Categorías</button></li>
        <li><button class="dropdown-item" type="button">Ingredientes</button></li>
      </ul>
    </div>
  </div>
<?php
} ?>

<div id="container__<?php echo ($option == 1) ? 'recipes' : 'profiles'; ?>"></div>

<?php
if ($option == 1) { ?>
  <script src="../../js/recipes.js" type="text/javascript"></script>
  <script src="../../js/delete.js" type="text/javascript"></script>
<?php
} else { ?>
  <script src="../../js/miniprofiles.js" type="text/javascript"></script>
<?php
} ?>
<script src="../../js/reports.js" type="text/javascript"></script>
<script src="../../js/likes.js" type="text/javascript"></script>
<script src="../../js/follows.js" type="text/javascript"></script>