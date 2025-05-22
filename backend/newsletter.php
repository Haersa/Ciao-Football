<?php
session_start();
include('../backend/conn/conn.php');

$first_name = $_POST['first_name'];
$email = $_POST['email'];

$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Validate inputs
if (empty($first_name) || empty($email)) {
    $_SESSION['Failed'] = true;
    $_SESSION['FailMessage'] = "All fields are required" . $errorIcon;
    header("Location: ../frontend/index.php");
    exit();
}

// Check if email already exists
$checkEmail = "SELECT * FROM newsletter_list WHERE email = ?";
$stmt = mysqli_prepare($conn, $checkEmail);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) { // if the email is already subscribed
    $_SESSION['Failed'] = true; // set session failed flag to true
    $_SESSION['FailMessage'] = "Email already subscribed" . $errorIcon; // display error message to user
    mysqli_stmt_close($stmt);
    header("Location: ../frontend/index.php"); // redirect to home page to let user try aaain
    exit();
}

mysqli_stmt_close($stmt);

// if the email check comes back empty

// Insert new newsletter recipient
$insertQuery = "INSERT INTO newsletter_list(first_name, email) VALUES (?,?)";
$stmt = mysqli_prepare($conn, $insertQuery);
mysqli_stmt_bind_param($stmt, "ss", $first_name, $email);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['Success'] = true; // set success session flag to true
    $_SESSION['SuccessMessage'] = "Successfully subscribed!" . $successIcon; // display success message to user
} else {
    $_SESSION['Failed'] = true; // if an error occurs, set session failed flag to rtue
    $_SESSION['FailMessage'] = "Subscription failed. Please try again." . $errorIcon; // alert error message to user
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
header("Location: ../frontend/index.php"); // redirect to home page to refresh
exit();
?>