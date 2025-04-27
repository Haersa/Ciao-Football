<?php
session_start(); // start session
include('../backend/conn/conn.php'); // connection to database file

$name = trim($_POST['name']); // gather and trim name
$surname = trim($_POST['surname']); // gather and trim surname
$rating = (float)$_POST['rating']; // gather the review number, set to float so it captures the decimal
$review = trim($_POST['review']); // gather and trim review message
$review_date = date('Y-m-d H:i:s'); // current date and time

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Validate inputs
    if (empty($name) || empty($surname) || empty($rating) || empty($review)) { // if any form fields are empty
        $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
        $_SESSION['FailMessage'] = "All fields are required" . $errorIcon; // display error message to user
        header("Location: ../frontend/reviewciao.php"); // redirect to review page to let them try again
        exit();
    }

    if($rating > 5.0){
        $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
        $_SESSION['FailMessage'] = "Rate between 1 & 5" . $errorIcon; // display error message to user
        header("Location: ../frontend/reviewciao.php"); // redirect to review page to let them try again
        exit();
    }

    if(strlen($review) > 200){ // use php string length check, if it exceeds 200 characters it will trigger this block of code
        $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
        $_SESSION['FailMessage'] = "Review must be 200 characters or less" . $errorIcon; // display error message to user
        header("Location: ../frontend/reviewciao.php"); // redirect to review page to let them try again
        exit();
    }

    // If all validations pass, prepare SQL statement
    $sql = "INSERT INTO ciaoreviews (name, surname, rating, review, review_date) VALUES (?, ?, ?, ?, ?)";
    
    // prepare statement
    $stmt = mysqli_prepare($conn, $sql);
    
    if($stmt) {
        // Bind parameters 
        mysqli_stmt_bind_param($stmt, "ssdss", $name, $surname, $rating, $review, $review_date); // bind parameters, bind the rating to a decimal(float) so it doesn't cut off the decimal integer 'i' was doing
        
        // Execute the statement
        if(mysqli_stmt_execute($stmt)) {
            // Success
            $_SESSION['Success'] = true; // set success session variable to true for displaying success message
            $_SESSION['SuccessMessage'] = "Thank you for your review! " . $successIcon; // display success message to user
            header("Location: ../frontend/index.php"); // redirect to index page
        } else {
            // Error in execution
            $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
            $_SESSION['FailMessage'] = "Error leaving review" . $errorIcon; // display error message to user
            header("Location: ../frontend/reviewciao.php"); // redirect to review page to let them try again
        }
        // Close the statement
        mysqli_stmt_close($stmt);
    } 
}

// Close connection
mysqli_close($conn);
exit();
?>