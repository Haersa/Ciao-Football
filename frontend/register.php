<?php
$pageTitle = "Create Your Account"; // This will be used in the title tag
$pageDescription = "Ciao Football's Register Page. Create a Ciao Football Account and start shopping!"; // This is used as the page desciption meta tag
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, register, account, create, sign up"; // This is used as the keywords meta tag

// Include the header file
include('../components/header.php');
?>
<?php 
// back to top button
include('../components/backtotopbutton.php');
?>

<!-- Main content of the page starts here -->
<main>
   <!-- start of register container-->
   <div class="register-container">
       <!-- heading container -->
       <div class="register-heading-container">
           <h2>Create Your Account</h2> <!-- register form title -->
       </div> <!-- end of heading container -->
       <form class="register-form" action="../backend/signup.php" method="POST">
           <div class="form-row">
               <div class="form-group">
                   <label for="name">First Name</label>
                   <input type="text" id="firstName" name="firstName" required placeholder="Name"> <!-- first name input field -->
               </div>
               <div class="form-group">
                   <label for="surname">Surname</label>
                   <input type="text" id="surname" name="surname" required placeholder="Surname"> <!-- surname input field -->
               </div>
           </div>
           
           <div class="form-group">
               <label for="email">Email</label>
               <input type="email" id="email" name="email" required placeholder="Email"> <!-- email input field -->
           </div>
           
           <div class="form-group">
               <label for="password">Password</label>
               <input type="password" id="password" name="password" required minlength="8" maxlength="20" placeholder="Password..."> <!-- password input field -->
           </div>
           
           <div class="form-group">
               <label for="confirmPassword">Confirm Password</label>
               <input type="password" id="confirmPassword" name="confirmPassword" required minlength="8" maxlength="20" placeholder="Password..."> <!-- confirm password input field -->
           </div>

           <div class="form-group terms-group">
                <div class="terms-container">
                    <p id = "terms-label">I agree to the <a rel="noopener noreferrer" target = "_blank" href="terms.php">Terms & Conditions</a></p>
                    <input type="checkbox" aria-labelledby = "terms-label" id="terms" name="terms" required>
                </div>
            </div>
           
           <button class="register-button" type="submit">Create Account</button> <!-- submit button -->

           <div class="third-party-auth">
               <div class="third-party-auth-text">
                   <p>Or sign up with:</p>
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
           
           <div class="login-link">
               <p>Already have an account? <a rel="noopener noreferrer" href="login.php">Sign in</a></p>
           </div>
       </form>
   </div><!-- end of register container -->
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