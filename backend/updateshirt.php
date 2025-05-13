<?php
session_start(); // start session
include('../backend/conn/conn.php'); // connection to database file

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Get shirt id from form

$shirt_ID = $_POST['id'];

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
if(empty($shirtTeam) || empty($shirtCategory) || empty($shirttYear) || empty ($shirtType) || empty($shirtSize) || empty($shirtPrice) || empty($shirtDesc)) {
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


?>