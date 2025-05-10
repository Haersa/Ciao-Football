<?php
session_start(); // start session
include('../backend/conn/conn.php'); // connection to database file

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Collect form data (trim for any white space)

$equipmentName = trim($_POST['name']);
$productCategory = trim($_POST['category'];)
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

$ValidEquipmentCategories = ['match', 'training', 'accessories']; // valid categories from the db table
if(!in_array($productCategory, $ValidEquipmentCategories)){
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Invalid category selected" . $errorIcon; // display error message to user
    header("Location: ../admin/newshirt.php"); // redirect to shirt upload page to let them try again
    exit();
}


































?> 




