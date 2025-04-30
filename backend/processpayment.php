<?php
session_start(); // Start or resume the session
include('../backend/conn/conn.php'); // connection to database file

// Set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Set variables from post data within payment form
$name = $_POST['cardholderName'];
$cardNumber = $_POST['CardNumber'];
$expiryDate = $_POST['expiryDate'];
$cvv = $_POST['CVV'];

$required_fields = ['cardholderName', 'CardNumber', 'expiryDate', 'CVV']; // fields that must be filled
$missing_fields = []; // set empty array to store missing fields in

foreach ($required_fields as $field) { // loop through each required field and store as $field
    if (empty($_POST[$field])) {
        $missing_fields[] = $field; // if field is empty, add to array
    }
}

// Check if form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
// Validate payment detail fields/inputs
if (count($missing_fields) > 0) {
    // Some required fields are missing
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Please fill in all required payment details " . $errorIcon; // alert failed message to user
    
    // Redirect back to the payment page to let them try again
    header("Location: ../frontend/payment.php");
    exit();
}

// Validate Card holder name field to ensure only letters and special characters like spaces or apostrophes are accepted

// trim the name to remove any spaces
$trimmedName = trim($name);

// First check if the length is within allowed range
if (strlen($trimmedName) < 2 || strlen($trimmedName) > 50) {
    // Name is too long or too short
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Name must be between 2 and 50 characters" . $errorIcon; // alert failed message to user
    
    // Redirect back to the payment page to let them try again
    header("Location: ../frontend/payment.php");
    exit();
}

// Next, check if the name contains any numbers or special characters like spaces or apostrophes
if (!preg_match('/^[a-zA-Z \'-]+$/', $trimmedName)) { // use regex to check if name contains only letters, spaces, hyphens, and apostrophes
    // Name contains invalid characters
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Name can only contain letters, spaces, hyphens, and apostrophes " . $errorIcon; // alert failed message to user
    
    // Redirect back to the payment page
    header("Location: ../frontend/payment.php");
    exit();
}


// Validate the card number field to ensire only numbers are accepted
// trim the card number to remove any spaces
$trimmedCardNumber = trim($cardNumber);

$cardnumberNoSpaces = str_replace(' ', '', $trimmedCardNumber); // remove the spaces the user could possibly type in the form field, as usging the is_numeric function on $cardNumber wouldn't work with the spaces

if (!is_numeric($cardnumberNoSpaces)) {
    // Card number contains non-numeric characters
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Enter Numeric characters only" . $errorIcon; // alert failed message to user
    
    // Redirect back to the payment page to let them try again
    header("Location: ../frontend/payment.php");
    exit();
}

// Next, validate card number length to ensure it is 16 digits long (account for 19 as the user can enter spaces o ndesktop)
$cardNumberNoSpaces = str_replace(' ', '', $cardNumber);
if (!preg_match('/^[0-9]{16,19}$/', $cardNumberNoSpaces)) {
    // Card number is not between 16-19 digits
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Card number must be between 16 and 19 digits " . $errorIcon; // 
    header("Location: ../frontend/payment.php"); // Redirect back to the payment page to let them try again
    exit();
}
    
// Validate the expiry date field to ensure only numbers are accepted

// Trim the expiry date to remove any spaces
$trimmedExpiryDate = trim($expiryDate);

// Check that the expiry date contains exactly 4 digits
if (!preg_match('/^[0-9]{4}$/', $trimmedExpiryDate)) {
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Expiry date must be 4 digits (MMYY) " . $errorIcon; // alert failed message to user
    header("Location: ../frontend/payment.php"); // Redirect back to the payment page to let them try again
    exit();
}

// Extract month and year and convert to integers
$month = (int)substr($trimmedExpiryDate, 0, 2); // get the month as an integer from the expiry date input
$year = (int)substr($trimmedExpiryDate, 2, 2); // get the year as an integer from the expiry date input

// Check that month is between 1-12
if ($month < 1 || $month > 12) {
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Invalid month in expiry date " . $errorIcon; // alert failed message to user
    header("Location: ../frontend/payment.php"); // Redirect back to the payment page to let them try again
    exit();
}

// Get current date as integers
$currentYear = (int)date('y'); // Get current year
$currentMonth = (int)date('m'); // Get current month

// Check that date is not in the past
if ($year < $currentYear || 
    ($year == $currentYear && $month < $currentMonth)) {
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Card has expired " . $errorIcon; // alert failed message to user
    header("Location: ../frontend/payment.php"); // Redirect back to the payment page to let them try again
    exit();
}

// validate the CVV field to ensure only numbers are accepted
$trimmedCVV = trim($cvv); // trim the CVV to remove any spaces
if (!preg_match('/^[0-9]{3}$/', $trimmedCVV)) {
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "CVV must be 3 digits (123)" . $errorIcon; // alert failed message to user
    header("Location: ../frontend/payment.php"); // Redirect back to the payment page to let them try again
    exit();

}

// once all of this validation passes and there are no errors, move on to payment processing and order confirmation

function generateOrderNumber() { // generate a random order number for each order
    return mt_rand(100000000, 999999999); // generate a random 9 digit number between 100000000 and 999999999
}

$orderNumber = generateOrderNumber();


} // remember and wrap everything in this bracket ////////////////////////////////////////////////////////

