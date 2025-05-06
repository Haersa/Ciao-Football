<?php
session_start();

// set success icon in variable
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Clear admin session
unset($_SESSION['is_admin']); // unset admin session
unset($_SESSION['logged_in']); // unset general login status
unset($_SESSION['userid']); // unset the user ID


$_SESSION['Success'] = true; // set success session flag to true
$_SESSION['SuccessMessage'] = "Signed out successfully" . $successIcon; // display success message to user

// Redirect to index page
header("Location: ../frontend/index.php");
exit();
?>