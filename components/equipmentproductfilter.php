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
          <option value="rating" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'rating') ? 'selected' : ''; ?>>Rating</option>
        </select>
        
        <!-- Type filter -->
        <select class="product-filter-button" name="size" id="size-filter" aria-label="Filter by Size" onchange="this.form.submit()">
          <option value="" selected disabled hidden>Type:</option>
          <option value="training" <?php echo (isset($_GET['category']) && $_GET['category'] == 'training') ? 'selected' : ''; ?>>Type: Training</option>
          <option value="match" <?php echo (isset($_GET['category']) && $_GET['category'] == 'match') ? 'match' : ''; ?>>Type: Match</option>
          <option value="accessories" <?php echo (isset($_GET['category']) && $_GET['category'] == 'accessories') ? 'accessories' : ''; ?>>Type: Accessories</option>
          <option value="all" <?php echo (isset($_GET['category']) && $_GET['category'] == 'all') ? 'selected' : ''; ?>>All Types</option>
        </select>
      </form><!-- end of product filter button -->
      </div><!-- end of product controls -->
    </div><!-- product controls container -->
    </div><!-- end of product top row -->
</section><!-- end of product page hero section -->