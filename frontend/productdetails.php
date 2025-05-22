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
        <div class="product-details-page-container">
        <?php if ($type == 'shirt'): ?> <!-- and product type = shirt -->
            <section class="product-details-page-shirt-product-wrapper">
                <!-- Product Image - Left side -->
                <div class="product-details-page-image-side">
                    <div class="product-details-page-hero-image">
                        <img src="../<?php echo $product['image']; ?>" alt="<?php echo $product['team'] . ' ' . $product['year'] . ' ' . $product['type'] . ' shirt'; ?>"> <!-- dusplay the products image and form the alt tag based on product info -->
                    </div>
                </div>
                
                <!-- Product Details - Right side -->
                <div class="product-details-page-details-side">
                    <div class="product-details-page-tags-container"> <!-- small product tags -->
                        <div class="product-details-page-tag-item">Team:</div> 
                        <div class="product-details-page-tag-item"><?php echo $product['team']; ?></div> 
                    </div>

                    <!-- Product Name display -->
                    <div class="product-details-page-name-display">
                        <h1>
                            <?php echo $product['team'] . ' ' . $product['type'] . ' Shirt From the ' . $product['year'] . ' Season'; ?> <!-- echo title based on the specific products details -->
                        </h1>
                    </div>
                    
                    <!-- Product secondary info container -->
                    <div class="product-details-page-secondary-info">
                        <div class="product-details-page-rating-display">
                            <p class="product-details-page-rating-subtext"><?php echo $product['rating']; ?></p> <!-- display the products rating -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#f1c40f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="star-icon">
                                <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"/>
                            </svg>
                        </div>
                        <p class="product-details-page-category-display">Category: <?php echo $product['category']; ?></p> <!-- display the products category -->
                        <p class="product-details-page-year-display">Year: <?php echo $product['year']; ?></p> <!-- display the year of the product -->
                    </div>
                    
                    <!-- Product Price -->
                    <div class="product-details-page-price">
                        <h2>£<?php echo $product['price']; ?></h2> <!-- display the products price -->
                    </div>
                    
                    <!-- Size Information -->
                    <div class="product-details-page-size">
                        <p>Size: <span class="product-details-page-size-value"><?php echo $product['size']; ?></span></p> <!-- display the products size -->
                        <a href="#size-guide" class="product-details-page-size-guide-link">Size Guide <span class="product-details-page-size-guide-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down-icon lucide-chevron-down"><path d="m6 9 6 6 6-6"/></svg></span></a> <!-- link to the size guide, futher down the page -->
                    </div>
                    
                    <!-- Unique Item Note -->
                    <div class="product-details-page-unique-item-note">
                        <p>This is a unique item.</p> 
                    </div>
                    
                    <!-- Add to Basket Button-->
                    <form method="POST" action="../backend/addbasket.php"> <!--  add to basket form -->
                        <input type="hidden" name="shirt_id" value="<?php echo $product['shirt_id']; ?>">
                        <button type="submit" class="product-details-page-add-to-cart-button"> <!-- add to basket button -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="product-details-page-shopping-bag-icon">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                <line x1="3" y1="6" x2="21" y2="6"></line>
                                <path d="M16 10a4 4 0 0 1-8 0"></path>
                            </svg>
                            Add to Basket
                        </button><!-- end of add to basket button -->
                    </form> <!-- end of form -->
                    
                    <!-- Product Description -->
                    <div class="product-details-page-description">
                        <h3>Description</h3>
                        <p><?php echo $product['description']; ?></p> <!-- display the product description -->
                    </div>
                </div>
            </section>
            
            <div class="product-details-page-details">
                <h2>Product Details</h2>
                <ul>
                    <li><span class="product-details-page-additional-info-bold">Type:</span> <?php echo $product['type']; ?></li>
                    <li><span class="product-details-page-additional-info-bold">Size:</span> <?php echo $product['size']; ?></li>
                    <li><span class="product-details-page-additional-info-bold">Season:</span> <?php echo $product['year']; ?></li>
                    <li><span class="product-details-page-additional-info-bold">Material:</span> 100% Polyester</li>
                    <li><span class="product-details-page-additional-info-bold">Features:</span> Club Badge, sponsor & breathable fabric</li>
                </ul>
            </div>
            <section class="product-details-page-additional-info product-details-page-care-instructions"> <!-- additional info section -->
                <div class="product-details-page-additional-info-heading">
                    <h2>Care Instructions</h2>
                </div>
                <div class="product-details-page-additional-info-content"><!-- additional info content -->
                    <ul class="product-details-page-care-instructions-list"><!-- care instructions list -->
                        <li><span class="product-details-page-additional-info-bold">Washing: </span>Machine wash on cold setting (30°C)</li>
                        <li><span class="product-details-page-additional-info-bold">Drying: </span>Do not tumble dry</li>
                        <li><span class="product-details-page-additional-info-bold">Ironing: </span>Iron on low heat</li>
                        <li><span class="product-details-page-additional-info-bold">Bleaching: </span>Do not bleach, it may ruin the sponsor or badge</li>
                        <li><span class="product-details-page-additional-info-bold">Storage: </span>Hang in a cool, dry place away from direct sunlight</li>
                     </ul> <!-- end of care instructions list -->
                </div> <!-- end of additional info content -->
            </section> <!-- end of additional info section -->
            <section class="product-details-page-additional-info"> <!-- additional info section -->
                <div class="product-details-page-additional-info-heading">
                    <h2>Condition</h2>
                </div>
                <div class="product-details-page-additional-info-content"><!-- additional info content -->
                    <div class="product-details-page-condition-row"><!-- condition row -->
                   <div class="product-details-page-condition-tag">Excellent Condition</div>
                   <p>10/10 Guaranteed.</p>
                </div><!-- end of condition row -->
                <div class="product-details-page-condition-text"><!-- conditon text -->
                    <p>This shirt is in excellent condition with no signs of wear. The fabric is smooth and fully intact, with no pulls, frays or snags to be found. 
                        Colours are bold and vibrant, showing no fading. All printing, including the sponsor, name and number, as well as the badges, are in perfect shape with no cracking or peeling. 
                        A great example for any fan or collector.
                    </p>
                </div><!-- end of condition text -->
                </div> <!-- end of additional info content -->
            </section> <!-- end of additional info section -->
            <!-- Size Guide Section -->
            <section id="size-guide" class="product-details-page-size-guide-section">
                <h2>Size Guide</h2>
                <table class="product-details-page-size-chart"> <!-- size chart table -->
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