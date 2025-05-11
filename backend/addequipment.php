<?php
session_start(); // start session
include('../backend/conn/conn.php'); // connection to database file

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Collect form data (trim for any white space)

$equipmentName = trim($_POST['name']);
$productCategory = trim($_POST['category']);
$productBrand = trim($_POST['brand']);
$productPrice = trim($_POST['price']);
$productQuantity =trim($_POST['quantity']);
$productRating = trim($_POST['rating']);
$productsSale = isset($_POST['sale']) ? 'yes' : 'no'; // convert checkbox to yes/no for database column 
$productDesc = trim($_POST['description']);


// Validate required form fields

if(empty($equipmentName) || empty($productCategory) || empty($productBrand) || empty($productPrice) || empty($productQuantity) || empty($productDesc)) { // if any of the required form fields are left blank, return error message
$_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
$_SESSION['FailMessage'] = "All fields are required" . $errorIcon; // display error message to user
header("Location: ../admin/newequipment.php"); // redirect to equipment upload page to let them try again
exit();
}

// Validate price input
if (!is_numeric($productPrice) || $productPrice < 0 || $productPrice > 500) { // check price is a valid number within range
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Price must be a valid number between 0 and 500" . $errorIcon; // display error message to user
    header("Location: ../admin/newequipment.php"); // redirect to equipment upload page to let them try again
    exit();
}

// Validate rating if provided
if (!empty($productRating) && (!is_numeric($productRating) || $productRating < 0 || $productRating > 5)) { // check rating is a valid number within range
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Rating must be a valid number between 0 and 5" . $errorIcon; // display error message to user
    header("Location: ../admin/newshirt.php"); // redirect to shirt upload page to let them try again
    exit();
}

// Validate the product category

$ValidEquipmentCategories = ['match', 'training', 'accessories', 'fitness']; // valid categories from the db table
if(!in_array($productCategory, $ValidEquipmentCategories)){
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Invalid category selected" . $errorIcon; // display error message to user
    header("Location: ../admin/newshirt.php"); // redirect to shirt upload page to let them try again
    exit();
}

// Validate the product brand

if (strlen($productBrand) > 100) { // if brand is longer than 100 characters
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Brand must be less than 100 characters" . $errorIcon; // display error message to user
    header("Location: ../admin/newequipment.php"); // redirect to equipment upload page to let them try again
    exit();
} elseif (is_numeric($productBrand)) { // or if the brand contains numbers
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Brand must not contain numbers" . $errorIcon; // display error message to user
    header("Location: ../admin/newequipment.php"); // redirect to equipment upload page to let them try again
    exit();
}

// Validate the description length
if(strlen($productDesc) > 200){
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Description must be less than 200 characters" . $errorIcon; // display error message to user
    header("Location: ../admin/newequipment.php"); // redirect to equipment upload page to let them try again
    exit();
}

// Generate a random 4-digit ID for the image (this is to prevent images having the same name)
$generateNewImageID = rand(1000, 9999);

// Upload the image
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) { // check if file was uploaded successfully
    $allowedFileFormats = ['image/jpeg', 'image/jpg', 'image/png']; // store the allowed image file formats in an array
    $uploadedImageFormat = $_FILES['image']['type']; // get the uploaded image's file format

    // Check if the uploaded file is an allowed/accepted file format
    if (!in_array($uploadedImageFormat, $allowedFileFormats)) {
        $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
        $_SESSION['FailMessage'] = "Only JPEG and PNG images are allowed" . $errorIcon; // display error message to user
        header("Location: ../admin/newshirt.php"); // redirect to shirt upload page to let them try again
        exit();
    }

     // Get file extension from original filename
    $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    
    // Create new filename with extension
    $newFileName = 'equipment_' . $equipmentName . '_' . $generateNewImageID . '.' . $fileExtension; // generate and append a random 4 digit number to the image file

    // Create directory if it doesn't exist
    $uploadDir = '../productimages/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Set upload paths
    $uploadPath = __DIR__ . '/../productimages/' . $newFileName;  // set the upload path
    $dbImagePath = 'productimages/' . $newFileName; // set the database upload path

    // If the file already exists, delete it
    if (file_exists($uploadPath)) {
        unlink($uploadPath); // delete the existing file
    }

     // Move the new file to the folder
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
        $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
        $_SESSION['FailMessage'] = "Failed to save the uploaded image" . $errorIcon; // display error message to user
        header("Location: ../admin/newshirt.php"); // redirect to shirt upload page to let them try again
        exit();
    }

    // SQL query to add the new equipment and its data to the db
    $insertQuery = "INSERT INTO equipment (name, category, description, image, price, quantity, brand, sale, rating) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"; // SQL query to add new equipment to database
    $stmt = mysqli_prepare($conn, $insertQuery); 

 // if the rating input is left empty in the form, set a default value of 0
    if (empty($productRating)) {
        $productRating = 0.0; // default rating if none provided
    }
    
    // Bind parameters 
    mysqli_stmt_bind_param($stmt, "ssssdissd", $equipmentName, $productCategory, $productDesc, $dbImagePath, $productPrice, $productQuantity, $productBrand, $productsSale, $productRating);
    
    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['Success'] = true; // set success session variable to true for displaying success message
        $_SESSION['SuccessMessage'] = "Equipment added successfully" . $successIcon; // display success message to user
        header("Location: ../admin/newequipment.php"); // redirect to equipment page
    } else {
        // If database insert fails, delete the uploaded image 
        if (file_exists($uploadPath)) {
            unlink($uploadPath); // delete the uploaded image
        }
        
        $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
        $_SESSION['FailMessage'] = "Error adding equipment to database: " . $errorIcon; // display error message to user 
        header("Location: ../admin/newequipment.php"); // redirect to equipment upload page to let them try again
    }
    
    // Close the prepared statement
    mysqli_stmt_close($stmt);
    
} else {
    // No file was uploaded or an error occurred
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Please upload an image file" . $errorIcon; // display error message to user
    header("Location: ../admin/newequipment.php"); // redirect to equipment upload page to let them try again
    exit();
}

// Close database connection
mysqli_close($conn);
exit();
?>

















































