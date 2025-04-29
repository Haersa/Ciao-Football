<?php
session_start(); // Start or resume the session
include('../backend/conn/conn.php'); // connection to database file

// Set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    $required_fields = [
        'billing_name', 'billing_surname', 'billing_email', 'billing_phone', 
        'billing_addressLine1', 'billing_addressLine2', 'billing_city', 
        'billing_postcode', 'billing_countries'
    ];
    
    $missing_fields = []; // initialise empty array to store required fields in
    
    foreach ($required_fields as $field) { // loop through each required field and store as $field
        if (empty($_POST[$field])) {
            $missing_fields[] = $field; // if field is empty, add to array
        }
    }
    
    if (!empty($missing_fields)) { // if missing fields array is not empty
        // Some required fields are missing
        $_SESSION['Failed'] = true; // set failed session flag to true
        $_SESSION['FailMessage'] = "Please fill in all required billing fields " . $errorIcon; // alert failed message to user
        
        // Redirect back to the billing page to let them try again
        header("Location: ../frontend/billing.php");
        exit();
    }
    
    // All required fields are present, store in session for ALL users
    $_SESSION['billing'] = [ // store billing details inside an array within the billing session
        'name' => $_POST['billing_name'],
        'surname' => $_POST['billing_surname'],
        'email' => $_POST['billing_email'],
        'phone' => $_POST['billing_phone'],
        'addressLine1' => $_POST['billing_addressLine1'],
        'addressLine2' => $_POST['billing_addressLine2'],
        'addressLine3' => isset($_POST['billing_addressLine3']) ? $_POST['billing_addressLine3'] : '',
        'addressLine4' => isset($_POST['billing_addressLine4']) ? $_POST['billing_addressLine4'] : '',
        'city' => $_POST['billing_city'],
        'postcode' => $_POST['billing_postcode'],
        'country' => $_POST['billing_countries']
    ];
    
    // Only save to database if user is logged in and checked the save box
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] && isset($_POST['save-billing-address'])) {
        // Make sure userid exists in the session
        if (isset($_SESSION['userid'])) {
            $user_id = (int)$_SESSION['userid']; 
            
            // Check if this is their first billing address
            $check = $conn->query("SELECT COUNT(*) as count FROM billing_addresses WHERE user_id = $user_id");
            
            if (!$check) {
                // If query fails, default to making it a non-default address
                $is_default = 0;
            } else {
                $row = $check->fetch_assoc();
                // If they have no addresses yet, make this the default
                $is_default = ($row['count'] == 0) ? 1 : 0;
            }
            
            // Prepare empty values for fields aren't required to be filled
            $addressLine3 = isset($_POST['billing_addressLine3']) ? $_POST['billing_addressLine3'] : NULL;
            $addressLine4 = isset($_POST['billing_addressLine4']) ? $_POST['billing_addressLine4'] : NULL;
            
            // Save the address to billing_addresses db table
            $stmt = $conn->prepare("INSERT INTO billing_addresses (
                user_id, name, surname, email, phone, 
                addressLine1, addressLine2, addressLine3, addressLine4, 
                city, postcode, country, is_default
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            
            if ($stmt) {
                $stmt->bind_param(
                    "isssssssssssi", 
                    $user_id, 
                    $_POST['billing_name'], 
                    $_POST['billing_surname'], 
                    $_POST['billing_email'], 
                    $_POST['billing_phone'], 
                    $_POST['billing_addressLine1'], 
                    $_POST['billing_addressLine2'], 
                    $addressLine3, 
                    $addressLine4, 
                    $_POST['billing_city'], 
                    $_POST['billing_postcode'], 
                    $_POST['billing_countries'], 
                    $is_default
                );
                
                $stmt->execute();
                $stmt->close();
            }
        }
    }
    
    // Check if the user wants to use the same address for shipping
    if (isset($_POST['same-shipping-address'])) {
        // Store a flag in session to pre-fill shipping form with billing details
        $_SESSION['use_billing_for_shipping'] = true; // set pre-fill flag to true
    } else {
        // Clear the flag if it exists
        if(isset($_SESSION['use_billing_for_shipping'])) {
            unset($_SESSION['use_billing_for_shipping']);
        }
    }
    
    // Set success message
    $_SESSION['Success'] = true;
    $_SESSION['SuccessMessage'] = "Billing Address Saved " . $successIcon;
    
    // Redirect to shipping page to enter/confirm shipping details
    header("Location: ../frontend/shippingdetails.php");
    exit();
} else {
    // If someone tries to access this page directly without POST data
    $_SESSION['Failed'] = true;
    $_SESSION['FailMessage'] = "Invalid request " . $errorIcon;
    header("Location: ../frontend/billing.php");
    exit();
}
?>