<?php
$pageTitle = "Your Basket"; // This will be used in the title tag
$pageDescription = "Your product basket, finalise your decision and purchase your products."; // This is used as the page desciption meta tag
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, basket, purchase, cart"; // This is used as the keywords meta tag

// Include the header file
include('../components/header.php');

// Initialize basket variables
$totalAmount = 0;
$hasItems = false;

// Check if basket exists and has items
if (isset($_SESSION['basket']) && count($_SESSION['basket']) > 0) { // if basket count is greater than 1
    $hasItems = true; // set flag to true
    
    // Calculate the total amount (to be used in final cost elements on both mobile and desktop basket designs)
    foreach ($_SESSION['basket'] as $key => $item) {
        $itemTotal = $item['price'] * $item['quantity'];
        $totalAmount += $itemTotal;
    }
}

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

?>

<main><!-- start of main content -->

<?php if (!$hasItems) : ?> <!-- if basket has no items, display no items message -->
            <section class="empty-basket">
                <div class = "empty-alert">
                    <h2>Your basket is empty</h2>
                        <p>Click <a href="index.php">here</a> to start shopping.</p>
                </div>
            </section>
    <?php else : ?> <!-- if basket has items, display item information -->
        <section class="basket-container"> <!-- start of basket container -->
    <div class="basket-header">
        <h1 class="basket-title">Your Basket</h1>
    </div>

    <table class="basket-table">
        <thead>
            <tr>
                <th class="basket-header-product">Product</th> <!-- table headings -->
                <th class="basket-header-details">Details</th>
                <th class="basket-header-price">Price</th>
                <th class="basket-header-quantity">Quantity</th>
                <th class="basket-header-total">Total</th>
                <th class="basket-header-actions">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['basket'] as $key => $item) : // loop through basket items 
                // Calculate item total (for display only)
                $itemTotal = $item['price'] * $item['quantity'];

                // next, check if it is a shirt or equipment item
                $isEquipment = isset($item['product_type']) ?
                    $item['product_type'] === 'equipment' : 
                    (strpos($key, 'e') === 0); // use strpos to find if key starts with 'e' (position 0), if it does it is a equipment item
            ?>
            <tr class="basket-item">
                <td class="basket-product-image-container">
                <img src="../<?php echo $item['image']; ?>" alt="Product image" class="basket-product-image"> <!-- display the product image from productimages folder (stored in session) -->
                </td>
                <td class="basket-product-details">
                    <?php if ($isEquipment): ?>
                        <div class="product-name"><?php echo $item['name']; ?></div>
                        <div class="product-info">Brand: <?php echo $item['brand']; ?></div>
                        <div class="product-info">Category: <?php echo $item['category']; ?></div>
                    <?php else: ?>
                        <div class="product-name"><?php echo $item['team'] . ' ' . $item['year'] . ' ' . $item['type']; ?></div>
                        <div class="product-info">Size: <?php echo $item['size']; ?></div>
                    <?php endif; ?>
                </td>
                <td class="basket-product-price">
                    £<?php echo number_format($item['price'], 2); ?>
                </td>
                <td class="basket-product-quantity">
                    <form action="../backend/updatebasket.php" method="POST" class="quantity-form">
                        <input type="hidden" name="productKey" value="<?php echo $key; ?>">
                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="quantity-input">
                        <button type="submit" class="update-basket-button">Update</button>
                    </form>
                </td>
                <td class="basket-product-total">
                    £<?php echo number_format($itemTotal, 2); ?>
                </td>
                <td class="basket-product-actions">
                    <a href="../backend/removebasket.php?remove=<?php echo $key; ?>" class="remove-basket-button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="basket-total-row">
                <td colspan="4" class="basket-total-label">Total:</td>
                <td colspan="2" class="basket-total-amount">£<?php echo number_format($totalAmount, 2); ?></td>
            </tr>
        </tfoot>
    </table>
    
    <div class="basket-actions">
        <a href="../frontend/index.php" class="continue-shopping">Continue Shopping</a>
        <a href="../frontend/checkout.php" class="checkout-button">Proceed to Checkout</a>
    </div>
<?php endif; ?>
</section><!-- end of basket container -->

<section class = "mobile-basket-container">
<?php if ($hasItems) : ?>
    <div class="mobile-basket-header">
        <h1 class="mobile-basket-title">Your Basket</h1>
    </div>

    <div class="mobile-basket-items">
        <?php foreach ($_SESSION['basket'] as $key => $item) : 
            $itemTotal = $item['price'] * $item['quantity'];

            // Check if it is a shirt or equipment item
            $isEquipment = isset($item['product_type']) ?
                $item['product_type'] === 'equipment' : 
                (strpos($key, 'e') === 0);
        ?>
        <div class="mobile-basket-item">
            <div class="mobile-item-top">
                <div class="mobile-product-image-container">
                    <img src="../<?php echo $item['image']; ?>" alt="Product image" class="mobile-product-image">
                </div>
                <div class="mobile-product-details">
                    <?php if ($isEquipment): ?>
                        <div class="mobile-product-name"><?php echo $item['name']; ?></div>
                        <div class="mobile-product-info">Brand: <?php echo $item['brand']; ?></div>
                        <div class="mobile-product-info">Category: <?php echo $item['category']; ?></div>
                    <?php else: ?>
                        <div class="mobile-product-name"><?php echo $item['team'] . ' ' . $item['year'] . ' ' . $item['type']; ?></div>
                        <div class="mobile-product-info">Size: <?php echo $item['size']; ?></div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="mobile-item-divider"></div>
            
            <div class="mobile-item-bottom">
                <div class="mobile-price-section">
                    <span class="mobile-data-label">Price:</span>
                    <span class="mobile-price-value">£<?php echo number_format($item['price'], 2); ?></span>
                </div>
                
                <div class="mobile-quantity-section">
                    <span class="mobile-data-label">Qty:</span>
                    <form action="../backend/updatebasket.php" method="POST" class="mobile-quantity-form">
                        <input type="hidden" name="productKey" value="<?php echo $key; ?>">
                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="mobile-quantity-input">
                        <button type="submit" class="mobile-update-button">Update</button>
                    </form>
                </div>
                
                <div class="mobile-total-section">
                    <span class="mobile-data-label">Total:</span>
                    <span class="mobile-total-value">£<?php echo number_format($itemTotal, 2); ?></span>
                </div>
                
                <div class="mobile-actions-section">
                    <a href="../backend/removebasket.php?remove=<?php echo $key; ?>" class="mobile-remove-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2">
                            <path d="M3 6h18"/>
                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                            <line x1="10" x2="10" y1="11" y2="17"/>
                            <line x1="14" x2="14" y1="11" y2="17"/>
                        </svg>
                        Remove
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="mobile-basket-summary">
        <div class="mobile-summary-total">
            <span class="mobile-summary-label">Total:</span>
            <span class="mobile-summary-amount">£<?php echo number_format($totalAmount, 2); ?></span>
        </div>
    </div>
    
    <div class="mobile-basket-actions">
        <a href="../frontend/index.php" class="mobile-continue-shopping">Continue Shopping</a>
        <a href="../frontend/checkout.php" class="mobile-checkout-button">Proceed to Checkout</a>
    </div>
<?php endif; ?>
</section>


</main>

<?php
// Include the footer file
include('../components/footer.php');
?>

<script src="../js/app.js"></script>
<!-- <script src="../js/flickity.js"></script> -->
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flickity/2.3.0/flickity.pkgd.min.js"></script>
</body>
</html>