<?php
session_start(); // start session
include('../backend/conn/conn.php'); // connection to database file

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';


// Collect form data (trim for any white space)
$team = trim($_POST['team']);
$category = trim($_POST['category']);
$year = trim($_POST['year']);
$type = trim($_POST['type']);
$size = trim($_POST['size']);
$price = trim($_POST['price']);
$rating = trim($_POST['rating']);
$sale = isset($_POST['sale']) ? 'yes' : 'no'; // convert checkbox to yes/no for database column 
$description = trim($_POST['description']);

// Validate required form fields
if (empty($team) || empty($category) || empty($year) || empty($type) || empty($size) || empty($price) || empty($description)) { // if any required form fields are empty
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "All fields are required" . $errorIcon; // display error message to user
    header("Location: ../admin/newshirt.php"); // redirect to shirt upload page to let them try again
    exit();
}

// Validate price input
if (!is_numeric($price) || $price < 0 || $price > 500) { // check price is a valid number within range
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Price must be a valid number between 0 and 500" . $errorIcon; // display error message to user
    header("Location: ../admin/newshirt.php"); // redirect to shirt upload page to let them try again
    exit();
}

// Validate rating if provided
if (!empty($rating) && (!is_numeric($rating) || $rating < 0 || $rating > 5)) { // check rating is a valid number within range
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Rating must be a valid number between 0 and 5" . $errorIcon; // display error message to user
    header("Location: ../admin/newshirt.php"); // redirect to shirt upload page to let them try again
    exit();
}

// Validate the shirt category
$validCategories = ['replica', 'retro', 'specialist']; // set the category options inside an array
if (!in_array($category, $validCategories)) { // if category from the form doesn't match the categories inside the array
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Invalid category selected" . $errorIcon; // display error message to user
    header("Location: ../admin/newshirt.php"); // redirect to shirt upload page to let them try again
    exit();
}


// do the same for the shirt types
$validTypes = ['Home', 'Away', 'Third']; // do thje same for the shirt types
if (!in_array($type, $validTypes)) { // if type is not in the valid options
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Invalid type selected" . $errorIcon; // display error message to user
    header("Location: ../admin/newshirt.php"); // redirect to shirt upload page to let them try again
    exit();
}

// and the shirt sizes
$validSizes = ['XS', 'S', 'M', 'L', 'XL']; // do the same for the sizes
if (!in_array($size, $validSizes)) { // if size is not in the valid options
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Invalid size selected" . $errorIcon; // display error message to user
    header("Location: ../admin/newshirt.php"); // redirect to shirt upload page to let them try again
    exit();
}

// Validate description length
if (strlen($description) > 200) { // if description is longer than 200 characters
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Description must be less than 200 characters" . $errorIcon; // display error message to user
    header("Location: ../admin/newshirt.php"); // redirect to shirt upload page to let them try again
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
    $newFileName = 'shirt_' . $team . '_' . $generateNewImageID . '.' . $fileExtension; // generate and append a random 4 digit number to the image file
    
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
    
    // SQL query to add the new shirt and it's data to the db tabler
    $insertQuery = "INSERT INTO shirts (team, category, year, type, size, sale, price, description, image, rating, quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; // SQL query to add new shirt to database
    $stmt = mysqli_prepare($conn, $insertQuery); 
    
    // if the rating input is left empty in the form, set a default value of 0
    if (empty($rating)) {
        $rating = 0.0; // default rating if none provided
    }
    $quantity = 1; // shirts are unique items, so quantity is always 1
    
    // Bind parameters 
    mysqli_stmt_bind_param($stmt, "ssssssdssdi", $team, $category, $year, $type, $size, $sale, $price, $description, $dbImagePath, $rating, $quantity);
    
    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['Success'] = true; // set success session variable to true for displaying success message
        $_SESSION['SuccessMessage'] = "Shirt added successfully" . $successIcon; // display success message to user
        header("Location: ../admin/newshirt.php"); // redirect to products page
    } else {
        // If database insert fails, delete the uploaded image 
        if (file_exists($uploadPath)) {
            unlink($uploadPath); // delete the uploaded image
        }
        
        $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
        $_SESSION['FailMessage'] = "Error adding shirt to database: " . mysqli_error($conn) . $errorIcon; // display error message to user with the specific MySQL error
        header("Location: ../admin/newshirt.php"); // redirect to shirt upload page to let them try again
    }
    
    // Close the prepared statement
    mysqli_stmt_close($stmt);
    
} else {
    // No file was uploaded or an error occurred
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Please upload an image file" . $errorIcon; // display error message to user
    header("Location: ../admin/newshirt.php"); // redirect to shirt upload page to let them try again
    exit();
}

// Close database connection
mysqli_close($conn);
exit();



?>