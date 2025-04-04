<?php 
session_start();
include('../backend/conn/conn.php'); // connection to database file

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // these make sure the login feedback message on login is only displayed once, and isn't shown again if a user clicks the browser back arrow (found on stack overflow)
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// restrict access to admin page if user is not logged in or not an admin
//COMMENTED OUT JUST NOW UNTIL I CREATE A PROPER ADD ADMIN ACCOUNT FORM ------------------------------------------------------------------
// if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in'] || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
//     // User is not logged in as admin, redirect to login
//     $_SESSION['Failed'] = true;
//     $_SESSION['FailMessage'] = "Restricted Access" . $errorIcon;
//     header("Location: ../frontend/login.php");
//     exit();
// }
// Display success message if exists
if (isset($_SESSION['Success']) && $_SESSION['Success']) {
    echo '<div class="success-message">' . $_SESSION['SuccessMessage'] . '</div>';
    unset($_SESSION['Success']);
    unset($_SESSION['SuccessMessage']);
}

// Display failure message if exists
if (isset($_SESSION['Failed']) && $_SESSION['Failed']) {
    echo '<div class="error-message">' . $_SESSION['FailMessage'] . '</div>';
    unset($_SESSION['Failed']);
    unset($_SESSION['FailMessage']);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" /> <!-- Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta charset="UTF-8" /> <!-- Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?php echo isset($pageDescription) ? $pageDescription : ''; ?>" />
    <meta name="author" content="Ciao Football" />
    <meta name="keywords" content="<?php echo isset($pageKeywords) ? $pageKeywords : ''; ?>"/>
    <title><?php echo isset($pageTitle) ? $pageTitle.' - ' : ''; ?>Ciao Football</title> <!--Page title-->
    <!-- Light mode favicon-->
    <link rel = "icon" type = "svg+xml" href = "../images/favicondark.svg" media = "(prefers-color-scheme: light)">
     <!-- Dark mode favicon-->
    <link rel = "icon" type = "svg+xml" href = "../images/favicon.svg" media = "(prefers-color-scheme: dark)">
  
    <link rel="stylesheet" href="../css/adminstyle.css" /> <!-- CSS file-->
  </head>
  <body>
