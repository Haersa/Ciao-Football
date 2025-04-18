<?php
// Get team and filter using the get method
$team = isset($_GET['team']) ? $_GET['team'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Redirect if no team is specified
if (empty($team)) {
    header("Location: index.php");
    exit;
}

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

// SQL query based on filter
if ($filter == 'all') {
    $sql = "SELECT * FROM shirts WHERE team = '$team'"; // if no filter is applied, show all products
} else {
    $sql = "SELECT * FROM shirts WHERE team = '$team' AND type = '$filter'"; // if filter is applied, show only products that match the filter
}

// Run the query
$result = $conn->query($sql);
?>

  <!-- Filter options -->
  <section class="team-filters">
    <div class="team-filter-container">
      <h2>Filter Products</h2>
      <div class="filter-buttons">
        <a href="team.php?team=<?php echo $team; ?>" class="filter-btn <?php if($filter == 'all') echo 'active'; ?>">All Products</a> <!-- if no filter is applied, show all products -->
        <a href="team.php?team=<?php echo $team; ?>&filter=replica" class="filter-btn <?php if($filter == 'replica') echo 'active'; ?>">Replica Kits</a> <!-- if filter is replica, show replica products -->
        <a href="team.php?team=<?php echo $team; ?>&filter=retro" class="filter-btn <?php if($filter == 'retro') echo 'active'; ?>">Retro Kits</a> <!-- if filter is retro, show retro products -->
        <a href="team.php?team=<?php echo $team; ?>&filter=specialist" class="filter-btn <?php if($filter == 'specialist') echo 'active'; ?>">Specialist</a> <!-- if filter is specialist, show specialist products -->
      </div>
    </div>
  </section>


<!-- Main content of the page starts here -->
<section>
  <h1><?php echo $team; ?> Products</h1>
  <p>Explore our selection of
    <?php 
    if($filter == 'replica') { // if filter is replica, show replica inside hero text
      echo 'Replica';
    } elseif($filter == 'Retro') { // if filter is retro, show retro inside hero text
      echo 'retro';
    } elseif($filter == 'specialist') { // if filter is specialist, show specialist inside hero text
      echo 'Specialist'; 
    }
    ?> <?php echo $team; // echo the team name ?> Football Shirts</p>
</section>
  
<!-- Main content of the page starts here -->
<main>
  <section class="product-hero"><!-- product page hero section -->
    <div class="product-heading">
      <?php
      echo '<h1>' . $team . ' Replica Shirts</h1>';
      ?>
    </div>
  </section><!-- end of product page hero section -->
  
  <section class="product-grid"><!-- product grid section -->
    <?php 
    // Prepare the SQL statement for non-sale retro products
    $stmt = $conn->prepare("SELECT * FROM shirts WHERE team = ? AND sale = ?");

    // Bind parameters
    $category = $team;
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
            echo '<h2 class="product-team">' . $row['team'] . '</h2>'; // team
            echo '<p class="product-year">' . $row['year'] . '</p>'; // year the kit was used
            echo '</div>'; // end of top row container
            echo '<div class = "product-info">'; // start of product info container
            echo '<p class="product-type">' . $row['type'] . ' ' . 'kit' . '</p>'; // type, either home, away or third kit
            echo '<p class="product-size">Size: ' . $row['size'] . '</p>'; // size available
            echo '</div>'; // end of product details container
            echo '<div class = "product-bottom-row">';
            echo '<p class="product-category">' . $row['category'] . '</p>'; // shirt category
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

  
</main>

<?php
// Include the footer file
include('../components/footer.php');
?>

<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>