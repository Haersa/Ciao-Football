<?php
session_start(); // start session
include('../backend/conn/conn.php'); // connection to database file

// Initialize basket session if it doesn't exist
if (!isset($_SESSION['basket'])) {
    $_SESSION['basket'] = array(); // set it as an array to handle multiple items (if needed)
}

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check which type of product was submitted
    if (isset($_POST['shirt_id'])) {
        // Handle shirt product
        $shirt_id = $_POST['shirt_id'];
        
        // Check if the product exists in the database
        $checkProduct = "SELECT * FROM shirts WHERE shirt_id = ?";
        $stmt = mysqli_prepare($conn, $checkProduct);
        mysqli_stmt_bind_param($stmt, "i", $shirt_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) == 0) { // if product doesn't exist in database
            $_SESSION['Failed'] = true; // set failed session flag to true
            $_SESSION['FailMessage'] = "Product not found" . $errorIcon; // alert error message to user
            header("Location: " . $_SERVER['HTTP_REFERER']); // refresh the page the user is on to show error message
            mysqli_stmt_close($stmt);
            exit();
        }
        
        $product = mysqli_fetch_assoc($result);
        $basket_key = $shirt_id; // No prefix needed for shirts
        
        // Add product to basket session
        if (isset($_SESSION['basket'][$basket_key])) { // if the user adds an existing product in their basket again, update the quantity
            $_SESSION['basket'][$basket_key]['quantity']++; // plus 1 to quantity
            $_SESSION['Success'] = true; // set success session flag to true
            $_SESSION['SuccessMessage'] = "Product quantity updated" . $successIcon; // alert success message to user
        } else {
            // If product doesn't exist in basket, add it
            $_SESSION['basket'][$basket_key] = array( // store all product info in an array
                'shirt_id' => $shirt_id,
                'team' => $product['team'],
                'year' => $product['year'],
                'type' => $product['type'],
                'size' => $product['size'],
                'price' => $product['price'],
                'image' => $product['image'], 
                'quantity' => 1,
                'product_type' => 'shirt' // Add product type identifier to differentiate between shirt and equipment products
            );
            $_SESSION['Success'] = true; // set success session flag to true
            $_SESSION['SuccessMessage'] = "Product added to your basket" . $successIcon; // alert success message to user
        }
        
        mysqli_stmt_close($stmt);
    } 
    elseif (isset($_POST['equipment_id'])) {
        // Handle equipment product
        $equipment_id = $_POST['equipment_id'];
        
        // Check if the product exists in the database
        $checkProduct = "SELECT * FROM equipment WHERE equipment_id = ?";
        $stmt = mysqli_prepare($conn, $checkProduct);
        mysqli_stmt_bind_param($stmt, "i", $equipment_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($result) == 0) { // if product doesn't exist in database
            $_SESSION['Failed'] = true; // set failed session flag to true
            $_SESSION['FailMessage'] = "Product not found" . $errorIcon; // alert error message to user
            header("Location: " . $_SERVER['HTTP_REFERER']); // refresh the page the user is on to show error message
            mysqli_stmt_close($stmt);
            exit();
        }
        
        $product = mysqli_fetch_assoc($result);
        
        // add an 'e' prefix for equipment items to avoid conflict with shirt id's
        $basket_key = 'e' . $equipment_id; // prefix added
        
        // Add product to basket session
        if (isset($_SESSION['basket'][$basket_key])) { // if the user adds an existing product in their basket again, update the quantity
            $_SESSION['basket'][$basket_key]['quantity']++; // plus 1 to quantity
            $_SESSION['Success'] = true; // set success session flag to true
            $_SESSION['SuccessMessage'] = "Product quantity updated" . $successIcon; // alert success message to user
        } else {
            // If product doesn't exist in basket, add it
            $_SESSION['basket'][$basket_key] = array( // store all product info in an array
                'equipment_id' => $equipment_id,
                'name' => $product['name'],
                'brand' => $product['brand'],
                'category' => $product['category'],
                'price' => $product['price'],
                'image' => $product['image'],
                'quantity' => 1,
                'product_type' => 'equipment' // Add product type identifier to differentiate between shirt and equipment products
            );
            $_SESSION['Success'] = true; // set success session flag to true
            $_SESSION['SuccessMessage'] = "Product added to your basket" . $successIcon; // alert success message to user
        }
        
        mysqli_stmt_close($stmt);
    } 
    else {
        $_SESSION['Failed'] = true; // set failed session flag to true
        $_SESSION['FailMessage'] = "No product selected" . $errorIcon; // alert error message to user
    }
    
    // Redirect back to the referring page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    // If someone tries to access this page directly without POST data, just a security measure
    $_SESSION['Failed'] = true;
    $_SESSION['FailMessage'] = "Invalid request" . $errorIcon;
    header("Location: " . "../frontend/index.php");
    exit();
}

mysqli_close($conn);
?>