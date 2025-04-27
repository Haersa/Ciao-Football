<?php
session_start();
// Connect to database
include('../backend/conn/conn.php');

// Set Lucide icons in variables for messages
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Check if the required POST parameters are provided
if (isset($_POST['productKey']) && isset($_POST['quantity']) && isset($_SESSION['basket'][$_POST['productKey']])) {
    
    $productKey = $_POST['productKey'];
    $requestedQuantity = (int)$_POST['quantity']; // store the quantity as an integer
    $currentItem = $_SESSION['basket'][$productKey];
    
    // Determine if this is a shirt or equipment item based on key or product type
    $isEquipment = isset($currentItem['product_type']) ? 
        $currentItem['product_type'] === 'equipment' : 
        (strpos($productKey, 'e') === 0);
    
    // Check database for available quantity
    if ($isEquipment) {
        // For equipment items, remove the 'e' prefix
        $equipmentId = substr($productKey, 1);
        $query = "SELECT quantity FROM equipment WHERE equipment_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $equipmentId);
    } else {
        // For shirt items
        $query = "SELECT quantity FROM shirts WHERE shirt_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $productKey);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($row = mysqli_fetch_assoc($result)) {
        $availableQuantity = $row['quantity'];
        
        // Validate quantity (make sure user cant add more than available stock to their basket by checking quantity in database)
        if ($requestedQuantity <= 0) {
            $_SESSION['Failed'] = true; // set failed session flag to true
            $_SESSION['FailMessage'] = "Invalid quantity. Please enter a number greater than zero " . $errorIcon; // alert error message to user
        } 
        elseif ($requestedQuantity > $availableQuantity) {
            $_SESSION['Failed'] = true; // set failed session flag to true
            $_SESSION['FailMessage'] = "Sorry, only {$availableQuantity} item(s) available in stock " . $errorIcon; // alert error message to user
        }
        else {
            // Update the quantity in the basket
            $_SESSION['basket'][$productKey]['quantity'] = $requestedQuantity; // if both of those errors weren't triggered, update the quantity
            
            // Set success message
            $_SESSION['Success'] = true; // set success session flag to true
            $_SESSION['SuccessMessage'] = "Basket quantity updated " . $successIcon; // alert success message to user
        }
    } else {
        // Product not found in database
        $_SESSION['Failed'] = true; // set failed session flag to true
        $_SESSION['FailedMessage'] = "Product not found in database " . $errorIcon; // alert error message to user
    }
    
    mysqli_stmt_close($stmt);
} else {
    // Set error message if required parameters are missing or invalid
    $_SESSION['Failed'] = true;
    $_SESSION['FailedMessage'] = "Unable to update basket. Invalid product information " . $errorIcon;
}

// Redirect back to the basket page
header("Location: ../frontend/basket.php");
exit();

mysqli_close($conn);
?>