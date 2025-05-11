<?php
session_start();
$pageTitle = "Edit Product Details"; // This will be used in the title tag
$pageDescription = "Edit Product Details"; // This is used as the page desciption meta tag
$pageKeywords = "A Product Portal"; // This is used as the keywords meta tag

// Set error and success icons
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';




// Include the header file
include('../components/adminheader.php');

// Inlude the menu file
include('../components/adminmenu.php');

// Check if product ID and type are provided in the url
if (!isset($_GET['id']) || !isset($_GET['product_type'])) { // if either are not provided
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Product ID or type not specified"; // alert error message to user
    header("Location: " . $_SERVER['HTTP_REFERER']); // revert the user back to the previous page
    exit();
}


$productId = $_GET['id']; // store the product ID in variabel
$productType = $_GET['product_type']; // store the product type (either shirt or equipment) in variable

$product = null; // initialise the product variable as null for now


// Fetch product details based on type
if ($productType === 'shirt') { // if the product type in the url is shirt
    $sql = "SELECT * FROM shirts WHERE shirt_id = ?"; // get all the shirt details where the id matches the shirt id
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc(); // update the product variable and append the product to it
    }
} elseif ($productType === 'equipment') { // if the product type in the url is equipment
    $sql = "SELECT * FROM equipment WHERE equipment_id = ?"; // get all the equipment details where the id matches the equipment id
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc(); // update the product variable and append the product to it
    }
} else {
    $_SESSION['Failed'] = true; // set the failed session flag to true
    $_SESSION['FailMessage'] = "Invalid product type specified" . $errorIcon; // display error message to user
    header("Location: " . $_SERVER['HTTP_REFERER']); // revert the user back to the previous page
    exit();
}
?>

<!-- display the shirt form based on the product type in the url (if product variable isn't null) -->
<?php if($productType === 'shirt' && $product){ ?>
    <section class="shirt-form-container">
    <div class="shirt-form-header">
        <h1>Update Football Shirt</h1>
        <p>Edit the details of the football shirt below</p>
    </div>

    <form class="shirt-form" method="POST" action="../backend/updateshirt.php" enctype="multipart/form-data">
        <input type="hidden" name="shirt_id" value="<?php echo $product['shirt_id']; ?>"> <!-- hidden field for shirt ID -->
        
        <div class="shirt-form-grid">
            <div class="shirt-form-group">
                <label for="team" class="shirt-form-label">Team Name
                    <span class="field-required">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                            <path d="M12 6v12" />
                            <path d="M17.196 9 6.804 15" />
                            <path d="m6.804 9 10.392 6" />
                        </svg>
                    </span>
                </label>
                <input type="text" id="team" name="team" class="shirt-form-input" value="<?php echo htmlspecialchars($product['team']); ?>"> <!-- team name input, displays current team name -->
            </div>

            <div class="shirt-form-group">
                <label for="category" class="shirt-form-label">Category
                    <span class="field-required">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                            <path d="M12 6v12" />
                            <path d="M17.196 9 6.804 15" />
                            <path d="m6.804 9 10.392 6" />
                        </svg>
                    </span>
                </label>
                <select id="category" name="category" class="shirt-form-select"> <!-- category dropdown, pre-selects current category -->
                    <option value="">Select Category</option>
                    <option value="replica" <?php echo ($product['category'] == 'replica') ? 'selected' : ''; ?>>Replica</option>
                    <option value="retro" <?php echo ($product['category'] == 'retro') ? 'selected' : ''; ?>>Retro</option>
                    <option value="specialist" <?php echo ($product['category'] == 'specialist') ? 'selected' : ''; ?>>Specialist</option>
                </select>
            </div>

            <div class="shirt-form-group">
                <label for="year" class="shirt-form-label">Year
                    <span class="field-required">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                            <path d="M12 6v12" />
                            <path d="M17.196 9 6.804 15" />
                            <path d="m6.804 9 10.392 6" />
                        </svg>
                    </span>
                </label>
                <input type="text" id="year" name="year" class="shirt-form-input" placeholder="e.g. 22/23" value="<?php echo htmlspecialchars($product['year']); ?>"> <!-- year input, displays current year value -->
            </div>

            <div class="shirt-form-group">
                <label for="type" class="shirt-form-label">Type
                    <span class="field-required">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                            <path d="M12 6v12" />
                            <path d="M17.196 9 6.804 15" />
                            <path d="m6.804 9 10.392 6" />
                        </svg>
                    </span>
                </label>
                <select id="type" name="type" class="shirt-form-select"> <!-- shirt type dropdown, pre-selects current type -->
                    <option value="">Select Type</option>
                    <option value="Home" <?php echo ($product['type'] == 'Home') ? 'selected' : ''; ?>>Home</option>
                    <option value="Away" <?php echo ($product['type'] == 'Away') ? 'selected' : ''; ?>>Away</option>
                    <option value="Third" <?php echo ($product['type'] == 'Third') ? 'selected' : ''; ?>>Third</option>
                </select>
            </div>

            <div class="shirt-form-group">
                <label for="size" class="shirt-form-label">Size
                    <span class="field-required">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                            <path d="M12 6v12" />
                            <path d="M17.196 9 6.804 15" />
                            <path d="m6.804 9 10.392 6" />
                        </svg>
                    </span>
                </label>
                <select id="size" name="size" class="shirt-form-select"> <!-- size dropdown, pre-selects current size -->
                    <option value="">Select Size</option>
                    <option value="XS" <?php echo ($product['size'] == 'XS') ? 'selected' : ''; ?>>XS</option>
                    <option value="S" <?php echo ($product['size'] == 'S') ? 'selected' : ''; ?>>S</option>
                    <option value="M" <?php echo ($product['size'] == 'M') ? 'selected' : ''; ?>>M</option>
                    <option value="L" <?php echo ($product['size'] == 'L') ? 'selected' : ''; ?>>L</option>
                    <option value="XL" <?php echo ($product['size'] == 'XL') ? 'selected' : ''; ?>>XL</option>
                </select>
            </div>

            <div class="shirt-form-group">
                <label for="price" class="shirt-form-label">Price (£)
                    <span class="field-required">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                            <path d="M12 6v12" />
                            <path d="M17.196 9 6.804 15" />
                            <path d="m6.804 9 10.392 6" />
                        </svg>
                    </span>
                </label>
                <input type="number" id="price" name="price" class="shirt-form-input" step="0.01" min="0" max="500" placeholder="£79.99" value="<?php echo $product['price']; ?>"> <!-- price input, displays current price -->
            </div>

            <div class="shirt-form-group">
                <label for="rating" class="shirt-form-label">Rating</label>
                <input type="number" id="rating" name="rating" class="shirt-form-input" step="0.1" min="0" max="5" placeholder="0.0" value="<?php echo $product['rating']; ?>"> <!-- rating input, displays current rating -->
            </div>

            <div class="shirt-form-group shirt-form-checkbox-group">
                <label class="shirt-form-checkbox-label">
                    <input type="checkbox" id="sale" name="sale" class="shirt-form-checkbox" <?php echo ($product['sale'] == 'yes') ? 'checked' : ''; ?>> <!-- if item is a sale item, pre check the checkbox -->
                    <span>Sale Item</span>
                </label>
            </div>

            <div class="shirt-form-group shirt-form-full">
                <label for="description" class="shirt-form-label">Description
                    <span class="field-required">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                            <path d="M12 6v12" />
                            <path d="M17.196 9 6.804 15" />
                            <path d="m6.804 9 10.392 6" />
                        </svg>
                    </span>
                </label>
                <textarea id="description" name="description" class="shirt-form-textarea" rows="4" minlength="0" maxlength="200"><?php echo htmlspecialchars($product['description']); ?></textarea> <!-- description textarea , displays current description -->
            </div>

            <div class="shirt-form-group shirt-form-full">
                <label for="image" class="shirt-form-label">Shirt Image
                    <span class="field-optional">(Optional - leave blank to keep current image)</span>
                </label>
                <input type="file" id="image" name="image" class="shirt-form-file" accept=".png, .jpg, .jpeg"> <!-- optional image upload field  -->
                <p class="shirt-form-hint">Current image: <?php echo htmlspecialchars($product['image']); ?></p>
                <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($product['image']); ?>"> <!-- hidden field to track current image file -->
            </div>
        </div>

        <div class="shirt-form-actions">
             <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="shirt-form-cancel-button">Cancel</a> <!-- cancel button returns to previous page -->
            <button type="submit" class="shirt-form-submit-button">Update Shirt</button> <!-- submit button to update shirt details -->
        </div>
    </form>
</section>

<!-- Display the equipment form if the product type is equipment (if product variable isn't null) -->
<?php } elseif($productType === 'equipment' && $product){ ?>
<section class="equipment-form-container">
        <div class="equipment-form-header">
            <h1>Update Equipment Item Details</h1>
            <p>Edit the details of the equipment item below</p>
        </div>

        <form class="equipment-form" method="POST" action="../backend/updateequipment.php" enctype="multipart/form-data">
            <input type="hidden" name="equipment_id" value="<?php echo $product['equipment_id']; ?>"> <!-- hidden field for equipment ID -->
            
            <div class="equipment-form-grid">
                <div class="equipment-form-group">
                    <label for="name" class="equipment-form-label">Equipment Name
                        <span class="field-required">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                                <path d="M12 6v12" />
                                <path d="M17.196 9 6.804 15" />
                                <path d="m6.804 9 10.392 6" />
                            </svg>
                        </span>
                    </label>
                    <input type="text" id="name" name="name" class="equipment-form-input" value="<?php echo htmlspecialchars($product['name']); ?>"> <!-- equipment name input, displays current name -->
                </div>

                <div class="equipment-form-group">
                    <label for="category" class="equipment-form-label">Category
                        <span class="field-required">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                                <path d="M12 6v12" />
                                <path d="M17.196 9 6.804 15" />
                                <path d="m6.804 9 10.392 6" />
                            </svg>
                        </span>
                    </label>
                    <select id="category" name="category" class="equipment-form-select"> <!-- category dropdown, pre-selects current category -->
                        <option value="">Select Category</option>
                        <option value="training" <?php echo ($product['category'] == 'training') ? 'selected' : ''; ?>>Training</option>
                        <option value="match" <?php echo ($product['category'] == 'match') ? 'selected' : ''; ?>>Match</option>
                        <option value="accessories" <?php echo ($product['category'] == 'accessories') ? 'selected' : ''; ?>>Accessories</option>
                        <option value="fitness" <?php echo ($product['category'] == 'fitness') ? 'selected' : ''; ?>>Fitness</option>
                    </select>
                </div>

                <div class="equipment-form-group">
                    <label for="brand" class="equipment-form-label">Brand
                        <span class="field-required">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                                <path d="M12 6v12" />
                                <path d="M17.196 9 6.804 15" />
                                <path d="m6.804 9 10.392 6" />
                            </svg>
                        </span>
                    </label>
                    <input type="text" id="brand" name="brand" class="equipment-form-input" value="<?php echo htmlspecialchars($product['brand']); ?>"> <!-- brand input, displays current brand name -->
                </div>

                <div class="equipment-form-group">
                    <label for="price" class="equipment-form-label">Price (£)
                        <span class="field-required">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                                <path d="M12 6v12" />
                                <path d="M17.196 9 6.804 15" />
                                <path d="m6.804 9 10.392 6" />
                            </svg>
                        </span>
                    </label>
                    <input type="number" id="price" name="price" class="equipment-form-input" step="0.01" min="0" max="500" placeholder="£23.99" value="<?php echo $product['price']; ?>"> <!-- price input, displays current price -->
                </div>

                <div class="equipment-form-group">
                    <label for="quantity" class="equipment-form-label">Quantity
                        <span class="field-required">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                                <path d="M12 6v12" />
                                <path d="M17.196 9 6.804 15" />
                                <path d="m6.804 9 10.392 6" />
                            </svg>
                        </span>
                    </label>
                    <input type="number" id="quantity" name="quantity" class="equipment-form-input" min="1" max="200" value="<?php echo $product['quantity']; ?>"> <!-- quantity input, displays current quantity -->
                </div>

                <div class="equipment-form-group">
                    <label for="rating" class="equipment-form-label">Rating</label>
                    <input type="number" id="rating" name="rating" class="equipment-form-input" step="0.1" min="0" max="5" value="<?php echo $product['rating']; ?>"> <!-- rating input, displays current rating -->
                </div>

                <div class="equipment-form-group equipment-form-checkbox-group">
                    <label class="equipment-form-checkbox-label">
                        <input type="checkbox" id="sale" name="sale" class="equipment-form-checkbox" <?php echo ($product['sale'] == 'yes') ? 'checked' : ''; ?>> <!-- if item is a sale item, pre check the checkbox -->
                        <span>Sale Item</span>
                    </label>
                </div>

                <div class="equipment-form-group equipment-form-full">
                    <label for="description" class="equipment-form-label">Description
                        <span class="field-required">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                                <path d="M12 6v12" />
                                <path d="M17.196 9 6.804 15" />
                                <path d="m6.804 9 10.392 6" />
                            </svg>
                        </span>
                    </label>
                    <textarea id="description" name="description" class="equipment-form-textarea" rows="4" minlength="0" maxlength="200" ><?php echo htmlspecialchars($product['description']); ?></textarea> <!-- description textarea, displays current description -->
                </div>

                <div class="equipment-form-group equipment-form-full">
                    <label for="image" class="equipment-form-label">Equipment Image
                        <span class="field-optional">(Optional - leave blank to keep current image)</span>
                    </label>
                    <input type="file" id="image" name="image" class="equipment-form-file" accept=".png, .jpg, .jpeg"> <!-- optional image upload field -->
                    <p class="equipment-form-hint">Current image: <?php echo htmlspecialchars($product['image']); ?></p>
                    <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($product['image']); ?>"> <!-- hidden field to track current image file -->
                </div>
            </div>

            <div class="equipment-form-actions">
                <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" class="equipment-form-cancel-button">Cancel</a> <!-- cancel button returns to previous page -->
                <button type="submit" class="equipment-form-submit-button">Update Equipment</button> <!-- submit button to update equipment details -->
            </div>
        </form>
    </section>
<?php } ?>






<script src="../js/admin.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>