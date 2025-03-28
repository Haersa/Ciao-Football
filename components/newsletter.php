<section class="newsletter-signup"><!-- newsletter signup -->
  <div class="newsletter-container">
    <div class="newsletter-text">
      <h2 class = "newsletter-heading">Subscribe to our newsletter</h2><!-- section heading -->
      <p class = "newsletter-text">Stay updated with our latest news, articles, and exclusive offers directly in your inbox.</p><!-- supporting texct -->
    </div>
    <div class="newsletter-form"><!-- sign up form -->
      <form action="../backend/newsletter.php" method="post">
        <input type="text" name="first_name" placeholder="First Name" required><!-- user input field -->
        <input type="email" name="email" placeholder="Email Address" required><!-- user input field -->
        <button type="submit">Subscribe</button>
      </form><!-- end of sign up form -->
    </div>
  </div>
</section><!-- end of newsletter signup -->