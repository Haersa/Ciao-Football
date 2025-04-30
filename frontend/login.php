<?php
$pageTitle = "Sign into Your Account"; // This will be used in the title tag
$pageDescription = "Sign into your Ciao Football Account. You will be able to view weekly deals and more."; // This is used as the page desciption meta tag
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, sign in page"; // This is used as the keywords meta tag

// Include the header file
include('../components/header.php');
?>
<?php 
// back to top button
include('../components/backtotopbutton.php');
?>

<!-- Main content of the page starts here -->
<main>
  <!-- start of login container-->
  <div class="login-container">
    <div class="login-image">
      <img src="../images/loginimage.png" alt="Login Image">
    </div>
    <div class="login-form">
      <form action="../backend/signin.php" method="post">
        <h1>Sign in</h1> <!-- login form title -->
        <div class="form-group">
          <label for="Email">Email</label>
          <input type="text" id="Email" name="email" required> <!-- username input field -->
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" required> <!-- password input field -->
        </div>
        <input type="submit" value="Sign in"> <!-- submit button -->
        <div class="third-party-auth">
               <div class="third-party-auth-text">
                   <p>Or sign in with:</p>
               </div>
               <div class="third-party-auth-buttons"><!-- third party auth buttons -->
                   <div class="google-button">
                       <img src="../images/google.svg" alt="Google icon"> Google
</div><!-- google button -->
                   <div class="facebook-button">
                       <img src="../images/facebook.svg" alt="Facebook icon"> Facebook
</div><!-- facebook button -->
               </div>
           </div>
        <div class = "register-link">
          <p>Don't have an account? <a  href="register.php">Register</a></p>
      </form>
    </div>
  </div><!-- end of login container -->
</main>
<!-- end of main container-->

<?php
// Include the footer file
include('../components/footer.php');
?>

<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>