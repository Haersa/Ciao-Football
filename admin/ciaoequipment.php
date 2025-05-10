<?php
session_start();
$pageTitle = "Ciao Football Equipment Products"; // This will be used in the title tag
$pageDescription = "Ciao Football's Equipment Product Portal"; // This is used as the page desciption meta tag
$pageKeywords = "Equipment Product Portal"; // This is used as the keywords meta tag

// Include the header file
include('../components/adminheader.php');

// Inlude the menu file
include('../components/adminmenu.php');

$sql = "SELECT equipment_id, name, category, description, image, price, brand, quantity FROM equipment"; // get all equipment products
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();


?>

<section class="new-section">
    <div class="new-card">
        <div class="new-content">
            <h2 class="new-title">Add New Equipment Product</h2>
            <p class="new-description">Create and add a new product to your inventory</p>
        </div>
        <div class="new-action">
            <a href="newequipment.php" class="new-button">Create New</a>
        </div>
    </div>
</section>


<section class="equipment-product-container">
    <h1>Equipment</h1>
    <div class="equipment-product-grid">
        <?php while($row = $result->fetch_assoc()): ?> <!-- loop through every equipment product -->
            <div class="equipment-product-card">
                <div class="equipment-product-image">
                    <img src="../<?php echo $row['image']; ?>" alt="<?php echo $row['name'] . ' ' . $row['brand']; ?> equipment">
                </div>
                <div class="equipment-product-details">
                    <h3><?php echo $row['name']; ?></h3>
                    <div class="equipment-product-info">
                        <span class="equipment-product-category"><?php echo $row['category']; ?></span>
                        <span class="equipment-product-brand"><?php echo $row['brand']; ?></span>
                        <span class="equipment-product-quantity">Qty: <?php echo $row['quantity']; ?></span>
                        <span class="equipment-product-price">£<?php echo $row['price']; ?></span>
                    </div>
                    <div class="equipment-product-actions">
                        <a href="adminproductdetails.php?id=<?php echo $row['equipment_id']; ?>" class="equipment-product-view-button">View Details</a>
                        <button type="button" class="equipment-product-delete-button" onclick="document.getElementById('delete-product-id').value='<?php echo htmlspecialchars($row['equipment_id']); ?>'; document.getElementById('delete-equipment-dialog').showModal();">Delete</button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?> <!-- end the loop -->
    </div>
</section>

<dialog id="delete-equipment-dialog" class="delete-dialog"> <!-- start of delete product modal -->
    <div class="dialog-content">
        <h3>Confirm Deletion</h3>
        <p>Are you sure you want to delete this equipment item? This action cannot be undone.</p>
        <div class="dialog-buttons">
            <button class="cancel-button" onclick="document.getElementById('delete-equipment-dialog').close();">Cancel</button>
            <form id="confirm-delete-form" method="POST" action="../backend/deleteProduct.php">
                <input type="hidden" id="delete-product-id" name="productID" value="">
                <input type="hidden" name="productType" value="equipment">
                <button type="submit" name="deleteButton" value="delete" class="modal-remove-button">Delete</button>
            </form>
        </div>
    </div>
</dialog><!-- end of delete product confirmation modal -->

<script src="../js/admin.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>