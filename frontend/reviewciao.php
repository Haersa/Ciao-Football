<?php

$pageTitle = "Leave a Review"; // This will be used in the title tag
$pageDescription = "Leave a review. We endeavour to protect your privacy."; // This is used as the page desciption meta tag
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, privacy, review, review us"; // This is used as the keywords meta tag

// Include the header file
include('../components/header.php');
?>

<!-- Main content of the page starts here -->
<main>
<div class = "review-form-container"> <!-- start of review form container -->
    <div class = "review-form-header"> <!-- review form heading -->
        <h2>Review Ciao Football</h2>
    </div><!-- end of review form heading -->
    <div class="review-form-wrapper"> <!-- start of review form wrapper -->
<form action="../backend/reviewciao.php" method="POST">
  <div class="review-name-row">
    <div class="review-name-field">
      <label for="name">First Name:</label>
      <input type="text" id="name" name="name" required>
    </div>
    
    <div class="review-name-field">
      <label for="surname">Last Name:</label>
      <input type="text" id="surname" name="surname" required>
    </div>
  </div>
  
  <div class="review-form-group">
    <label for="rating">Rating (1.0 - 5.0):</label>
    <input type="number" id="rating" name="rating" min="1" max="5" step="0.1" required>
  </div>
  
  <div class="review-form-group">
    <label for="review">Review:</label>
    <textarea id="review" name="review" rows="4" required></textarea>
  </div>
  
  <div class="review-form-group">
    <button type="submit">Submit Review</button>
  </div>
</form>
</div><!-- end of review form wrapper -->
</div><!-- end of review form container -->

</main>

<?php
// Inlude the footer file
include('../components/footer.php');
?>

<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>