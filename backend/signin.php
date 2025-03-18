<?php
session_start(); // start session
include('../backend/conn/conn.php'); // connection to database file

$email = $_POST['email']; // gather email input instead of username
$password = $_POST['password']; // gather password input

// set lucide icons in variables as they were interfering with session messages
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// First check if email exists with a separate query
$emailquery = "SELECT * FROM CiaoUsers WHERE email = ?";
$stmt = mysqli_prepare($conn, $emailquery);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$emailresult = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($emailresult) === 0) {
    // Email doesn't exist
    $_SESSION['Failed'] = true;
    $_SESSION['FailMessage'] = "Email not recognized" . $errorIcon;
    header("Location: ../frontend/login.php");
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
}

//email exists, now check password
$loginquery = "SELECT * FROM CiaoUsers WHERE email = ? AND password = ?";
$stmt = mysqli_prepare($conn, $loginquery);
mysqli_stmt_bind_param($stmt, "ss", $email, $password);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 1) {
    // Login successful
    $row = mysqli_fetch_array($result);
    
    // Set session variables
    $_SESSION['userid'] = $row['userid']; // Updated to match the column name in your DB
    $_SESSION['logged_in'] = true;
    $_SESSION['Success'] = true;
    $_SESSION['SuccessMessage'] = "Sign in successful" . $successIcon;
    
    // Redirect based on admin status
    if ($row['Admin'] == 1) {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../frontend/index.php");
    }
} else {
    // Password is incorrect
    $_SESSION['Failed'] = true;
    $_SESSION['FailMessage'] = "Incorrect password" . $errorIcon;
    header("Location: ../frontend/login.php");
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
exit();
?>