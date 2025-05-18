<?php
session_start(); // start session
include('../backend/conn/conn.php'); // connection to database file

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Get equipment ID from form
$equipment_id = $_POST['equipment_id'];

// store update form inputs in variables
$equipmentName = trim($_POST['name']);
$productCategory = trim($_POST['category']);
$productBrand = trim($_POST['brand']);
$productPrice = floatval($_POST['price']);
$productQuantity = intval($_POST['quantity']);
$productRating = isset($_POST['rating']) ? floatval($_POST['rating']) : 0;
$productsSale = isset($_POST['sale']) ? 'yes' : 'no'; // convert the checkbox to either yes or no to match db column data
$productDesc = trim($_POST['description']);
$current_image = $_POST['current_image'];

// Validate empty fields
if(empty($equipmentName) || empty($productCategory) || empty($productBrand) || empty ($productPrice) || empty($productQuantity) || empty($productDesc)) {
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "All fields must be filled " . $errorIcon; // display error message
    header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
    exit();
}

// Validate the product category
$ValidEquipmentCategories = ['match', 'training', 'accessories', 'fitness']; // sore existing categories inside an array
if(!in_array($productCategory, $ValidEquipmentCategories)){ // if the inputted category isn't a valid category
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Invalid category selected " . $errorIcon; // display error message to user
    header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
    exit();
}

// Validate the product brand
if(strlen($productBrand) > 100) { // if brand is longer than 100 characters
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Brand must be less than 100 characters " . $errorIcon; // display error message to user
    header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
    exit();
} elseif(is_numeric($productBrand)) { // or if the brand contains numbers
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Brand must not contain only numbers " . $errorIcon; // display error message to user
    header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
    exit();
}

// Validate the price input
if($productPrice <= 0 || $productPrice > 500) { // if price is more than 500 and less than 0
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Price must be between £0.01 and £500 " . $errorIcon; // display error message
    header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
    exit();
}

// Validate quantity range
if($productQuantity < 1 || $productQuantity > 200) { // if quantity is more than 200 and less than 1
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Quantity must be between 1 and 200 " . $errorIcon; // display error message
    header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
    exit();
}

// Validate rating range
if((!empty($productRating) && !is_numeric($productRating)) || $productRating < 0 || $productRating > 5) { // if the rating is less than 0 but more than 5 and contains non number charactyers
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Rating must be between 0 and 5 " . $errorIcon; // display error message
    header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
    exit();
}

// Validate description length
if(strlen($productDesc) > 200) { // if the description is more than 200 characters
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Description cannot exceed 200 characters " . $errorIcon; // display error message
    header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
    exit();
}

// Set database image path to current image
$dbImagePath = $current_image;

// Generate a random 4-digit ID for the image (this is to prevent images having the same name)
$generateNewImageID = rand(1000, 9999);

// Handle image upload if a new one is provided
if(isset($_FILES['image']) && $_FILES['image']['error'] === 0) { // check if file was uploaded successfully
    $allowedFileFormats = ['image/jpeg', 'image/jpg', 'image/png']; // store the allowed image file formats in an array
    $uploadedImageFormat = $_FILES['image']['type']; // get the uploaded image's file format

    // Check if the uploaded file is an allowed/accepted file format
    if(!in_array($uploadedImageFormat, $allowedFileFormats)) { // if the uploaded files format doesn't match the accepted formats
        $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
        $_SESSION['FailMessage'] = "Only JPEG and PNG images are allowed " . $errorIcon; // display error message to user
        header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
        exit();
    }
    
    // Get file extension from original filename
    $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); // get the file extension from the file name
    
    // Create new filename with extension
    $newFileName = 'equipment_' . $equipmentName . '_' . $generateNewImageID . '.' . $fileExtension; // generate and append a random 4 digit number to the image file
    
    // Create directory if it doesn't exist
    $uploadDir = '../productimages/';
    if(!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    
    // Set upload paths
    $uploadPath = __DIR__ . '/../productimages/' . $newFileName;  // set the upload path
    $dbImagePath = 'productimages/' . $newFileName; // set the database upload path
    
    // If the file already exists, delete it
    if(file_exists($uploadPath)) {
        unlink($uploadPath); // delete the existing file
    }
    
    // Move the new file to the folder
    if(!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) { // if the saving of the new file fails
        $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
        $_SESSION['FailMessage'] = "Failed to save the uploaded image " . $errorIcon; // display error message to user
        header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
        exit();
    }
    
    // Delete old image if it exists
    $old_image_path = __DIR__ . '/../' . $current_image;
    if(!empty($current_image) && file_exists($old_image_path)) {
        unlink($old_image_path); // delete the old image
    }
}

// If the rating input is left empty in the form, set a default value of 0
if(empty($productRating)) {
    $productRating = 0.0; // default rating if none provided
}

// Update equipment item in database
$updateQuery = "UPDATE equipment SET name = ?,  category = ?, brand = ?, price = ?, quantity = ?, rating = ?, sale = ?, description = ?, image = ? WHERE equipment_id = ?";

$stmt = mysqli_prepare($conn, $updateQuery);

if($stmt) {
    mysqli_stmt_bind_param($stmt, "ssssdisssi", $equipmentName, $productCategory, $productBrand, $productPrice, $productQuantity, $productRating, $productsSale, $productDesc, $dbImagePath, $equipment_id);
    
    $updateResult = mysqli_stmt_execute($stmt);
    
    if($updateResult) {
        $_SESSION['Success'] = true; // set success session variable to true for displaying success message
        $_SESSION['SuccessMessage'] = "Equipment updated successfully " . $successIcon; // display success message to user
        header('Location: ../admin/ciaoequipment.php');
        exit();
    } else {
        $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
        $_SESSION['FailMessage'] = "Failed to update equipment " . $errorIcon; // display error message to user
        header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
        exit();
    }
} else {
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Database error " . $errorIcon; // display error message to user
    header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
    exit();
}

// Close database connection
mysqli_close($conn);
exit();
?>