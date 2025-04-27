<?php
$pageTitle = "Shop"; // This will be used in the title tag
$pageDescription = "Ciao Football's Shop Page. View all of our products."; // This is used as the page desciption meta tag
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, shop, shop page, products"; // This is used as the keywords meta tag

// Include the header file 
include('../components/header.php');
?>


<?php
// Include the back to top button file
include('../components/backtotopbutton.php');
?>

<?php
// query variables, kept empty for now
$priceFilter = "";
$equipmentSql = "";
$shirtsSql = "";
$rangeText = "";

// Check if price parameter exists in URL
if (isset($_GET['price'])) {
    $priceRange = $_GET['price'];
    
    // WHERE clause based on price range
    if ($priceRange == 'under50') {
        $priceFilter = "WHERE price < 50 AND sale = 'no'";
        $rangeText = "Under £50";
    } else if ($priceRange == '50-75') {
        $priceFilter = "WHERE price >= 50 AND price <= 75 AND sale = 'no'";
        $rangeText = "£50 - £75";
    } else if ($priceRange == '75-100') {
        $priceFilter = "WHERE price > 75 AND price <= 100 AND sale = 'no'";
        $rangeText = "£75 - £100";
    } else if ($priceRange == 'over100') {
        $priceFilter = "WHERE price > 100 AND sale = 'no'";
        $rangeText = "Over £100";
    }
} 

// Query for equipment table
$equipmentSql = "SELECT * FROM equipment " . $priceFilter . " ORDER BY price ASC";
$equipmentResult = mysqli_query($conn, $equipmentSql);

// Query for shirts table
$shirtsSql = "SELECT * FROM shirts " . $priceFilter . " ORDER BY price ASC";
$shirtsResult = mysqli_query($conn, $shirtsSql);
?>

<main>
    <div class="shop-container">
        <h1>Our Products</h1>
        
        <?php if (isset($_GET['price']) && !empty($rangeText)): ?>
            <div class="filter-notice">
                <p>Showing products in price range: <strong><?php echo $rangeText; ?></strong></p>
                <a  href="shop.php">Clear filter</a>
            </div>
        <?php endif; ?>
        
        <div class="products-grid">
            <!-- Equipment Products -->
            <?php if (mysqli_num_rows($equipmentResult) > 0): ?>
                <?php while($equipment = mysqli_fetch_assoc($equipmentResult)): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <img src="<?php echo $equipment['image']; ?>" alt="<?php echo $equipment['name']; ?>">
                        </div>
                        <div class="product-info">
                            <h3><?php echo $equipment['name']; ?></h3>
                            <p class="product-category"><?php echo $equipment['category']; ?></p>
                            <p class="product-description"><?php echo $equipment['description']; ?></p>
                            <p class="product-price">£<?php echo number_format($equipment['price'], 2); ?></p>
                            <a href="product.php?type=equipment&id=<?php echo $equipment['equipment_id']; ?>" class="view-product-btn">View Product</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
            
            <!-- Shirts Products -->
            <?php if (mysqli_num_rows($shirtsResult) > 0): ?>
                <?php while($shirt = mysqli_fetch_assoc($shirtsResult)): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <img src="<?php echo $shirt['image']; ?>" alt="<?php echo $shirt['team']; ?>">
                        </div>
                        <div class="product-info">
                            <h3><?php echo $shirt['team']; ?></h3>
                            <p class="product-category"><?php echo $shirt['category']; ?></p>
                            <p class="product-details">
                                <?php echo $shirt['type']; ?> | 
                                <?php echo $shirt['size']; ?> | 
                                <?php echo $shirt['year']; ?>
                            </p>
                            <p class="product-price">£<?php echo number_format($shirt['price'], 2); ?></p>
                            <a href="product.php?type=shirts&id=<?php echo $shirt['shirt_id']; ?>" class="view-product-btn">View Product</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
            
            <?php if (mysqli_num_rows($equipmentResult) == 0 && mysqli_num_rows($shirtsResult) == 0): ?>
                <div class="no-products">
                    <p>No products found in this price range.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php
// Include the footer file
include('../components/footer.php');
?>

<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>