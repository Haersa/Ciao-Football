<?php
session_start();
$pageTitle = "Review Order"; // This will be used in the title tag
$pageDescription = "Review your order and make sure everything is correct."; // This is used as the page desciption meta tag
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, checkjut, purchase, pay"; // This is used as the keywords meta tag

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

    <section class = "checkout-header"> <!-- checkout page header -->
        <h1>Checkout</h1>
    </section><!-- end of checkout page header -->

    <?php
    // include the checkout process progress bar
    include('../components/revieworderprogress.php');
    ?>

    <section class="checkout-container">
    <!-- start of checkout container -->
    <div class="review-purchase-card">
        <div class="review-purchase-heading">
            <h2>
                <span class="review-purchase-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart-icon lucide-shopping-cart">
                        <circle cx="8" cy="21" r="1" />
                        <circle cx="19" cy="21" r="1" />
                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12" />
                    </svg>
                </span>Review Purchase
            </h2>
            <div class="total-items">
                <?php echo $totalItems; ?> item(s)
            </div>
        </div>
        <!-- end of review purchase heading -->
        <div class="review-purchase-body">
            <!-- start of review purchase body -->
            <?php foreach ($_SESSION['basket'] as $key => $item) : 
                $itemTotal = $item['price'] * $item['quantity'];
                
                // Check if it is a shirt or equipment item
                $isEquipment = isset($item['product_type']) ? 
                    $item['product_type'] === 'equipment' : 
                    (strpos($key, 'e') === 0);
                ?>
                <div class="checkout-item">
                    <!-- start of checkout item -->
                    <div class="checkout-item-image">
                        <img src="../<?php echo $item['image']; ?>" alt="Product image" class="checkout-item-image">
                    </div>
                    <div class="checkout-item-details">
                        <?php if ($isEquipment): ?>
                            <div class="checkout-review-order-top-row">
                                <!-- start of top row -->
                                <div class="checkout-item-name"><?php echo $item['name']; ?></div>
                                <!-- product name -->
                                <div class="checkout-item-quantity"> Qty: <?php echo $item['quantity']; ?></div>
                                <!-- product quantity -->
                            </div>
                            <!-- end of top row -->
                            <div class="checkout-review-order-info">
                                <!-- start of product info -->
                                <div class="checkout-item-info"><p class="product-info-bold">Brand: </p> <?php echo $item['brand']; ?></div>
                                <div class="checkout-item-info"><p class="product-info-bold">Category: </p> <?php echo $item['category']; ?></div>
                                <div class="checkout-item-price"> £<?php echo number_format($item['price'], 2); ?> </div>
                            </div>
                            <!-- end of product info -->
                        <?php else: ?>
                            <div class="checkout-review-order-top-row">
                                <!-- start of top row -->
                                <div class="checkout-item-name"><?php echo $item['team'] . ' ' . $item['year'] . ' ' . $item['type'] . ' Kit'; ?></div>
                                <!-- kit name -->
                                <div class="checkout-item-quantity"> Qty: <?php echo $item['quantity']; ?></div>
                                <!-- product quantity -->
                            </div>
                            <!-- end of top row -->
                            <div class="checkout-review-order-info">
                                <!-- start of product info -->
                                <div class="checkout-item-info"><p class="product-info-bold">Size: </p> <?php echo $item['size']; ?></div>
                                <div class="checkout-item-info"><p class="product-info-bold">Year: </p><?php echo $item['year']; ?></div>
                                <div class="checkout-item-info"><p class="product-info-bold">Category: </p> <?php echo $item['category']; ?></div>
                                <div class="checkout-item-price"> £<?php echo number_format($item['price'], 2); ?> </div>
                            </div>
                            <!-- end of product info -->
                        <?php endif; ?>
                    </div>
                </div>
                <!-- end of checkout item -->
            <?php endforeach; ?>
            <div class="review-purchase-footer">
                <!-- start of review purchase footer -->
                <div class="review-purchase-subtotal">
                    <p class="review-purchase-info-text">Subtotal:</p> 
                    <p class="review-purchase-money-info">£<?php echo number_format($totalAmount, 2); ?></p> 
                </div>
                <div class="review-purchase-shipping">
                    <p class="review-purchase-info-text">Shipping:</p> 
                    <p class="review-purchase-money-info">£<?php echo number_format($shippingCost, 2); ?></p>
                </div>
                <div class="total-divider"></div>
                <div class="review-purchase-total">
                    <p class="review-purchase-info-text">Total:</p> 
                    <p class="review-purchase-money-info">£<?php echo number_format($finalTotal, 2); ?></p>
                </div>
            </div>
            <!-- end of review purchase footer -->
        </div>
        <!-- end of review purchase body -->
    </div>
    <!-- end of review purchase card -->
</section>
<!-- end of checkout container -->

<section class = "review-order-action-container"> <!-- start of review order action container -->
    <div class="review-order-action">
        <a href="basket.php" class="review-order-basket-button"><span class="back-button-icon"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-left-icon"><path d="M6 8L2 12L6 16"/><path d="M2 12H22"/></svg></span>Back to Basket</a>
        <a href="billing.php" class="review-order-shipping-button">Proceed to Checkout</a>
    </div>
</section> <!-- end of review order action container -->
<!-- end of review order action container -->

</main>

<?php
// Include the footer file
include('../components/footer.php');
?>

<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>