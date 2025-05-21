<?php
// Default meta values
$pageTitle = "Product Details"; 
$pageDescription = "Product Details, get all the relevant info to your favourite product."; 
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, "; 

// Get product ID and type from URL
$id = isset($_GET['id']) ? $_GET['id'] : null;
$type = isset($_GET['type']) ? $_GET['type'] : null;

// Connect to database (for whatever reason even though the db connection is inside the header file, removing this will cause the page to crash, so it has to stay in)
include('../backend/conn/conn.php');

// Load product based on type
$product = null; // set to null, as it will be appended later on when the query returns the result
if ($id && $type) {
    if ($type == 'shirt') {
        // query the shirts table
        $query = "SELECT * FROM shirts WHERE shirt_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result && mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result); // append the query result to product variable
            // Update meta tag to show the uniqie products details inside the meta tags
            $pageTitle = $product['team'] . " " . $product['type'] . " Kit";
        }
    } 
    elseif ($type == 'equipment') {
        // query the equiupment table
        $query = "SELECT * FROM equipment WHERE equipment_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result && mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result); // append the query result to product variable
            // Update meta tag to show the unique products details inside the meta tags
            $pageTitle = $product['name'];
        }
    }
}

// Include the header file
include('../components/header.php');

// Include the back to top button file
include('../components/backtotopbutton.php');
?>

<!-- css for this page starts at line 3079 -->

<main>
    <?php if ($product): ?> <!-- if product exists -->
        <div class="product-details-container">
        <?php if ($type == 'shirt'): ?> <!-- and product type = shirt -->
            <section class="shirt-product-wrapper">
                <!-- Product Image - Left side -->
                <div class="product-image-side">
                    <div class="product-details-hero-image">
                        <img src="../<?php echo $product['image']; ?>" alt="<?php echo $product['team'] . ' ' . $product['year'] . ' ' . $product['type'] . ' shirt'; ?>"> <!-- dusplay the products image and form the alt tag based on product info -->
                    </div>
                </div>
                
                <!-- Product Details - Right side -->
                <div class="product-details-side">
                    <div class="product-tags-container"> <!-- small product tags -->
                        <div class="product-tag-item">Team:</div> 
                        <div class="product-tag-item"><?php echo $product['team']; ?></div> 
                    </div>

                    <!-- Product Name display -->
                    <div class="product-name-display">
                        <h1>
                            <?php echo $product['team'] . ' ' . $product['type'] . ' Shirt From the ' . $product['year'] . ' Season'; ?> <!-- echo title based on the specific products details -->
                        </h1>
                    </div>
                    
                    <!-- Product secondary info container -->
                    <div class="product-secondary-info">
                        <div class="product-rating-display">
                            <p class="rating-subtext"><?php echo $product['rating']; ?></p> <!-- display the products rating -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f1c40f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="star-icon">
                                <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"/>
                            </svg>
                        </div>
                        <p class="product-category-display">Category: <?php echo $product['category']; ?></p> <!-- display the products category -->
                        <p class="product-year-display">Year: <?php echo $product['year']; ?></p> <!-- display the year of the product -->
                    </div>
                    
                    <!-- Product Price -->
                    <div class="product-price">
                        <h2>£<?php echo $product['price']; ?></h2> <!-- display the products price -->
                    </div>
                    
                    <!-- Size Information -->
                    <div class="product-size">
                        <p>Size: <span class="size-value"><?php echo $product['size']; ?></span></p> <!-- display the products size -->
                        <a href="#size-guide" class="size-guide-link">Size Guide</a> <!-- link to the size guide, futher down the page -->
                    </div>
                    
                    <!-- Unique Item Note -->
                    <div class="unique-item-note">
                        <p>This is a unique item</p> 
                    </div>
                    
                    <!-- Add to Cart Button-->
                    <form method="POST" action="../backend/addbasket.php"> <!--  add to basket form -->
                        <input type="hidden" name="shirt_id" value="<?php echo $product['shirt_id']; ?>">
                        <button type="submit" class="add-to-cart-button"> <!-- add to basket button -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shopping-bag-icon">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                            Add to Cart
                        </button><!-- end of add to basket button -->
                    </form> <!-- end of form -->
                    
                    <!-- Product Description -->
                    <div class="product-description">
                        <h3>Description</h3>
                        <p><?php echo $product['description']; ?></p> <!-- display the product description -->
                    </div>
                </div>
            </section>
            
            <!-- Size Guide Section -->
            <section id="size-guide" class="size-guide-section">
                <h2>Size Guide</h2>
                <table class="size-chart"> <!-- size chart table -->
                    <thead>
                        <tr>
                            <th>Size</th>
                            <th>Chest (cm)</th>
                            <th>Waist (cm)</th>
                            <th>Hip (cm)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>XS</td>
                            <td>86-91</td>
                            <td>71-76</td>
                            <td>86-91</td>
                        </tr>
                        <tr>
                            <td>S</td>
                            <td>91-96</td>
                            <td>76-81</td>
                            <td>91-96</td>
                        </tr>
                        <tr>
                            <td>M</td>
                            <td>96-101</td>
                            <td>81-86</td>
                            <td>96-101</td>
                        </tr>
                        <tr>
                            <td>L</td>
                            <td>101-106</td>
                            <td>86-91</td>
                            <td>101-106</td>
                        </tr>
                        <tr>
                            <td>XL</td>
                            <td>106-111</td>
                            <td>91-96</td>
                            <td>106-111</td>
                        </tr>
                    </tbody>
                </table><!-- end of size chart table -->
                <div class="measuring-guide">
                    <h3>How to Measure</h3>
                    <p>For the best fit, take measurements directly over your underwear. Hold the tape measure firmly, but not too tight.</p>
                    <ul>
                        <li><span class = "table-bold-heading">Chest:</span> Measure around the fullest part of your chest, keeping the tape horizontal.</li>
                        <li><span class = "table-bold-heading">Waist:</span> Measure around your natural waistline, keeping the tape comfortably loose.</li>
                        <li><span class = "table-bold-heading">Hip:</span> Stand with your feet together and measure around the fullest part of your hips.</li>
                    </ul>
                </div>
            </section>
            <section class = "additional-info">


            </section>
        <?php endif; ?>
        
        <?php if ($type == 'equipment'): ?> <!-- and product type = equipment -->
            <!-- Equipment product layout here -->
        <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="product-not-found">
            <h2>Product not found</h2>
            <p>Sorry, the product you're looking for could not be found.</p>
        </div>
    <?php endif; ?>
</main>

<?php
// Include the footer file
include('../components/footer.php');
?>

<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>