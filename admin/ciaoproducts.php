<?php
session_start();
$pageTitle = "Ciao Football Products"; // This will be used in the title tag
$pageDescription = "Ciao Football's Product Portal"; // This is used as the page desciption meta tag
$pageKeywords = "A Product Portal"; // This is used as the keywords meta tag

// Include the header file
include('../components/adminheader.php');

// Inlude the menu file
include('../components/adminmenu.php');

$sql = "SELECT shirt_id, image, team, year, type FROM shirts"; // get all shirt products
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<section class="new-section">
    <div class="new-card">
        <div class="new-content">
            <h2 class="new-title">Add New Product</h2>
            <p class="new-description">Create and add a new product to your inventory</p>
        </div>
        <div class="new-action">
            <a href="newshirt.php" class="new-button">Create New</a>
        </div>
    </div>
</section>


<section class="shirt-product-container">
    <h1>Football Shirts</h1>
    <div class="shirt-product-grid">
        <?php while($row = $result->fetch_assoc()): ?> <!-- loop through every shirt product -->
            <div class="shirt-product-card">
                <div class="shirt-product-image">
                    <img src="../<?php echo $row['image']; ?>" alt="<?php echo $row['team'] . ' ' . $row['year'] . ' ' . $row['type']; ?> shirt">
                </div>
                <div class="shirt-product-details">
                    <h3><?php echo $row['team']; ?></h3>
                    <div class="shirt-product-info">
                        <span class="shirt-product-year"><?php echo $row['year']; ?></span>
                        <span class="shirt-product-type"><?php echo $row['type']; ?></span>
                    </div>
                    <div class="shirt-product-actions">
                    <a href="adminproductdetails.php?id=<?php echo $row['shirt_id']; ?>" class="shirt-product-view-button">View Details</a>
                        <button type="button" class="shirt-product-delete-button" onclick="document.getElementById('delete-product-id').value='<?php echo htmlspecialchars($row['shirt_id']); ?>'; document.getElementById('delete-shirt-dialog').showModal();">Delete</button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?> <!-- end the loop -->
    </div>
</section>


<dialog id="delete-shirt-dialog" class="delete-dialog"> <!-- start of delete product modal -->
    <div class="dialog-content">
        <h3>Confirm Deletion</h3>
        <p>Are you sure you want to delete this shirt? This action cannot be undone.</p>
        <div class="dialog-buttons">
            <button class="cancel-button" onclick="document.getElementById('delete-shirt-dialog').close();">Cancel</button>
            <form id="confirm-delete-form" method="POST" action="../backend/deleteProduct.php">
                <input type="hidden" id="delete-product-id" name="productID" value="">
                <input type="hidden" name="productType" value="shirt">
                <button type="submit" name="deleteButton" value="delete" class="modal-remove-button">Delete</button>
            </form>
        </div>
    </div>
</dialog><!-- end of delete product confirmation modal -->



<script src="../js/admin.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>