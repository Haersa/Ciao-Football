<?php

$pageTitle = "Specialist Kits"; // This will be used in the title tag
$pageDescription = "Ciao Football's Specialist Kit's page. View our premium quality specialist replica kits";  // This is used as the page desciption meta tag
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store,  premium, kits, specialist, specialist kits page"; // This is used as the keywords meta tag

// Include the header file
include('../components/header.php');
?>
<?php 
// back to top button
include('../components/backtotopbutton.php');
?>


<!-- Main content of the page starts here -->
<main>
  <section class="product-hero"><!-- product page hero section -->
    <div class="product-heading">
      <h1>Specialist Replica Shirts</h1>
    </div>
  </section><!-- end of product page hero section -->
  
  <section class="product-grid"><!-- product grid section -->
    <?php 
    // Prepare the SQL statement for non-sale retro products
    $stmt = $conn->prepare("SELECT * FROM shirts WHERE category = ? AND sale = ?");

    // Bind parameters
    $category = "specialist";
    $sale = "no";
    $stmt->bind_param("ss", $category, $sale);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check if any products were found
    if ($result->num_rows > 0) {
        // If a product is found
        echo '<div class="products-container">';
        
        // Use while loop to display each product
        while ($row = $result->fetch_assoc()) { 
            // Create a product card for each item
            echo '<div class="product-card">';
            
            // display the product image from productimages folder
            echo '<div class="product-image">';
            echo '<img src="../' . $row['image']  . '" alt="' . $row['team'] . ' ' .  $row['year']. ' ' . $row['type'] . ' ' . ' shirt">'; // use product data to form the alt tag
            echo '</div>';
            
            // Product details
            echo '<div class="product-details">';
            echo '<div class = "product-top-row">';// start of top row container
            echo '<h3 class="product-team">' . $row['team'] . '</h3>'; // team
            echo '<p class="product-year">' . $row['year'] . '</p>'; // year the kit was used
            echo '</div>'; // end of top row container
            echo '<div class = "product-info">'; // start of product info container
            echo '<p class="product-type">' . $row['type'] . ' ' . 'kit' . '</p>'; // type, either home, away or third kit
            echo '<p class="product-size">Size: ' . $row['size'] . '</p>'; // size available
            echo '</div>'; // end of product details container
            echo '<div class = "product-bottom-row">';
            echo '<p class="product-price">£' . number_format($row['price'], 2) . '</p>'; // price formatted with pound symbol
            echo '</div>';
            echo '<div class="product-actions">';
            echo '<a  rel = "noopener noreferrer" href="productdetails.php?id=' . $row['shirt_id'] . '" class="view-button">View Details</a>'; // view product details button
            echo '<button class="basket-button" data-id="' . $row['shirt_id'] . '">Add to Basket</button>'; // add to cart button
            echo '</div>';
            echo '</div>';
            
            echo '</div>'; // End product card
        }
        
        echo '</div>'; // End products container
    } else {
        echo '<div class="no-products">No non-sale retro shirts found</div>'; // if no products are found, display this error to user
    }

    // Close statement
    $stmt->close();
    ?>
  </section><!-- end of product grid section -->
</main>

<?php
// Inlude the footer file
include('../components/footer.php');
?>

<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>