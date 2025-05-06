<?php
session_start();

// set success icon in variable
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';


unset($_SESSION['logged_in']); // this preserves the user's basket session, instead of using a session destroy which deletes all session data

$_SESSION['Success'] = true; // set success session flag to true
$_SESSION['SuccessMessage'] = "Signed out successfully" . $successIcon; // display success message to user

header("Location: ../frontend/index.php"); // redirect to index page on sign/log out
exit();
?>