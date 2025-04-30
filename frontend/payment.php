<?php
session_start();
$pageTitle = "Process Payment"; // This will be used in the title tag
$pageDescription = "Ciao Football's Home Page. Get a feel for our business and ethos while also viewing our premium football products."; // This is used as the page desciption meta tag
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, home page"; // This is used as the keywords meta tag

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';



// Check if basket is empty 
if (!isset($_SESSION['basket']) || count($_SESSION['basket']) === 0) { // if basket doesn't exist or is empty
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Access Denied, no basket items found" . $errorIcon; // alert failed message to user
    header("Location: index.php"); // Redirect back to the home page
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
// Inlude the footer file
include('../components/paymentprogress.php');
?>

<section class="payment-card"><!-- start of payment card -->
    <div class="payment-card-container"><!-- container for payment card -->
        <div class="payment-card-heading">
            <h1 class="payment-title">Payment Details</h1>
            <p class="payment-subtitle">Complete your purchase securely</p>
        </div>
        
        <!-- Payment Method Selector -->
        <section class="payment-method-selector">
            <div class="payment-method-option payment-method-active" data-method="card">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card-icon lucide-credit-card"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
            </div>
            <div class="payment-method-option" data-method="applepay">
                <img src="../images/applepay.svg" alt="Apple Pay">
            </div>
            <div class="payment-method-option" data-method="googlepay">
                <img src="../images/googlepay.svg" alt="Google Pay">
            </div>
        </section>
        
        <div class="payment-card-body">
            <div class="payment-card-form">
                <form class="payment-form" method="POST" action="../backend/processpayment.php">
                    <div class="payment-form-group"><!-- start of form group -->
                        <label for="cardholderName">Cardholder Name</label>
                        <input type="text" id="cardholderName" name="cardholderName" required minlength="2" maxlength="50" placeholder="John Doe"> <!-- cardholder name input field -->
                    </div><!-- end of form group -->
                    <div class="payment-form-group"><!-- start of form group -->
                        <label for="CardNumber">Card Number</label>
                        <input type="tel" id="CardNumber" name="CardNumber" required maxlength="19" minlength="19" placeholder="1234 5678 9012 3456"> <!-- card number input field -->
                    </div><!-- end of form group -->
                    <div class="payment-form-group-bottom"><!-- start of form group -->
                        <div class="expiry-cvv-container">
                            <div class="expiry-container">
                                <label for="expiryDate">Expiry Date</label>
                                <input type="text" id="expiryDate" name="expiryDate" required placeholder="MM/YY" maxlength="4" minlength="4"> <!-- expiry date input field -->
                            </div>
                            <div class="cvv-container">
                                <label for="CVV">CVV</label>
                                <input type="text" id="CVV" name="CVV" required placeholder="123" maxlength="3" minlength="3"> <!-- CVV input field -->
                            </div>
                        </div>
                    </div><!-- end of form group -->
                    
                    <div class = "payment-total"><!-- start of payment total -->
                        <span class="payment-total-label">Total: <span class = "payment-shipping-disclaimer">Includes shipping</span> </span>
                        <span class="payment-total-amount">£<?php echo number_format($finalTotal, 2); ?></span> <!-- payment total amount -->
                    </div><!-- end of payment total -->
                    
                    <div class="payment-options-group"><!-- start of options group -->
                        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
                        <div class="save-card-option">
                            <input type="checkbox" id="saveCard" name="saveCard">
                            <label for="saveCard">Save card for future payments</label>
                        </div>
                        <?php endif; ?>
                        
                        <div class="payment-security-disclosure">
                            <span class="payment-disclosure-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock-icon lucide-lock"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </span>
                            Your payment info is secure and encrypted
                        </div>
                    </div><!-- end of options group -->
                    <div class="payment-form-group">
                        <button type="submit" class="payment-submit-button">Pay £<?php echo number_format($finalTotal, 2); ?> </button><!-- echo out final total to pay in button -->
                    </div>
                </form>
            </div>
        </div>
    </div><!-- end of payment card container -->
</section><!-- end of payment card -->



</main>



<?php
// Include the footer file
include('../components/footer.php');
?>

<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>