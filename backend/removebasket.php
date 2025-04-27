<?php
session_start();


// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Check if product key is provided and exists in the basket
if (isset($_GET['remove']) && isset($_SESSION['basket'][$_GET['remove']])) {
    // Remove the item from the basket
    unset($_SESSION['basket'][$_GET['remove']]);
    
    // Set success message
    $_SESSION['Success'] = true; // set session variable to true
    $_SESSION['SuccessMessage'] = "Product removed from basket" . $successIcon; // display success message to user
} else {
    // Set error message if product key is invalid
    $_SESSION['Error'] = true; // set session variable to true
    $_SESSION['ErrorMessage'] = "Invalid product key " . $errorIcon; // display error message to user
}

// Redirect back to the basket page
header("Location: ../frontend/basket.php");
exit();
?>