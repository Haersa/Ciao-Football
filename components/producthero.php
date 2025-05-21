<section class="product-hero"><!-- product page hero section -->
    <div class="product-top-row">
      <div class = "product-heading"><!-- product heading -->
      <h1><?php echo $pageTitle; ?></h1>
      </div><!-- end of product heading -->
    <div class = "product-controls-container"><!-- product controls container -->
      <div class = "product-controls"><!-- product controls -->
      <form method="GET" action="" id="filter-form">
        <!-- Sort filter -->
        <select class="product-filter-button" name="sort" id="sort-filter" aria-label="Sort by Filter" onchange="this.form.submit()">
          <option value="" selected disabled hidden class="product-sort-button">Sort by:</option>
          <option value="price_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : ''; ?>>Price: Lowest</option>
          <option value="price_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : ''; ?>>Price: Highest</option>
        </select>
        
        <!-- Size filter -->
        <select class="product-filter-button" name="size" id="size-filter" aria-label="Filter by Size" onchange="this.form.submit()">
          <option value="" selected disabled hidden>Size:</option>
          <option value="XS" <?php echo (isset($_GET['size']) && $_GET['size'] == 'XS') ? 'selected' : ''; ?>>Size: XS</option>
          <option value="S" <?php echo (isset($_GET['size']) && $_GET['size'] == 'S') ? 'selected' : ''; ?>>Size: S</option>
          <option value="M" <?php echo (isset($_GET['size']) && $_GET['size'] == 'M') ? 'selected' : ''; ?>>Size: M</option>
          <option value="L" <?php echo (isset($_GET['size']) && $_GET['size'] == 'L') ? 'selected' : ''; ?>>Size: L</option>
          <option value="XL" <?php echo (isset($_GET['size']) && $_GET['size'] == 'XL') ? 'selected' : ''; ?>>Size: XL</option>
          <option value="all" <?php echo (isset($_GET['size']) && $_GET['size'] == 'all') ? 'selected' : ''; ?>>All Sizes</option>
        </select>
      </form><!-- end of product filter button -->
      </div><!-- end of product controls -->
    </div><!-- product controls container -->
    </div><!-- end of product top row -->
</section><!-- end of product page hero section -->