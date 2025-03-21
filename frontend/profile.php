<?php

$pageTitle = "User Profile"; // This will be used in the title tag
$pageDescription = "Your own Profile page. View your account details and more."; // This is used as the page desciption meta tag
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, home page"; // This is used as the keywords meta tag

// Include the header file
include('../components/header.php');
?>
<?php 
// back to top button
include('../components/backtotopbutton.php');
?>

<!-- Main content of the page starts here -->
<main>
  <section class="hero">
    <h1>Profile</h1>
    <p>Your destination for premium football gear</p>
  </section>
  
</main>

<?php
// Inlude the footer file
include('../components/footer.php');
?>

<!-- include a link to add shipping address and add payment details, payment details will also be a checkbox to be ticked inside payment form -->

<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>