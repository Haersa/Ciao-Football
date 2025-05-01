<?php
session_start(); // start session
include('../backend/conn/conn.php'); // connection to database file
$pageTitle = "Order Summary"; // This will be used in the title tag
$pageDescription = "Thanks for your order! View the summary of your order here."; // This is used as the page desciption meta tag
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, order, summary"; // This is used as the keywords meta tag

// Include the header file
include('../components/header.php');
?>

<?php 
// include the back to top button file
include('../components/backtotopbutton.php');
?>
<main><!-- start of main content -->
<section class="placed-order-review">
    <h1 class="placed-order-heading">Thanks for your order!</h1>
    <?php
    // Get the order number from the URL parameter
    if(isset($_GET['order'])) {
        $orderNumber = $_GET['order'];
        echo "<p>Your order number is: " . "#".htmlspecialchars($orderNumber) . "</p>"; // display the order number to the user
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