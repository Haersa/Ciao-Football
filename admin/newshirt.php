<?php session_start();
$pageTitle = "Add New Shirt"; 
$pageDescription = "Add a new football shirt to inventory"; 
$pageKeywords = "Add Shirt, Football Shirts"; 

include('../components/adminheader.php');
include('../components/adminmenu.php');
?>




<main><!-- start of main content -->
<section class="shirt-form-container"><!-- start of new shirt section -->
    <div class="shirt-form-header"><!-- start of form header -->
        <h1>Add New Football Shirt</h1>
        <p>Complete the form below to add a new shirt to your inventory</p>
    </div><!-- end of form header -->

    <form class="shirt-form" method="POST" action="../backend/addshirt.php" enctype="multipart/form-data"> <!-- start of upload form -->
        <div class="shirt-form-grid"><!-- start of form grid -->
            <div class="shirt-form-group"> <!-- start of form group -->
                <label for="team" class="shirt-form-label">Team Name 
                     <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
                </label>
                <input type="text" id="team" name="team" class="shirt-form-input" required>
            </div><!-- end of form group -->

            <div class="shirt-form-group"> <!-- start of form group -->
                <label for="category" class="shirt-form-label">Category 
                     <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
                </label>
                <select id="category" name="category" class="shirt-form-select" required>
                    <option value="">Select Category</option>
                    <option value="replica">Replica</option>
                    <option value="retro">Retro</option>
                    <option value="specialist">Specialist</option>
                </select>
            </div> <!-- end of form group -->

            <div class="shirt-form-group"> <!-- start of form group -->
                <label for="year" class="shirt-form-label">Year 
                     <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
                </label>
                <input type="text" id="year" name="year" class="shirt-form-input" placeholder="e.g. 22/23" required>
            </div> <!-- end of form group -->

            <div class="shirt-form-group"> <!-- start of form group -->
                <label for="type" class="shirt-form-label">Type 
                     <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
                </label>
                <select id="type" name="type" class="shirt-form-select" required>
                    <option value="">Select Type</option>
                    <option value="Home">Home</option>
                    <option value="Away">Away</option>
                    <option value="Third">Third</option>
                </select>
            </div> <!-- end of form group -->

            <div class="shirt-form-group"> <!-- start of form group -->
                <label for="size" class="shirt-form-label">Size 
                     <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
                </label>
                <select id="size" name="size" class="shirt-form-select" required>
                    <option value="">Select Size</option>
                    <option value="XS">XS</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                </select>
            </div> <!-- end of form group -->

            <div class="shirt-form-group"> <!-- start of form group -->
                <label for="price" class="shirt-form-label">Price (£) 
                     <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
                </label>
                <input type="number" id="price" name="price" class="shirt-form-input" step="0.01" min="0" max="500" placeholder="£79.99" required>
            </div> <!-- end of form group -->

            <div class="shirt-form-group"> <!-- start of form group -->
                <label for="rating" class="shirt-form-label">Rating</label>
                <input type="number" id="rating" name="rating" class="shirt-form-input" step="0.1" min="0" max="5" placeholder="0.0">
            </div> <!-- end of form group -->

            <div class="shirt-form-group shirt-form-checkbox-group"> <!-- start of form group -->
                <label class="shirt-form-checkbox-label">
                    <input type="checkbox" id="sale" name="sale" class="shirt-form-checkbox">
                    <span>Sale Item</span>
                </label>
            </div> <!-- end of form group -->

            <div class="shirt-form-group shirt-form-full"> <!-- start of form group -->
                <label for="description" class="shirt-form-label">Description 
                     <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
                </label>
                <textarea id="description" name="description" class="shirt-form-textarea" rows="4" minlength="0" maxlength="200" required></textarea>
            </div> <!-- end of form group -->

            <div class="shirt-form-group shirt-form-full"> <!-- start of form group -->
                <label for="image" class="shirt-form-label">Shirt Image 
                     <span class="field-required">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-asterisk-icon lucide-asterisk">
                        <path d="M12 6v12" />
                        <path d="M17.196 9 6.804 15" />
                        <path d="m6.804 9 10.392 6" />
                    </svg>
                </span>
                </label>
                <input type="file" id="image" name="image" class="shirt-form-file" accept=".png, .jpg, .jpeg" required>
                <p class="shirt-form-hint">Upload an image of the shirt (JPEG or PNG)</p>
            </div> <!-- end of form group -->
        </div> <!-- end of form grid -->

        <div class="shirt-form-actions"> <!-- start of form button container -->
            <button type="reset" class="shirt-form-reset-button" onClick="window.location.reload();">Reset Form</button>
            <button type="submit" class="shirt-form-submit-button">Add Shirt</button>
        </div> <!-- end of form button container -->
    </form><!-- end of upload form -->
</section><!-- end of new shirt section -->

</main><!-- end of main content -->


<script src="../js/admin.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>