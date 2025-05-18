<?php

$pageTitle = "All Shirts"; // This will be used in the title tag
$pageDescription = "Ciao Football's Product's Page. View our premium football products and browse around."; // This is used as the page desciption meta tag
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, shirts page, products"; // This is used as the keywords meta tag

// Include the header file
include('../components/header.php');
?>
<?php 
// back to top button
include('../components/backtotopbutton.php');
?>

<!-- Main content of the page starts here -->
<main>
  <?php include('../components/producthero.php'); 
  ?>
  
  <section class="product-grid"><!-- product grid section -->
    <?php 
    // Prepare the SQL statement
    $sql = "SELECT * FROM shirts WHERE sale = ? AND quantity > 0";
    
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
        $stmt->bind_param("ss", $sale, $size);
    } else {
        $stmt->bind_param("s", $sale);
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
        
        echo '<div class="product-year-tag">' . $row['year'] . '</div>';
        
        // display the product image from productimages folder
        echo '<div class="product-image">';
        echo '<img src="../' . $row['image']  . '" alt="' . $row['team'] . ' ' .  $row['year']. ' ' . $row['type'] . ' ' . ' shirt">'; // use product data to form the alt tag
        echo '</div>';
        
        // Product details
        echo '<form method="POST" action="../backend/addbasket.php">';
        echo '<div class="product-details">';
        
        echo '<div class="product-info-row">';
        echo '<div class="product-team">' . $row['team'] . '</div>'; 
        echo '<div class="product-size">Size: ' . $row['size'] . '</div>';
        echo '</div>';
        
        echo '<div class="product-info-row">';
        echo '<div class="product-type">' . $row['category'] . '</div>';
        echo '<div class="product-price">£' . number_format($row['price'], 2) . '</div>'; // price formatted with pound symbol
        echo '</div>';
        
        echo '<div class="product-actions">';
        echo '<input type="hidden" name="shirt_id" value="' . $row['shirt_id'] . '">';
        echo '<button type="submit" class="basket-button"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-bag-icon lucide-shopping-bag"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg></button>'; // add to cart button
        echo '</form>';
        echo '<a href="productdetails.php?id=' . $row['shirt_id'] . '&type=shirt" class="view-button">View More</a>'; // view product details button
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
// Include the footer file
include('../components/footer.php');
?>

<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

</body>
</html>