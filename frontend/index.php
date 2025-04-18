<?php
$pageTitle = "Home"; // This will be used in the title tag
$pageDescription = "Ciao Football's Home Page. Get a feel for our business and ethos while also viewing our premium football products."; // This is used as the page desciption meta tag
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, home page"; // This is used as the keywords meta tag

// Include the header file
include('../components/header.php');
?>

<?php 
// include the back to top button file
include('../components/backtotopbutton.php');
?>
<main>
  <section class="hero"> <!-- hero section -->
  <div class="hero-image">
  <picture>
    <source srcset="../images/heroimage.webp" type="image/webp">
    <source srcset="../images/heroimage.png" type="image/png">
    <img src="../images/heroimage.png" alt="Hero Image">
  </picture>
</div>
    <div class="hero-text">
  <h1 class="hero-title">Ciao Football</h1>
  <p class="hero-description">Where Fans Find their Perfect Kit. High Quality Replica Kits Delivered Worldwide.</p>
  <div class="hero-button">
    <a rel="noopener noreferrer" href="shirts.php">Shop Now</a>
  </div>
</div>
  </section><!-- end of hero section -->

  <section class = "recommended-slider"> <!-- recommended products slider from equipments table -->
    <div class = "recommended-heading">
      <h2>Recommended Products</h2>
    </div>
  <div class="carousel-container">
        <div class="carousel">
            <?php
            // SQL statement for all non-sale equipment products
            $stmt = $conn->prepare("SELECT * FROM equipment WHERE sale = ? LIMIT 9");

            // Bind parameters
            $sale = "no";
            $stmt->bind_param("s", $sale);

            // Execute the query
            $stmt->execute();

            // Get the result
            $result = $stmt->get_result();

            // Check if any products were found
            if ($result->num_rows > 0) {
                // Loop through each product and create carousel cells
                while ($row = $result->fetch_assoc()) {
                    // Create a product card for each item
                    echo '<div class="carousel-cell">';
                    
                    // Display the product image
                    echo '<div class="cell-image">';
                    echo '<img src="../' . $row['image'] . '" alt="' . $row['name'] . ' ' . $row['category'] . ' ' . $row['brand'] . ' product">';
                    echo '</div>';
                    
                    // Product title and view more link
                    echo '<div class="cell-content">';
                    echo '<h2 class="cell-title">' . $row['name'] . '</h2>';
                    echo '<a href="productdetails.php?id=' . $row['equipment_id'] . '" class="view-more">View More</a>';
                    echo '</div>';
                    
                    echo '</div>'; // End carousel cell
                }
            } else {
                echo '<div class="no-products">No recommended products at this time.</div>';
            }

            // Close statement
            $stmt->close();
            ?>
        </div>
        <div class="carousel-arrows">
            <button class="arrow-button prev-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-left-icon lucide-move-left"><path d="M6 8L2 12L6 16"/><path d="M2 12H22"/></svg></button>
            <button class="arrow-button next-arrow"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-right-icon lucide-move-right"><path d="M18 8L22 12L18 16"/><path d="M2 12H22"/></svg></button>
        </div>
    </div>
</section><!-- end of recommended products slider -->


  <div class = "feature-heading">
        <h2>Most Popular</h2>
    </div>

  <section class="feature-container"> <!-- feature container -->
        <div class="box">
        <img src="../images/retrokit.png" class = "retro-img"  alt="Featured product 1">
            <div class="feature-overlay">
                <h2>Retro Kits</h2>
                <a href="retrokits.php" rel = "noopener noreferrer" class="feature-button">Shop Now</a>
            </div>
        </div>
        
        <div class="box">
            <img src="../images/specialist.png" class = "specialist-img" alt="Featured product 2">
            <div class="feature-overlay">
                <h2>Specialist Kits</h2>
                <a href="specialistkits.php" rel = "noopener noreferrer" class="feature-button">Shop All</a>
            </div>
        </div>
  </section> <!-- end of feature container -->

  <section class="benefits-container"> <!-- benefits container -->
  <div class="benefits-heading">
    <h2>Member Benefits</h2>
  </div>
  <div class="benefits-text">
    <p>Ciao Football Members gain access to:</p>
  </div>
  <div class="benefits-grid"> <!-- start of benefits grid -->
    <div class="benefit-item"> <!-- benefit item 1 -->
      <div class="benefit-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-tags"><path d="m15 5 6.3 6.3a2.4 2.4 0 0 1 0 3.4L17 19"/><path d="M9.586 5.586A2 2 0 0 0 8.172 5H3a1 1 0 0 0-1 1v5.172a2 2 0 0 0 .586 1.414L8.29 18.29a2.426 2.426 0 0 0 3.42 0l3.58-3.58a2.426 2.426 0 0 0 0-3.42z"/><circle cx="6.5" cy="9.5" r=".5" fill="currentColor"/></svg>
      </div>
      <div class="benefit-text">
        <h3>Exclusive Sales</h3>
        <p>Sale items are only available to Ciao Football Members.</p>
      </div>
    </div><!-- end of benefit item 1 -->
    
    <div class="benefit-item"> <!-- benefit item 2 -->
      <div class="benefit-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shirt"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>
      </div>
      <div class="benefit-text">
        <h3>Pre-Order Access</h3>
        <p>Shop new shirt releases before they're available to the public.</p>
      </div>
    </div><!-- end of benefit item 2 -->
    
    <div class="benefit-item"> <!-- benefit item 3 -->
      <div class="benefit-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-headphones"><path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3zM3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/></svg>
      </div>
      <div class="benefit-text">
        <h3>Priority Support</h3>
        <p>Get dedicated customer service with faster response times.</p>
      </div>
    </div><!-- end of benefit item 3 -->
    
    <div class="benefit-item"> <!-- benefit item 4 -->
      <div class="benefit-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package-check"><path d="m16 16 2 2 4-4"/><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/><path d="M16.5 9.4 7.55 4.24"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" y1="22" x2="12" y2="12"/></svg>
      </div>
      <div class="benefit-text">
        <h3>Priority Processing</h3>
        <p>Ciao Football memebers receive priority order processing.</p>
      </div>
    </div><!-- end of benefit item 4 -->
    
    <div class="benefit-item"> <!-- benefit item 5 -->
      <div class="benefit-icon">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-undo-2"><path d="M9 14 4 9l5-5"/><path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11"/></svg>      
    </div>
      <div class="benefit-text">
        <h3>Extended Returns</h3>
        <p>Ciao Football members get extended return windows.</p>
      </div>
    </div><!-- end of benefit item 5 -->
    
    <div class="benefit-item"> <!-- benefit item 6 -->
      <div class="benefit-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-ticket"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><path d="M13 5v2"/><path d="M13 17v2"/><path d="M13 11v2"/></svg>
      </div>
      <div class="benefit-text">
        <h3>Match Ticket Raffles</h3>
        <p>Enter monthly draws for the chance to win football match tickets.</p>
      </div>
    </div><!-- end of benefit item 6 -->
  </div><!-- end of benefit grid -->

  <div class="index-register-section">
    <a href="register.php" rel="noopener noreferrer">Register Now</a>
  </div>
</section><!-- end of member benefits section -->

<section class="price-points"><!-- price points section startys -->
  <!-- Section Header -->
  <div class="price-points-heading">
    <h2>Shop by Price</h2>
  </div>
  <div class="price-points-text">
    <p>Find products that match your budget</p>
  </div>
  
  <!-- Price Points Grid -->
  <div class="price-points-grid">
    <!-- Grid Item 1 -->
    <div class="price-points-grid-item">
      <div class="item-heading">
        <h3>Under £50</h3>
      </div>
      <div class="item-content">
        <p>Affordable gear without breaking the bank.</p>
      </div>
      <div class="price-link-container">
          <a class = "item-link" href="shop.php?price=under50" rel="noopener noreferrer">Shop Now</a>
      </div>
    </div>
    
    <!-- Grid Item 2 -->
    <div class="price-points-grid-item">
      <div class="item-heading">
        <h3>£50 - £75</h3>
      </div>
      <div class="item-content">
        <p>Premium apparel at mid ranged prices.</p>
      </div>
      <div class="price-link-container">
        <a class = "item-link" href="shop.php?price=50-75" rel="noopener noreferrer">Shop Now</a>
      </div>
    </div>
    
    <!-- Grid Item 3 -->
    <div class="price-points-grid-item">
      <div class="item-heading">
        <h3>£75 - £100</h3>
      </div>
      <div class="item-content">
        <p>High quality merchandise for dedicated fans.</p>
      </div>
      <div class="price-link-container">
        <a class = "item-link" href="shop.php?price=75-100" rel="noopener noreferrer">Shop Now</a>
      </div>
    </div>
    
    <!-- Grid Item 4 -->
    <div class="price-points-grid-item">
      <div class="item-heading">
        <h3>Over £100</h3>
      </div>
      <div class="item-content">
        <p>Elite collection, for the true football fan.</p>
      </div>
      <div class="price-link-container">
        <a class = "item-link" href="shop.php?price=over100" rel="noopener noreferrer">Shop Now</a>
      </div>
    </div>
  </div>
</section><!-- price points section ends -->

<section class="team-quick-link"> <!-- quick team navigation starts -->
  <div class="quick-link-heading">
    <h2>Shop by Team</h2>
  </div>
  <div class="team-quick-navigation-container"> <!-- quick team container starts -->
    <div class="quick-link-grid"> <!-- quick link grid starts -->
      
      <!-- Celtic FC -->
      <div class="quick-link-grid-item">
        <div class="quick-link-overlay">
          <h3>Celtic FC</h3>
          <a href="team.php?team=Celtic" rel="noopener noreferrer">Shop Now</a>
        </div>
        <img src="../images/celticbadge.png" alt="Celtic FC">
      </div>
      
      <!-- Real Madrid -->
      <div class="quick-link-grid-item">
        <div class="quick-link-overlay">
          <h3>Real Madrid</h3>
          <a href="team.php?team=Real Madrid" rel="noopener noreferrer">Shop Now</a>
        </div>
        <img src="../images/realmadridbadge.png" alt="Real Madrid">
      </div>
      
      <!-- Arsenal FC -->
      <div class="quick-link-grid-item">
        <div class="quick-link-overlay">
          <h3>Arsenal FC</h3>
          <a href="team.php?team=Arsenal" rel="noopener noreferrer">Shop Now</a>
        </div>
        <img src="../images/arsenalbadge.png" alt="Arsenal FC">
      </div>
      
      <!-- Inter Milan -->
      <div class="quick-link-grid-item">
        <div class="quick-link-overlay">
          <h3>Inter Milan</h3>
          <a href="team.php?team=Inter Milan" rel="noopener noreferrer">Shop Now</a>
        </div>
        <img src="../images/interbadge.png" alt="Inter Milan">
      </div>
      
      <!-- Barcelona -->
      <div class="quick-link-grid-item">
        <div class="quick-link-overlay">
          <h3>Barcelona</h3>
          <a href="team.php?team=Barcelona" rel="noopener noreferrer">Shop Now</a>
        </div>
        <img src="../images/barcabadge.png" alt="Barcelona">
      </div>
      
      <!-- Liverpool FC -->
      <div class="quick-link-grid-item">
        <div class="quick-link-overlay">
          <h3>Liverpool FC</h3>
          <a href="team.php?team=Liverpool" rel="noopener noreferrer">Shop Now</a>
        </div>
        <img src="../images/liverpoolbadge.png" alt="Liverpool FC">
      </div>
      
      <!-- Juventus -->
      <div class="quick-link-grid-item">
        <div class="quick-link-overlay">
          <h3>Juventus</h3>
          <a href="team.php?team=Juventus" rel="noopener noreferrer">Shop Now</a>
        </div>
        <img src="../images/juvebadge.png" alt="Juventus">
      </div>
      
      <!-- Manchester United -->
      <div class="quick-link-grid-item">
        <div class="quick-link-overlay">
          <h3 class="team-name">Manchester United</h3>
          <h3 class="small-text">Man Utd</h3>
          <a href="team.php?team=Man Utd" rel="noopener noreferrer">Shop Now</a>
        </div>
        <img src="../images/manutdbadge.png" alt="Manchester United">
      </div>
      
    </div><!-- quick link grid ends -->
  </div><!-- quick team container ends -->
</section><!-- quick team navigation ends -->


<?php
// Inlude the reviews file
include('../components/Ciaoreviews.php');
?>

<?php 
// Inlude the newsletter sign up form file
include('../components/newsletter.php');
?>

</main>

<?php
// Inlude the footer file
include('../components/footer.php');
?>


<script src="../js/app.js"></script>
<script src="../js/flickity.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flickity/2.3.0/flickity.pkgd.min.js"></script>
</body>
</html>