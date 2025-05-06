<?php
session_start(); // start session
include('../backend/conn/conn.php'); // connection to database file

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Collect form data (trim for any white space)
$firstName = trim($_POST['firstName']);
$surname = trim($_POST['surname']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirmPassword = $_POST['confirmPassword'];
$termsChecked = isset($_POST['terms']) ? true : false;

// Validate inputs
if (empty($firstName) || empty($surname) || empty($email) || empty($password) || empty($confirmPassword)) { // if any form fields are empty
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "All fields are required" . $errorIcon; // display error message to user
    header("Location: ../frontend/register.php"); // redirect to register page to let them try again
    exit();
}

// Check if passwords match
if ($password !== $confirmPassword) { // if passwords dont match
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Passwords do not match" . $errorIcon; // display error message to user
    header("Location: ../frontend/register.php"); // redirect to register page to let them try again
    exit();
}


// Validate terms & conditions checkbox
if (!$termsChecked) {
    $_SESSION['Failed'] = true; // if the user hasnt agreed to t&c's, set failed session variable to true
    $_SESSION['FailMessage'] = "You must agree to the Terms & Conditions" . $errorIcon; // display error message to user
    header("Location: ../frontend/register.php"); // redirect to register page to let them try again
    exit();
}

// Check if email already exists
$checkEmail = "SELECT * FROM ciaousers WHERE email = ?";
$stmt = mysqli_prepare($conn, $checkEmail);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Email already in use" . $errorIcon; // alert error message to user
    header("Location: ../frontend/register.php"); // redirect to register page to let them try again
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert new user 
$insertQuery = "INSERT INTO ciaousers (name, surname, email, password, Admin, last_login) VALUES (?, ?, ?, ?, 0, CURRENT_TIMESTAMP)"; // sql query to add new user to database
$stmt = mysqli_prepare($conn, $insertQuery);
mysqli_stmt_bind_param($stmt, "ssss", $firstName, $surname, $email, $hashedPassword);

if (mysqli_stmt_execute($stmt)) {
    // Get the new user's ID
    $userId = mysqli_insert_id($conn);
    
    // Set session variables (auto login)
    $_SESSION['userid'] = $userId; // set session variable tied to user id
    $_SESSION['logged_in'] = true; // set logged in session variable to true, for auto login
    $_SESSION['Success'] = true; // set success session variable to true for displaying success message
    $_SESSION['SuccessMessage'] = "Account Created Successfully" . $successIcon;  // display success message to user
    
    // Redirect to homepage
    header("Location: ../frontend/index.php");
} else {
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Registration Failed: " . $errorIcon; // display error message to user
    header("Location: ../frontend/register.php"); // redirect to register page to let them try again
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
exit();
?>