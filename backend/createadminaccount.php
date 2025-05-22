<?php
session_start(); // start session
include('../backend/conn/conn.php'); // connection to database file

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Collect form data (trim for any white space)
$username = trim($_POST['username']);
$password = trim($_POST['password']);


// validate input fields
if (empty($username) || empty($password)){ // ifd either of the form fields are empty
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "All fields are required" . $errorIcon; // display error message to user
    header("Location: ../admin/createadminaccount.php"); // redirect to admin account creation page to let them try again
    exit();
}


// check if username is of specified minimum and maximum length
if(strlen($username) < 10 || strlen($username) > 50) {
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Username must be more than 10 but less than 50 characters" . $errorIcon; // display error message to user
    header("Location: ../admin/createadminaccount.php"); // redirect to admin account creation page to let them try again
    exit();

}

// check if password is of specified minimum and maximum length
if(strlen($password) < 10 || strlen($password) > 50) {
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = " Password must be more than 10 but less than 50 characters" . $errorIcon; // display error message to user
    header("Location: ../admin/createadminaccount.php"); // redirect to admin account creation page to let them try again
    exit();

}

// if that validation passes, check if admin account already exists

// Check if email (username) already exists
$checkAdmin = "SELECT * FROM ciaousers WHERE email = ? AND Admin = 1";
$stmt = mysqli_prepare($conn, $checkAdmin);
mysqli_stmt_bind_param($stmt, "s", $username); // Make sure $username variable exists and contains the email being registered
mysqli_stmt_execute($stmt);
$adminResult = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($adminResult) > 0) {
    // An admin account with this email already exists
    $_SESSION['Failed'] = true; // set session failed flag to true
    $_SESSION['FailMessage'] = "Admin account with this email already exists" . $errorIcon; // display error message to user
    header("Location: ../admin/createadminaccount.php"); // redirect to admin account creation page to let them try again
    mysqli_stmt_close($stmt);
    exit();
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT); // hash the password for security in the db table

// insert the new admin account if all validation passes

$insertAdmin = "INSERT INTO ciaousers (email, password, Admin) VALUES (?, ?, 1)"; // sql query to add new admin account to database
$stmt = mysqli_prepare($conn, $insertAdmin);
mysqli_stmt_bind_param($stmt, "ss", $username, $hashedPassword);

if(mysqli_stmt_execute($stmt)){
    $_SESSION['Success'] = true; // set success session flag to true
    $_SESSION['SuccessMessage'] = "Admin Account Created Successfully" . $successIcon;  // display success message to user
    header("Location: ../admin/createadminaccount.php"); // refresh the page to clear form and show success message
} else{
    $_SESSION['Failed'] = true; // set failed session variable to true for displaying error message
    $_SESSION['FailMessage'] = "Registration Failed: " . mysqli_error($conn) . $errorIcon; // display error message to user
    header("Location: ../frontend/register.php"); // redirect to register page to let them try again
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
exit();
?>