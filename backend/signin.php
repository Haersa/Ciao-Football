<?php
session_start(); // start session
include('../backend/conn/conn.php'); // connection to database file

$email = trim($_POST['email']); // trim whitespace from email
$password = trim($_POST['password']); // trim whitespace from password

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Check if email exists and get the stored password
$emailquery = "SELECT * FROM ciaousers WHERE email = ?";
$stmt = mysqli_prepare($conn, $emailquery);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) === 0) {
    // Email doesn't exist
    $_SESSION['Failed'] = true; // set session variable to true
    $_SESSION['FailMessage'] = "Email not recognized" . $errorIcon; // display error message
    header("Location: ../frontend/login.php"); // redirect to login page to let user try again
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    exit();
}

// Email exists, get the user data
$row = mysqli_fetch_assoc($result);
$stored_password = $row['password'];

if (password_verify($password, $stored_password)) {
    // Login successful
    $_SESSION['userid'] = $row['userid']; // set session based on user id
    $_SESSION['logged_in'] = true; // set session variable to true
    $_SESSION['is_admin'] = ($row['Admin'] == 1) ? true : false; // check if user is admin, if so store admin status
    $_SESSION['Success'] = true; // set session variable to true
    $_SESSION['SuccessMessage'] = "Sign in Successful" . $successIcon; // success message


        // Update last login column for non-admin users in the db table
        if ($row['Admin'] == 0) { // don't track admin users
            $updateQuery = "UPDATE ciaousers SET last_login = CURRENT_TIMESTAMP WHERE userid = ?";
            $updateStmt = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($updateStmt, "i", $row['userid']);
            mysqli_stmt_execute($updateStmt);
            mysqli_stmt_close($updateStmt);
        }


    
    // Redirect based on admin status
    if ($row['Admin'] == 1) {
        header("Location: ../admin/dashboard.php"); // if user is an admin, redirect to admin dashboard
    } else {
        header("Location: ../frontend/index.php"); // if they aren't, redirect to home page
    }
} else {
    // Password is incorrect
    $_SESSION['Failed'] = true; // set session failed flag to true
    $_SESSION['FailMessage'] = "Incorrect Password" . $errorIcon; // display error message to user
    header("Location: ../frontend/login.php");
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
exit();
?>