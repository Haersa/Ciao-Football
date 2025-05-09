<?php session_start();
$pageTitle = "Add New Equipment"; 
$pageDescription = "Add a new equipment product to inventory"; 
$pageKeywords = "Add Equipment, Football Equipment"; 

include('../components/adminheader.php');
include('../components/adminmenu.php');
?>




<main><!-- start of main content -->
<section class="equipment-form-container"><!-- start of new equipment section -->
    <div class="equipment-form-header"><!-- start of form header -->
        <h1>Add New Football Equipment</h1>
        <p>Complete the form below to add new equipment to your inventory</p>
    </div><!-- end of form header -->

    <form class="equipment-form" method="POST" action="../backend/addequipment.php" enctype="multipart/form-data"> <!-- start of upload form -->
        <div class="equipment-form-grid"><!-- start of form grid -->
            <div class="equipment-form-group"> <!-- start of form group -->
                <label for="name" class="equipment-form-label">Equipment Name
                    <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
                </label>
                <input type="text" id="name" name="name" class="equipment-form-input" required>
            </div><!-- end of form group -->

            <div class="equipment-form-group"> <!-- start of form group -->
                <label for="category" class="equipment-form-label">Category
                    <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
                </label>
                <select id="category" name="category" class="equipment-form-select" required>
                    <option value="">Select Category</option>
                    <option value="training">Training</option>
                    <option value="match">Match</option>
                    <option value="accessories">Accessories</option>
                    <option value="fitness">Fitness</option>
                </select>
            </div> <!-- end of form group -->

            <div class="equipment-form-group"> <!-- start of form group -->
                <label for="brand" class="equipment-form-label">Brand
                    <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
                </label>
                <input type="text" id="brand" name="brand" class="equipment-form-input">
            </div> <!-- end of form group -->

            <div class="equipment-form-group"> <!-- start of form group -->
                <label for="price" class="equipment-form-label">Price (£)
                    <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
                </label>
                <input type="number" id="price" name="price" class="equipment-form-input" step="0.01" min="0" max = "500" placeholder = "£23.99" required>
            </div> <!-- end of form group -->

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
                <input type="number" id="quantity" name="quantity" class="equipment-form-input" min="1" max = "100" value="1" required>
            </div>

            <div class="equipment-form-group"> <!-- start of form group -->
                <label for="rating" class="equipment-form-label">Rating</label>
                <input type="number" id="rating" name="rating" class="equipment-form-input" step="0.1" min="0" max="5">
            </div> <!-- end of form group -->

            <div class="equipment-form-group equipment-form-checkbox-group"> <!-- start of form group -->
                <label class="equipment-form-checkbox-label">
                    <input type="checkbox" id="sale" name="sale" class="equipment-form-checkbox">
                    <span>Sale Item</span>
                </label>
            </div> <!-- end of form group -->

            <div class="equipment-form-group equipment-form-full"> <!-- start of form group -->
                <label for="description" class="equipment-form-label">Description
                    <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
                </label>
                <textarea id="description" name="description" class="equipment-form-textarea" rows="4" minlength = "0" maxlength = "200" required></textarea>
            </div>  <!-- end of form group -->

            <div class="equipment-form-group equipment-form-full"> <!-- start of form group -->
                <label for="image" class="equipment-form-label">Equipment Image
                    <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
                </label>
                <input type="file" id="image" name="image" class="equipment-form-file" accept=".png, .jpg, .jpeg" required>
                <p class="equipment-form-hint">Upload an image of the equipment (JPEG or PNG)</p>
            </div> <!-- end of form group -->
        </div> <!-- end of form grid -->

        <div class="equipment-form-actions"> <!-- start of form button container -->
            <button type="reset" class="equipment-form-reset-button">Reset Form</button>
            <button type="submit" class="equipment-form-submit-button">Add Equipment</button>
        </div> <!-- end of form group -->
    </form><!-- end of upload form -->
</section><!-- end of new equipment section -->




</main><!-- end of main content -->


<script src="../js/admin.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>