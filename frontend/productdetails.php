<?php
// Default meta values
$pageTitle = "Product Details"; 
$pageDescription = "Product Details, get all the relevant info to your favourite product."; 
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, "; 

// Get product ID and type from URL
$id = isset($_GET['id']) ? $_GET['id'] : null;
$type = isset($_GET['type']) ? $_GET['type'] : null;

// Connect to database (for whatever reason even though the db connection is inside the header file, removing this will cause the page to crash, so it has to stay in)
include('../backend/conn/conn.php');

// Load product based on type
$product = null; // set to null, as it will be appended later on when the query returns the result
if ($id && $type) {
    if ($type == 'shirt') {
        // query the shirts table
        $query = "SELECT * FROM shirts WHERE shirt_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result && mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result); // append the query result to product variable
            // Update meta tag to show the uniqie products details inside the meta tags
            $pageTitle = $product['team'] . " " . $product['type'] . " Kit";
        }
    } 
    elseif ($type == 'equipment') {
        // query the equiupment table
        $query = "SELECT * FROM equipment WHERE equipment_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if ($result && mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result); // append the query result to product variable
            // Update meta tag to show the uniqie products details inside the meta tags
            $pageTitle = $product['name'];
        }
    }
}

// Include the header file
include('../components/header.php');

// Include the back to top button file
include('../components/backtotopbutton.php');
?>

<main>


<!-- lines 3047 on css stylesheet for this page -->



    <?php if ($product): ?> <!-- if product exists -->
        <div class="product-details-container">
        <?php if ($type == 'shirt'): ?> <!-- and product type = shirt -->
   
<?php endif; ?>
        </div>
    <?php else: ?>
        <div class="product-not-found">
            <h2>Product not found</h2>
            <p>Sorry, the product you're looking for could not be found.</p>
        </div>
    <?php endif; ?>
</main>

<?php
// Include the footer file
include('../components/footer.php');
?>

<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>