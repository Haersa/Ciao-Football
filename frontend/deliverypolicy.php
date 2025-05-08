<?php

$pageTitle = "Delivery Policy"; // This will be used in the title tag
$pageDescription = "View our Delivery Policy. We will deliver your order as soon as possible."; // This is used as the page desciption meta tag
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, delivery, policy, delivery policy."; // This is used as the keywords meta tag

// Include the header file
include('../components/header.php');
?>
<?php 
// back to top button
include('../components/backtotopbutton.php');
?>

<!-- Main content of the page starts here -->
<main>
 
<section class = "policy-container"><!-- start of the policy container -->

<div class = "policy-header"><!-- start of policy header -->
  <div class = "policy-header-content"><!-- start of policy header content-->
    <div class = "policy-header-title"><!-- start of policy title -->
      <h1>Delivery Policy</h1>
    </div><!-- end of policy title -->
    <p class = "policy-last-updated">
      Last updated: July 14th, 2024</p>
  </div><!-- start of policy header content-->
</div><!-- end of policy header -->

<section class = "policy-content-container"><!-- policy content container -->
  <div class = "policy-quick-links"><!-- start of quick links -->
    <h2>Contents</h2>
    <ul>
      <li><a href = "#delivery-section1">1. Shipping Information</a></li>
      <li><a href = "#delivery-section2">2. Delivery Timeframes</a></li>
      <li><a href = "#delivery-section3">3. International Shipping</a></li>
      <li><a href = "#delivery-section4">4. Insurance & Tracking</a></li>
      <li><a href = "#delivery-section5">5. Contact Us</a></li>
    </ul>
  </div><!-- end of quick links -->

  <section class="policy-content"><!-- start of policy content -->

<div id="delivery-section1" class="policy-content-section"><!-- start of first policy section -->
  <div class="policy-section-header"><!-- start of policy section header -->
    <h2>1. Shipping Information</h2>
  </div><!-- end of policy section header -->
  <div class="policy-section-content"><!-- start of policy section content -->
    <p>Welcome to Ciao Football's Delivery Policy. We are committed to providing reliable and efficient delivery services for all your football merchandise.</p>
    <p>All orders are processed within 1-2 business days. Once your order ships, you will receive a confirmation email with tracking information to monitor your delivery status.</p>
  </div><!-- end of policy section content -->
</div><!-- end of first policy section -->

<div id="delivery-section2" class="policy-content-section"><!-- start of second policy section -->
  <div class="policy-section-header"><!-- start of policy section header -->
    <h2>2. Delivery Timeframes</h2>
  </div><!-- end of policy section header -->
  <div class="policy-section-content"><!-- start of policy section content -->
    <p>Our standard delivery timeframes depend on your location:</p>
    <ul>
      <li>Local delivery (within 30 miles): 1-2 business days</li>
      <li>Domestic shipping (nationwide): 3-5 business days</li>
      <li>European Union countries: 5-7 business days</li>
      <li>Rest of Europe: 7-10 business days</li>
      <li>International shipping (worldwide): 2-3 weeks *approx*</li>
    </ul>
    <p>Please note that these timeframes are estimates and may vary due to customs clearance or unforeseen circumstances.</p>
  </div><!-- end of policy section content -->
</div><!-- end of second policy section -->

<div id="delivery-section3" class="policy-content-section"><!-- start of third policy section -->
  <div class="policy-section-header"><!-- start of policy section header -->
    <h2>3. International Shipping</h2>
  </div><!-- end of policy section header -->
  <div class="policy-section-content"><!-- start of policy section content -->
    <p>We are proud to offer international shipping to over many countries worldwide. When placing an international order:</p>
    <ul>
      <li>All customs fees and import duties are the responsibility of the customer</li>
      <li>We cannot mark packages as "gifts" to avoid customs fees</li>
      <li>International delivery times may be affected by customs processing</li>
      <li>We offer various international shipping methods to suit your needs</li>
      <li>All international packages include detailed customs documentation</li>
      <li>We comply with all international shipping regulations</li>
    </ul>
    <p>For specific information about shipping to your country, please contact our customer service team before placing your order.</p>
  </div><!-- end of policy section content -->
</div><!-- end of third policy section -->

<div id="delivery-section4" class="policy-content-section"><!-- start of fourth policy section -->
  <div class="policy-section-header"><!-- start of policy section header -->
    <h2>4. Insurance & Tracking</h2>
  </div><!-- end of policy section header -->
  <div class="policy-section-content"><!-- start of policy section content -->
    <p>All shipments from Ciao Football include comprehensive benefits for your peace of mind:</p>
    <ul>
      <li>Every parcel is fully insured against loss or damage during transit</li>
      <li>Insurance coverage is included at no additional cost to you</li>
      <li>All packages include real-time tracking capabilities</li>
      <li>Signature confirmation is required for high-value orders</li>
      <li>Claims for damaged or lost items must be filed within 14 days of the expected delivery date</li>
    </ul>
    <p>In the unlikely event that your package is damaged or lost, please contact us immediately to initiate an insurance claim.</p>
  </div><!-- end of policy section content -->
</div><!-- end of fourth policy section -->

<div id="delivery-section5" class="policy-content-section"><!-- start of fifth policy section -->
  <div class="policy-section-header"><!-- start of policy section header -->
    <h2>5. Contact Us</h2>
  </div><!-- end of policy section header -->
  <div class="policy-section-content"><!-- start of policy section content -->
    <p>If you have any questions about our delivery policy or need assistance tracking your order, please contact us at:</p>
    <div class = "policy-contact"><!-- start of policy contact -->
    <p class = "policy-contact-first">Phone Number: 0123456789</p>
    <p>Email: support@ciaofootball.com</p>
    <p>Or, click <a href = "contact.php">here</a></p>
</div><!-- end of policy contact -->

  </div><!-- end of policy section content -->
</div><!-- end of fifth policy section -->

</section><!-- end of policy content -->




</section><!-- end of policy content container -->



</section><!-- end of the policy container -->
  
</main>

<?php
include('../components/footer.php');
?>

<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>