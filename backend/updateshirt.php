<?php
session_start(); // start session
include('../backend/conn/conn.php'); // connection to database file

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Get shirt id from form

$shirt_ID = $_POST['shirt_id'];

// Get the rest of the shirt fields and store in variable

$shirtTeam = trim($_POST['team']);
$shirtCategory = trim($_POST['category']);
$shirtYear = trim($_POST['year']);
$shirtType = trim($_POST['type']);
$shirtSize = trim($_POST['size']);
$shirtPrice = floatval($_POST['price']);
$shirtRating =isset($_POST['rating']) ? floatval($_POST['rating']) : 0;
$isSale = isset($_POST['sale']) ? 'yes' : 'no';
$shirtDesc = $_POST['description'];
$currentImage = $_POST['current_image'];

// Validate empty fields
if(empty($shirtTeam) || empty($shirtCategory) || empty($shirtYear) || empty ($shirtType) || empty($shirtSize) || empty($shirtPrice) || empty($shirtDesc)) {
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "All fields must be filled " . $errorIcon; // display error message
    header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
    exit();
}

// Validate the shirts team name 
if(strlen($shirtTeam) > 50){
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Team name must be less than 50 characters " . $errorIcon; // display error message to user
    header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
    exit();
}

// Validate the shirt type
$validShirtTypes =['Home', 'Away', 'Third']; // store shirt types in array to compare inputted type to the types inside the array
if(!in_array($shirtType, $validShirtTypes)){
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Invalid shirt type selected " . $errorIcon; // display error message to user
    header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
    exit();
}

// Validate the shirt category
$validShirtCategories = ['replica', 'retro', 'specialist']; // store valid shirt categories in array to do the same
if(!in_array($shirtCategory, $validShirtCategories)){
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Invalid shirt category selected " . $errorIcon; // display error message to user
    header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
    exit();
} elseif(is_numeric($shirtTeam)){
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Team must contain only letters " . $errorIcon; // display error message to user
    header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
    exit();
}

// Validate the price input
if($shirtPrice <= 0 || $shirtPrice > 500){ // if price is less than or equal to 0, or greater than 500
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Price must be between £0.01 and £500 " . $errorIcon; // display error message to user
    header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
    exit();
}

// Validate the sizing range
$validShirtSizes = ['XS', 'S', 'M', 'L', 'XL']; // store all valid sizes in array
if(!in_array($shirtSize, $validShirtSizes)){
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Choose: XS, S, M, L or XL only " . $errorIcon; // display error message to user
    header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
    exit();
}

// Validate the product rating
if((!empty($shirtRating) && !is_numeric($shirtRating)) || $shirtRating < 0 || $shirtRating > 5){
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Rating must be between 0 and 5 " . $errorIcon; // display error message
    header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
    exit();
}

// Validate the description length
if(strlen($shirtDesc) > 200){
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Description cannot exceed 200 characters " . $errorIcon; // display error message
    header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
    exit();
}

// Set database image path to current image
$dbImagePath = $currentImage;

// generate a random 4-digit ID for the image (this is to prevent images having the same name)
$generateNewImageID = rand(1000, 9999);

// Handle image upload if a new one is provided
if(isset($_FILES['image']) && $_FILES['image'] ['error'] === 0){
    $allowedFileFormats = ['image/jpeg', 'image/jpg', 'image/png']; // store the allowed image file formats in an array
    $uploadedImageFormat = $_FILES['image']['type']; // get the uploaded image's file format

    // Check if the uploaded file is an allowed/accepted file format
    if(!in_array($uploadedImageFormat, $allowedFileFormats)) {
        $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
        $_SESSION['FailMessage'] = "Only JPEG and PNG images are allowed " . $errorIcon; // display error message to user
        header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
        exit();
    }

    // Get file extension from original filename
    $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION); // get the file extension from the file name

    // Create new filename with extension
    $newFileName = 'shirt_' . $shirtTeam. '_' . $shirtYear. $generateNewImageID . '.' . $fileExtension; // generate and append a random 4 digit number to the image file

    // Create directory if it doesn't exist

    $uploadDir = '../productimages/';
    if(!file_exists($uploadDir)){
        mkdir($uploadDir, 0777, true);
    }

    // Set upload paths
    $uploadPath = __DIR__ . '/../productimages/' . $newFileName; // set the upload path
    $dbImagePath = 'productimages/' . $newFileName; // set the database upload path

    // If the file already exists, delete it
    if(file_exists($uploadPath)) {
        unlink($uploadPath); // delete the existing file
    }

    // Move the new file to the folder
    if(!move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)){
        $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
        $_SESSION['FailMessage'] = "Failed to save the uploaded image " . $errorIcon; // display error message to user
        header('Location: ' . $_SERVER['HTTP_REFERER']); // revert the user back to the same page to let them try again
        exit();
    }

    // Delete old image if it exists
    $old_image_path = __DIR__ . '/../' . $currentImage;
    if(!empty($currentImage) && file_exists($old_image_path)){
        unlink($old_image_path); // delete the old image
    }
}

// If the rating input is left empty in the form, set a default value of 0
if(empty($shirtRating)){
    $shirtRating = 0.0; // default rating if none is provided
}

// Update shirt item in database
$updateQuery = "UPDATE shirts set team = ?, category = ?, year = ?, type = ?, size = ?, sale = ?, price = ?, description = ?, image = ?, rating = ? WHERE shirt_id = ?";

    // Prepare upate statement
$stmt = mysqli_prepare($conn, $updateQuery);

// Bind parameters
mysqli_stmt_bind_param($stmt, "ssssssdssdi", $shirtTeam,  $shirtCategory, $shirtYear, $shirtType, $shirtSize, $isSale, $shirtPrice, $shirtDesc, $dbImagePath, $shirtRating, $shirt_ID
);

// Execute Statement
if(mysqli_stmt_execute($stmt)){
    $_SESSION['Success'] = true; // set success session variable to true for displaying success message
    $_SESSION['SuccessMessage'] = "Shirt updated successfully" . $successIcon; // display success message to user
    header('Location: ../admin/ciaoproducts.php'); // redirect to shirt products page incase the admin needs to update more products 
} else {
    // If database insert fails, delete the uploaded image 
    if (isset($uploadPath) && file_exists($uploadPath)) {
        unlink($uploadPath); // delete the uploaded image
    }
    
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Error updating shirt data " . $errorIcon; // display error message to user 
    header('Location: ' . $_SERVER['HTTP_REFERER']); // refresh page to let user try again
}

// Close the prepared statement
mysqli_stmt_close($stmt);

// Close database connection
mysqli_close($conn);
exit();
?>