<?php
session_start(); // start session
include('../backend/conn/conn.php'); // connection to database file
$pageTitle = "Order Summary"; // This will be used in the title tag
$pageDescription = "Thanks for your order! View the summary of your order here."; // This is used as the page desciption meta tag
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, order, summary"; // This is used as the keywords meta tag


// Get the order number from the URL as an integer
$orderNumber = isset($_GET['order']) ? (int)$_GET['order'] : 0;

if ($orderNumber <= 0) {
    // if user has no order number and tries to access the order review/summary page
    header("Location: ../frontend/index.php"); // redirect them to home page
    exit();
}

$query = "SELECT * FROM user_orders WHERE order_number = ?"; // get the total order amount from the db as in the payment processing script we end the basket session
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $orderNumber);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    // if no order number is found
    header("Location: ../frontend/index.php"); // redirect them to home page
    exit();
}

$order = mysqli_fetch_assoc($result); // get the total amount from the query
$totalAmount = $order['total_amount'];
$shippingCost = 5.99; // set shipping cost
$finalTotal = $totalAmount + $shippingCost; // add the shipping cost onto the total amount


// Include the header file
include('../components/header.php');
?>

<?php 
// include the back to top button file
include('../components/backtotopbutton.php');
?>
<main><!-- start of main content -->
    <?php
// Get the order number from the URL parameter
if(isset($_GET['order'])) {
    $orderNumber = $_GET['order'];
    echo "<section class='order-confirmation-card'>"; // start of order confirmation card
    echo "<div class = 'order-confirmation-header'>"; // start of confirmation header
    echo "<h1 class = 'order-confirmation-title'>Ciao Football<h1>"; // confirmation title
    echo "</div>";// end of confirmation header 

    // Order confirmation message
    echo "<div class='order-success-message'>"; // start of order confirmation success message
    echo "<h2>Order Confirmed!</h2>";
    echo "<p>Thank you for your purchase!</p>";
    echo "</div>"; // end of success message
    
    echo "<div class='order-confirmation-second-row'>";// start of second row
    echo "<p class='order-number-display'>Order Number: #" . htmlspecialchars($orderNumber) . "</p>";
    echo "</div>"; // end of second row
    
    
    // Delivery information
    echo "<div class='delivery-info-section'>";
    echo "<h3>Delivery Info</h3>";
    echo "<div class='delivery-info-row'>";
    echo "<span class='delivery-info-label'>Delivery Time:</span>";
    echo "<span class='delivery-info-value'>3-5 working days</span>";
    echo "</div>";
    echo "<div class='international-delivery-note'>";
    echo "<span>*International delivery: 2-3 weeks approx*</span>";
    echo "</div>";
    echo "<div class='delivery-info-row'>";
    echo "<span class='delivery-info-label'>Delivery Method:</span>";
    echo "<span class='delivery-info-value'>Standard</span>";
    echo "</div>";
    echo "<span class = 'mobile-international-delivery'>*International delivery: 2-3 weeks approx*</span>";
    echo "</div>"; // end of delivery info section
    
    // Email notification
    echo "<div class='inbox-notification'>";
    echo "<h3>Check Your Inbox</h3>";
    echo "<p>We've sent a confirmation email to your registered email address with all the details of your order.</p>";
    echo "</div>";
    
    // Payment information
    echo "<div class='payment-info-section'>";
    echo "<h3>Payment Information</h3>";
    echo "<div class='payment-info-row'>";
    echo "<span class='payment-info-label'>Payment Method:</span>";
    echo "<span class='payment-info-value'>Card</span>";
    echo "</div>";
    echo "<div class='payment-amount-row'>";
    echo "<h4 class='payment-amount-label'>You Paid:</h4>";
    echo "<span class='payment-amount-value'>£" .$finalTotal . "</span>";
    echo "</div>";
    echo "</div>"; // end of payment info section
    
    // Action buttons
    echo "<div class='action-buttons'>";
    if(isset($_SESSION['logged_in'])) {
        echo "<a href = 'profile.php' class='track-order-button'>Track Order</a>"; // hide if user isnt logged in, as the profile.php page is only accessible to ciao users
      }
    echo "<a href = 'index.php' class='continue-shopping-button'>Continue Shopping</a>";
    echo "</div>";
    
    // Customer support
    echo "<div class='customer-support'>";
    echo "<p><span class = 'order-help'<span>Need help?</span> <a href='contact.php'>Contact our customer support</a></p>";
    echo "</div>"; // end of customer support
    
    echo "</section>"; // end of order confirmation card

} else {
    echo "<p>Order number not found. Please check your order history.</p>"; // if no order number is found, show error message to user
}
?>
</section>

</main>

<?php
// Inlude the footer file
include('../components/footer.php');
?>


<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>