<?php if($cant_featured_categories > 0) {?>
  <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
    <div class="carousel-indicators">
      <?php
      foreach ($rowFeaturedCategories as $key => $featured_category) { ?>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="<?php echo $key; ?>" <?php echo ($key == 0) ? 'class="active" aria-current="true"' : null; ?> aria-label="Slide <?php echo $key; ?>"></button>
      <?php
      } ?>
    </div>
    <!--Inicio del carousel-->
    <div class="carousel-inner">
      <?php
      foreach ($rowFeaturedCategories as $key => $featured_category) { ?>
        <div class="carousel-item <?php echo ($key == 0) ? 'active' : null; ?>">
          <a href="searches.php?search=<?php echo $featured_category['name']; ?>&filter=categories">
            <div class="overlay-image" style="background-image:url(../../images/categories/<?php echo $featured_category['id'] . "/" . category_pics($featured_category['id'])[0]; ?>);"></div>
          </a>
          <div class="carousel-caption d-md-block">
            <h3><?php echo $featured_category['name']; ?></h3>
            <p>Categoría destacada</p>
          </div>
        </div>
      <?php
      } ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
<?php 
}?>

<div id="container__recipes">

</div>


<script src="../../js/recipes.js" type="text/javascript"></script>
<script src="../../js/reports.js" type="text/javascript"></script>
<script src="../../js/likes.js" type="text/javascript"></script>
<script src="../../js/delete.js" type="text/javascript"></script>