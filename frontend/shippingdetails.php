<?php 
session_start(); // Make sure to start the session if not already started

$pageTitle = "Confirm Shipping Details"; // This will be used in the title tag 
$pageDescription = "Review and confirm your shipping details. "; // This is used as the page desciption meta tag 
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, checkout, purchase, pay, shipping, details"; // This is used as the keywords meta tag

// set lucide icons in variables 
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>'; 
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Check if basket is empty 
if (!isset($_SESSION['basket']) || count($_SESSION['basket']) === 0) { // if basket doesn't exist or is empty
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Access Denied, no basket items found" . $errorIcon; // alert failed message to user
    header("Location: ../frontend/index.php"); // Redirect back to the home page
    exit();
}

// Initialize variables 
$totalAmount = 0; 
$hasItems = true; // Set to true, as we know basket has items
$shippingCost = 5.99; 
$totalItems = 0;

// Calculate the total amount and count total items
foreach ($_SESSION['basket'] as $key => $item) {
    $itemTotal = $item['price'] * $item['quantity'];
    $totalAmount += $itemTotal;
    $totalItems += $item['quantity'];
} 

// Calculate final total with shipping 
$finalTotal = $totalAmount + $shippingCost;

// Include the header file 
include('../components/header.php');
?>

<?php 
// include the back to top button file
include('../components/backtotopbutton.php');
?>


<main><!-- start of main content -->
<?php 
// include the back to top button file
include('../components/shippingprogress.php');
?>

<section class="shipping-details-container"><!-- start of shipping details container -->
    <div class="shipping-details-card"><!-- start of shipping details card-->
        <div class="shipping-details-header"><!-- start of shipping details header -->
            <h2 class="details-title">
                <span class="shipping-details-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package-icon lucide-package">
                        <path d="M11 21.73a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73z" />
                        <path d="M12 22V12" />
                        <polyline points="3.29 7 12 12 20.71 7" />
                        <path d="m7.5 4.27 9 5.15" />
                    </svg>
                </span>
                Shipping Details
            </h2>
        </div><!-- end of shipping details header -->

        <form class="shipping-details-form" method="POST" action="../backend/processshipping.php"><!-- start of shipping details form -->
    <div class="shipping-form-top-row"><!-- start of shipping form top row -->
        <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="name">First Name: 
                <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
            </label>
            <input class="shipping-input" type="text" name="name" placeholder="First Name:" required minlength="2" maxlength="50" 
            value="<?php echo (isset($_SESSION['use_billing_for_shipping']) && $_SESSION['use_billing_for_shipping'] && isset($_SESSION['billing']['name'])) ? htmlspecialchars($_SESSION['billing']['name']) : ''; ?>"> <!-- check if the form field data has already been defined and saved in the billing address form (check the sessions that get set when submitting the billing form), if so, display it -->
        </div><!-- end of form group -->

        <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="surname">Surname: 
                <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
            </label>
            <input class="shipping-input" type="text" name="surname" placeholder="Surname:" required minlength="2" maxlength="50"
            value="<?php echo (isset($_SESSION['use_billing_for_shipping']) && $_SESSION['use_billing_for_shipping'] && isset($_SESSION['billing']['surname'])) ? htmlspecialchars($_SESSION['billing']['surname']) : ''; ?>"> <!-- check if the form field data has already been defined and saved in the billing address form (check the sessions that get set when submitting the billing form), if so, display it -->
        </div><!-- end of form group -->
    </div><!-- end of shipping form top row -->

    <div class="shipping-form-second-row"><!-- start of shipping form second row -->
        <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="email">Email: 
                <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
            </label>
            <input class="shipping-input" type="email" name="email" placeholder="example@domain.com:" minlength="4" maxlength="50" required
            value="<?php echo (isset($_SESSION['use_billing_for_shipping']) && $_SESSION['use_billing_for_shipping'] && isset($_SESSION['billing']['email'])) ? htmlspecialchars($_SESSION['billing']['email']) : ''; ?>"> <!-- check if the form field data has already been defined and saved in the billing address form (check the sessions that get set when submitting the billing form), if so, display it -->
        </div><!-- end of form group -->

        <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="phone">Phone Number: 
                <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
            </label>
            <input class="shipping-input" type="tel" name="phone" placeholder="+44 XXXX XXXXXX:" minlength="10" maxlength="50" required
            value="<?php echo (isset($_SESSION['use_billing_for_shipping']) && $_SESSION['use_billing_for_shipping'] && isset($_SESSION['billing']['phone'])) ? htmlspecialchars($_SESSION['billing']['phone']) : ''; ?>"> <!-- check if the form field data has already been defined and saved in the billing address form (check the sessions that get set when submitting the billing form), if so, display it -->
        </div><!-- end of form group -->
    </div><!-- end of shipping form second row -->

    <div class="shipping-form-address-row"><!-- start of shipping form address row -->
        <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="addressLine1">Address Line 1: 
                <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
            </label>
            <input class="shipping-input" type="text" name="addressLine1" placeholder="House/Flat/Apartment Number:" required minlength="1" maxlength="50"
            value="<?php echo (isset($_SESSION['use_billing_for_shipping']) && $_SESSION['use_billing_for_shipping'] && isset($_SESSION['billing']['addressLine1'])) ? htmlspecialchars($_SESSION['billing']['addressLine1']) : ''; ?>"><!-- check if the form field data has already been defined and saved in the billing address form (check the sessions that get set when submitting the billing form), if so, display it -->
        </div><!-- end of form group -->
    </div><!-- end of shipping form address row -->

    <div class="shipping-form-address-row">
        <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="addressLine2">Address Line 2: 
                <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
            </label>
            <input class="shipping-input" type="text" name="addressLine2" placeholder="Street Name:" required minlength="1" maxlength="50"
            value="<?php echo (isset($_SESSION['use_billing_for_shipping']) && $_SESSION['use_billing_for_shipping'] && isset($_SESSION['billing']['addressLine2'])) ? htmlspecialchars($_SESSION['billing']['addressLine2']) : ''; ?>"> <!-- check if the form field data has already been defined and saved in the billing address form (check the sessions that get set when submitting the billing form), if so, display it -->
        </div><!-- end of form group -->
    </div><!-- end of shipping form address row -->

    <div class="shipping-form-address-row">
        <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="addressLine3">Address Line 3:</label>
            <input class="shipping-input" type="text" name="addressLine3" placeholder="Additional address information (optional):" minlength="1" maxlength="50"
            value="<?php echo (isset($_SESSION['use_billing_for_shipping']) && $_SESSION['use_billing_for_shipping'] && isset($_SESSION['billing']['addressLine3'])) ? htmlspecialchars($_SESSION['billing']['addressLine3']) : ''; ?>"> <!-- check if the form field data has already been defined and saved in the billing address form (check the sessions that get set when submitting the billing form), if so, display it -->
        </div><!-- end of form group -->
    </div><!-- end of shipping form address row -->

    <div class="shipping-form-address-row">
        <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="addressLine4">Address Line 4:</label>
            <input class="shipping-input" type="text" name="addressLine4" placeholder="Additional address information (optional):" minlength="1" maxlength="50"
            value="<?php echo (isset($_SESSION['use_billing_for_shipping']) && $_SESSION['use_billing_for_shipping'] && isset($_SESSION['billing']['addressLine4'])) ? htmlspecialchars($_SESSION['billing']['addressLine4']) : ''; ?>"> <!-- check if the form field data has already been defined and saved in the billing address form (check the sessions that get set when submitting the billing form), if so, display it -->
        </div><!-- end of form group -->
    </div><!-- end of shipping form address row -->

    <div class="shipping-form-bottom-row"><!-- start of shipping form bottom row -->
        <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="city">Town/City: 
                <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
            </label>
            <input class="shipping-input" type="text" name="city" placeholder="Town/City:" required minlength="4" maxlength="50"
            value="<?php echo (isset($_SESSION['use_billing_for_shipping']) && $_SESSION['use_billing_for_shipping'] && isset($_SESSION['billing']['city'])) ? htmlspecialchars($_SESSION['billing']['city']) : ''; ?>"> <!-- check if the form field data has already been defined and saved in the billing address form (check the sessions that get set when submitting the billing form), if so, display it -->
        </div><!-- end of form group -->

        <div class="shipping-form-group"><!-- start of form group -->
            <label class="shipping-label" for="postcode">Post/Zip code: 
                <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
            </label>
            <input class="shipping-input" type="text" name="postcode" placeholder="e.g., AB12 3CD:" required minlength="4" maxlength="25"
            value="<?php echo (isset($_SESSION['use_billing_for_shipping']) && $_SESSION['use_billing_for_shipping'] && isset($_SESSION['billing']['postcode'])) ? htmlspecialchars($_SESSION['billing']['postcode']) : ''; ?>"> <!-- check if the form field data has already been defined and saved in the billing address form (check the sessions that get set when submitting the billing form), if so, display it -->
        </div><!-- end of form group -->
    </div><!-- end of shipping form bottom row -->

    <div class="shipping-form-group country-group">
      <label class="shipping-label country-label" for="countries">Select Country: 
        <span class="field-required">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
             <path d="M12 6v12" />
              <path d="M17.196 9 6.804 15" />
              <path d="m6.804 9 10.392 6" />
          </svg>
        </span>
      </label>
      <select name="countries" id="countries" class="shipping-country-select" required>
        <optgroup label="Select your Country">
            <option value="" disabled<?php echo (!isset($_SESSION['use_billing_for_shipping']) || !$_SESSION['use_billing_for_shipping'] || !isset($_SESSION['billing']['country'])) ? ' selected' : ''; ?>>Please Select a Country</option><!-- show this to the user if they haven't selected a country yet (didn't make billing address their shipping address) -->
            <?php
            // Define array of countries the user can choose from (taken from existing billing address form component)
            $countries = [
                "Argentina", "Australia", "Austria", "Belgium", "Botswana", "Brazil", "Canada", "Chile", 
                "China", "Colombia", "Croatia", "Czech Republic", "Denmark", "Egypt", "Finland", "France", 
                "Germany", "Greece", "Hungary", "India", "Indonesia", "Italy", "Japan", "Cambodia", "Laos", 
                "Malaysia", "Morocco", "Mexico", "Namibia", "Netherlands", "New Zealand", "Norway", "Oman", 
                "Peru", "Philippines", "Poland", "Portugal", "Qatar", "Romania", "Saudi Arabia", "Singapore", 
                "Slovakia", "Slovenia", "South Africa", "South Korea", "Spain", "Sweden", "Switzerland", 
                "Thailand", "Tunisia", "Turkey", "United Arab Emirates", "United Kingdom", "United States", 
                "Uruguay", "Vietnam"
            ];
            
            // Loop through all countries in the array and create options
            foreach($countries as $country) {
                $selected = '';
                if(isset($_SESSION['use_billing_for_shipping']) && $_SESSION['use_billing_for_shipping'] && 
                   isset($_SESSION['billing']['country']) && $_SESSION['billing']['country'] == $country) {
                    $selected = ' selected';
                }
                echo '<option value="' . $country . '"' . $selected . '>' . $country . '</option>'; // echo out all the options the user can choose from (list taken from existing billing address form component)
            }
            ?>
        </optgroup>
      </select>
      <div class="shipping-form-group"><!-- start of form group -->
          <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?><!-- only show to logged in users -->
          <div class="checkbox-container">
              <label class="remember-checkbox" for="save-address">Save this address for Future Orders?</label>
              <input class="shipping-save-details" type="checkbox" id="save-address" name="save-address">
          </div>
          <?php endif; ?>
      </div><!-- end of form group -->
    </div><!-- end of shipping form group country-group -->
    
    <section class="shipping-action-container"><!-- start of shipping action container -->
        <div class="shipping-action">
            <a href="billing.php" class="shipping-review-button"><span class="shipping-back-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-left-icon"><path d="M6 8L2 12L6 16"/><path d="M2 12H22"/></svg></span>Go Back</a>
            <button type="submit" class="shipping-payment-button">Continue to Payment</button>
        </div>
    </section><!-- end of shipping action container -->
</form><!-- end of shipping details form -->

</main>
<?php
// Include the footer file
include('../components/footer.php');
?>

<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>