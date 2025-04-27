<?php
session_start(); // start session
include('../backend/conn/conn.php'); // connection to database file

$first_name = $_POST['first_name']; // gather first name from form input
$email = $_POST['email']; // gather email from form inpit

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Validate inputs
if (empty($first_Name) || empty($email)) { // if any form fields are empty
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "All fields are required" . $errorIcon; // display error message to user
    if(isset($_SERVER['HTTP_REFERER'])) {
        header("Location: ../frontend/index.php");
        // header("Location: $_SERVER ['$HTTP_REFERER']"); // refresh the page
        exit();
     } else{
        header("Location: ../frontend/index.php");
        exit();
     }
}

// Check if email already exists
$checkEmail = "SELECT * FROM newsletter_list WHERE email = ?";
$stmt = mysqli_prepare($conn, $checkEmail);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Email already subscribed" . $errorIcon; // alert error message to user
    if(isset($_SERVER['HTTP_REFERER'])) {
        header("Location: ../frontend/index.php");
        // header("Location: $_SERVER ['$HTTP_REFERER']"); // refresh the page
        exit();
     } else{
        header("Location: ../frontend/index.php");
        exit();
     }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
}
 // Insert new newsletter recipient

$insertQuery = "INSERT INTO newsletter_list(first_name, email) VALUES (?,?)"; // Sql query to insert new email
$stmt = mysqli_prepare($conn, $insertQuery);
mysqli_stmt_bind_param($stmt, "ss", $first_Name, $email);

?>