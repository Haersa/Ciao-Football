<?php
session_start(); // start session
include('../backend/conn/conn.php'); // connection to database file

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

if(isset($_POST['productID']) && isset($_POST['deleteButton'])) { // if the delete button is clicked and the product id is set (from the modal)
    $productID = $_POST['productID'];
    
    // Check what type of product is to be deleted (shirt or equipment)
    if(isset($_POST['productType'])) {
        $productType = $_POST['productType'];
        
        if($productType === 'shirt') { // if the product type is a shirt
            // get the image path before deleting the shirt
            $imageQuery = "SELECT image FROM shirts WHERE shirt_id = ?";
            $stmt = mysqli_prepare($conn, $imageQuery);
            
            if($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $productID);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if($shirtRow = mysqli_fetch_assoc($result)) {
                    $imagePath = $shirtRow['image'];
                    
                    // delete the shirt from database
                    $deleteQuery = "DELETE FROM shirts WHERE shirt_id = ?";
                    $stmt = mysqli_prepare($conn, $deleteQuery);
                    
                    if($stmt) {
                        mysqli_stmt_bind_param($stmt, "i", $productID);
                        $deleteResult = mysqli_stmt_execute($stmt);
                        
                        if($deleteResult) {
                            // Delete the image file
                            if(!empty($imagePath) && file_exists($imagePath)) {
                                unlink($imagePath);
                            }
                            
                            $_SESSION['Success'] = true; // set success flag to true
                            $_SESSION['SuccessMessage'] = "Shirt product deleted successfully " . $successIcon; // display success message to user
                            header('Location: ' . $_SERVER['HTTP_REFERER']); // refresh (redirect to same paghe) to let the user continue deleting more, if needed
                            exit();
                        } else {
                            $_SESSION['Failed'] = true; // set failed flag to false
                            $_SESSION['FailMessage'] = "Failed to delete shirt product " . $errorIcon; // display error message to user
                            header('Location: ' . $_SERVER['HTTP_REFERER']); // refresh (redirect to same paghe) to let the user try again
                            exit();
                        }
                    }
                }
            }
            
        } elseif($productType === 'equipment') { // if the product type is equipment
            //get the image path before deleting the record
            $imageQuery = "SELECT image FROM equipment WHERE equipment_id = ?";
            $stmt = mysqli_prepare($conn, $imageQuery);
            
            if($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $productID);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if($equipmentRow = mysqli_fetch_assoc($result)) {
                    $imagePath = $equipmentRow['image'];
                    
                    // Now delete the record from database
                    $deleteQuery = "DELETE FROM equipment WHERE equipment_id = ?";
                    $stmt = mysqli_prepare($conn, $deleteQuery);
                    
                    if($stmt) {
                        mysqli_stmt_bind_param($stmt, "i", $productID);
                        $deleteResult = mysqli_stmt_execute($stmt);
                        
                        if($deleteResult) {
                            // Delete the image file
                            if(!empty($imagePath) && file_exists($imagePath)) {
                                unlink($imagePath);
                            }
                            
                            $_SESSION['Success'] = true; // set success flag to true
                            $_SESSION['SuccessMessage'] = "Equipment product deleted " . $successIcon; // display success message to user
                            header('Location: ' . $_SERVER['HTTP_REFERER']); // refresh (redirect to same paghe) to let the user continue deleting more, if needed
                            exit();
                        } else {
                            $_SESSION['Failed'] = true; // set failed flag to false
                            $_SESSION['FailMessage'] = "Failed to delete equipment product " . $errorIcon; // display success message to user
                            header('Location: ' . $_SERVER['HTTP_REFERER']); // refresh (redirect to same paghe) to let the user try again
                            exit();
                        }
                    }
                }
            }
        }
    } else {
        // If this else statement is triggered, something went wrong
        $_SESSION['Failed'] = true; // set failed flag to false
        $_SESSION['FailMessage'] = "Error handling deletion, try again " . $errorIcon; // display error message to user
        header('Location: ' . $_SERVER['HTTP_REFERER']);  // refresh (redirect to same paghe) to let the user try again
        exit();
    }
}

// If no product ID was set, redirect back to home page (dashboard)
header('Location: ' . $_SERVER['HTTP_REFERER']); // refresh (redirect to same paghe) to let the user try again
exit();
?>