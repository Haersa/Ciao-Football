<?php
// Get team and filter using the get method
$team = isset($_GET['team']) ? $_GET['team'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Set dynamic page information based on team
$pageTitle = $team . " Football Products | Ciao Football"; // This will be used in the title tag
$pageDescription = "Browse " . $team . " football shirts and equipment at Ciao Football."; // This is used as the page desciption meta tag
$pageKeywords = $team . ", football, shirts, Ciao Football"; // This will be used as the keywords meta tag

// Include the header file
include('../components/header.php');

// back to top button
include('../components/backtotopbutton.php');


// Connect to database
include('../backend/conn/conn.php');

?>

<main>
<?php include('../components/producthero.php'); // include the product hero
?>

  <section class="product-grid"><!-- product grid section -->
  <?php 
  // Prepare the SQL statement for non-sale retro products
  $sql = "SELECT * FROM shirts WHERE team = ? AND sale = ? AND quantity > 0";
  
  // Add size filter if selected 
  if (isset($_GET['size']) && $_GET['size'] != 'all' && $_GET['size'] != '') {
      $sql .= " AND size = ?";
      $hasSize = true;
  } else {
      $hasSize = false;
  }
  
  // Add ORDER BY clause based on selected filter
  if (isset($_GET['sort'])) {
      if ($_GET['sort'] == 'price_asc') {
          $sql .= " ORDER BY price ASC";
      } elseif ($_GET['sort'] == 'price_desc') {
          $sql .= " ORDER BY price DESC";
      } elseif ($_GET['sort'] == 'rating') {
          $sql .= " ORDER BY rating DESC";
      }
  }
  
  $stmt = $conn->prepare($sql);

  // Bind parameters
  $sale = "no";
  if ($hasSize) {
      $size = $_GET['size'];
      $stmt->bind_param("sss", $team, $sale, $size);
  } else {
      $stmt->bind_param("ss", $team, $sale);
  }

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
                      echo '<form method="POST" action="../backend/addbasket.php">';
                      echo '<div class="product-details">';
                      echo '<div class = "product-top-row">';// start of top row container
                      echo '<h2 class="product-team">' . $row['team'] . '</h2>'; // team
                      echo '<p class="product-year">' . $row['year'] . '</p>'; // year the kit was used
                      echo '</div>'; // end of top row container
                      echo '<div class = "product-info">'; // start of product info container
                      echo '<p class="product-type">' . $row['type'] . ' ' . 'kit' . '</p>'; // type, either home, away or third kit
                      echo '<p class="product-size">Size: ' . $row['size'] . '</p>'; // size available
                      echo '</div>'; // end of product details container
                      echo '<div class = "product-bottom-row">';
                      echo '<p class="product-category">' . $row['category'] .'</p>'; // shirt category
                      echo '<p class="product-price">£' . number_format($row['price'], 2) . '</p>'; // price formatted with pound symbol
                      echo '</div>';
                      echo '<div class = "product-rating">';
                      echo '<p class = "product-rating-text">Rating: ' . number_format($row['rating'], 1) . '/5' . '</p>';
                      echo '</div>';
                      echo '<div class="product-actions">';
                      echo '<input type="hidden" name="shirt_id" value="' . $row['shirt_id'] . '">';
                      echo '<button type="submit" class="basket-button">Add to Basket</button>'; // add to cart button
                      echo '</form>';
                      echo '<a href="productdetails.php?id=' . $row['shirt_id'] . '" class="view-button">View Details</a>'; // view product details button
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

  
</main>

<?php
// Include the footer file
include('../components/footer.php');
?>

<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>