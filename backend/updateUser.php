<?php
session_start(); // start session
include('../backend/conn/conn.php'); // connection to database file

// set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

if(isset($_POST['updateButton'])) { // if update form is submitted
    // assign the form fields to their variables
    $userID = $_POST['userid'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    
    // Create the update query
    $updateQuery = "UPDATE ciaousers SET name = ?, surname = ?, email = ? WHERE userid = ?";
    
    // Prepare statement
    $stmt = mysqli_prepare($conn, $updateQuery);
    
    if($stmt) {
        // Bind parameters 
        mysqli_stmt_bind_param($stmt, "sssi", $name, $surname, $email, $userID);
        
        // Execute the statement
        $result = mysqli_stmt_execute($stmt);
        
        if ($result) {
            $_SESSION['Success'] = true; // set success session variable to true for displaying success message
            $_SESSION['SuccessMessage'] = "User Updated " . $successIcon;  // display success message to user
            header("Location: ../admin/userdetails.php"); // redirect to the user account page
            exit();
        } else {
            $_SESSION['Failed'] = true; // set failed session variable to true for displaying failure message
            $_SESSION['FailMessage'] = "Update Failed " . $errorIcon;  // display error message to user
            header("Location: ../admin/userdetails.php"); // redirect to the user account page
            exit();
        }
    } else {
        $_SESSION['Failed'] = true; // set failed session variable to true for displaying failure message
        $_SESSION['FailMessage'] = "Error, please try again " . $errorIcon;  // display error message to user
        header("Location: ../admin/userdetails.php"); // redirect to the user account page
        exit();
    }
}

// If we reach here, redirect back to the user details page
header("Location: userdetails.php");
exit();
?>