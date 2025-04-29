<?php
$pageTitle = "Billing Address"; // This will be used in the title tag
$pageDescription = "Enter your billing address for your order."; // This is used as the page desciption meta tag
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, checkout, purchase, pay, billing, details"; // This is used as the keywords meta tag

// Include the header file
include('../components/header.php');

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Initialize variables
$totalAmount = 0;
$hasItems = false;
$shippingCost = 5.99;
$totalItems = 0;

// Check if basket exists and has items
if (isset($_SESSION['basket']) && count($_SESSION['basket']) > 0) {
    $hasItems = true;
    
    // Calculate the total amount and count total items
    foreach ($_SESSION['basket'] as $key => $item) {
        $itemTotal = $item['price'] * $item['quantity'];
        $totalAmount += $itemTotal;
        $totalItems += $item['quantity'];
    }
}

// Calculate final total with shipping
$finalTotal = $totalAmount + $shippingCost;

// Redirect if no items in basket
if (!$hasItems) {
    header("Location: ../frontend/index.php");
    exit();
}
?>

<?php 
// include the back to top button file
include('../components/backtotopbutton.php');
?>

<main><!-- start of main content -->

<?php 
// include the
include('../components/billingorderprogress.php');
?>


<?php
// Display any success or error messages
if (isset($_SESSION['Success']) && $_SESSION['Success']) {
    echo '<div class="alert alert-success">' . $_SESSION['SuccessMessage'] . '</div>';
    // Clear the session variables
    $_SESSION['Success'] = false;
    $_SESSION['SuccessMessage'] = '';
}

if (isset($_SESSION['Failed']) && $_SESSION['Failed']) {
    echo '<div class="alert alert-danger">' . $_SESSION['FailMessage'] . '</div>';
    // Clear the session variables
    $_SESSION['Failed'] = false;
    $_SESSION['FailMessage'] = '';
}

// Include the billing form component
include('../components/billingform.php');
?>

</main>

<?php
// Include the footer file
include('../components/footer.php');
?>

<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>