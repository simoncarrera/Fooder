<div class="container-v4 sticky-top">


  <nav class="container__menu justify-content-lg-between">
    <a href="home.php" class="container__menu--logo">
      <img class="bi" src="../../images/Logo Fooder icono.PNG" alt="Logo" width="50">
    </a>

    <div class="col-8 col-sm-4 position-relative">
      <form action="../web/searches.php" method="GET" class="container__menu--search " id="principal__seeker">
        <input type="search" class="container__menu--text form-control" placeholder="Buscar..." name="search" value="<?php echo (isset($search)) ? $search : null; ?>" id="principal__seeker--search">

        <button type="submit" class="container__menu--submit"><i class="bi bi-search" style="font-size: 1.2rem; padding-right: 3px;"></i></button>
      </form>
      <div class="container__suggestions " id="search_suggestions">
        <div class="container__suggestions--categories">
          <div id="search_suggestions-categories">
          </div>
        </div>
        <div class="container__suggestions--recipes mt-2">
          <div id="search_suggestions-recipes">
          </div>
        </div>
        <div class="container__suggestions--accounts mt-2">
          <div id="search_suggestions-accounts">
          </div>
        </div>

      </div>
    </div>


    <div class="">
      <ul class="container__menu--nav">
        <li><a href="../web/home.php" title="Inicio" class="container__menu--nav-item"><i class="bi bi-house-door px-2" id="home"></i></a></li>
        <li><a href="../web/recipes_followed.php" title="Recetas seguidas" class="container__menu--nav-item"><i class="bi bi-people px-2" id="recipes_followed"></i></a></li>
        <?php if (isset($_SESSION['user'])) { ?>
          <li><a href="../web/post_recipe.php" title="Publicar recetas" class="container__menu--nav-item"><i class="bi bi-plus-circle px-2" id="post_recipe"></i></a></li>

          <li>
            <div class="dropdown ps-2">
              <button class="btn container__menu--nav-profile dropbtn" id="btn_profile"><img title="Opciones de perfil" id="menu_profile_pic" src="<?php echo profile_image($_SESSION['user']['id']); ?>" alt="foto perfil"></button>

              <div id="dropdown_profile" class="dropdown-content">
                <p class="dropdown-content__name">Iniciado sesión como <b><?php echo $_SESSION['user']['username'] ?></b></p>
                <a class="dropdown-content__profile" href="../web/profile.php?id=<?php echo $_SESSION['user']['id']; ?>">
                  <i class="bi bi-person-circle"></i> Perfil
                  <!--<img src="../../images/icons/user.png" width="18px" >-->
                </a>
                <a class="dropdown-content__setting" href="../web/edit_profile.php">
                  <!--<img src="../../images/icons/settings.png" width="18px" class="me-2" alt="">-->
                  <i class="bi bi-gear"></i> Configuracion
                </a>
                <?php if ($_SESSION['user']['role_id'] == 3) { ?>
                  <a class="dropdown-content__admin" href="../web/mod_accounts.php">
                    <img src="../../images/icons/admin.png" width="18px" class="me-2"> Administrador
                  </a>
                <?php } else if ($_SESSION['user']['role_id'] == 2) { ?>
                  <a class="dropdown-content__moder" href="../web/mod_accounts.php">
                    <img src="../../images/icons/crown.png" width="18px" class="me-2"> Moderador
                  </a>
                <?php } ?>
                <a class="dropdown-content__setting">
                  <i class="bi bi-moon"></i> Modo oscuro
                  <input type="checkbox" class="switch" id="dark_mode_switch">
                  <label for="dark_mode_switch" class="label-switch"></label>

                </a>
                <a class="dropdown-content__logout" href="../web/logout.php">
                  <!--<img src="../../images/icons/log-out.png" width="18px" class=" me-2">-->
                  <i class="bi bi-box-arrow-left"></i> Salir
                </a>

              </div>
            </div>
          </li>
        <?php } else { ?>
          <li><a href="../web/login.php" class="container__menu--nav-item"><i class="bi bi-plus-circle px-2"></i></a></li>
          <li><a href="../web/login.php"><button type="button" class="container__menu--nav-button">Iniciar sesión</button></a></li>

        <?php } ?>
      </ul>
    </div>
  </nav>
</div>