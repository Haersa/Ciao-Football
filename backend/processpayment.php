<?php
session_start(); // Start or resume the session
include('../backend/conn/conn.php'); // connection to database file

// Set lucide icons in variables
$errorIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#8b0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>';
$successIcon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0a5c36" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg>';

// Set variables from post data within payment form
$name = $_POST['cardholderName'];
$cardNumber = $_POST['CardNumber'];
$expiryDate = $_POST['expiryDate'];
$cvv = $_POST['CVV'];

$required_fields = ['cardholderName', 'CardNumber', 'expiryDate', 'CVV']; // fields that must be filled
$missing_fields = []; // set empty array to store missing fields in

foreach ($required_fields as $field) { // loop through each required field and store as $field
    if (empty($_POST[$field])) {
        $missing_fields[] = $field; // if field is empty, add to array
    }
}

// Check if form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
// Validate payment detail fields/inputs
if (count($missing_fields) > 0) {
    // Some required fields are missing
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Please fill in all required payment details " . $errorIcon; // alert failed message to user
    
    // Redirect back to the payment page to let them try again
    header("Location: ../frontend/payment.php");
    exit();
}

// Validate Card holder name field to ensure only letters and special characters like spaces or apostrophes are accepted

// trim the name to remove any spaces
$trimmedName = trim($name);

// First check if the length is within allowed range
if (strlen($trimmedName) < 2 || strlen($trimmedName) > 50) {
    // Name is too long or too short
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Name must be between 2 and 50 characters" . $errorIcon; // alert failed message to user
    
    // Redirect back to the payment page to let them try again
    header("Location: ../frontend/payment.php");
    exit();
}

// Next, check if the name contains any numbers or special characters like spaces or apostrophes
if (!preg_match('/^[a-zA-Z \'-]+$/', $trimmedName)) { // use regex to check if name contains only letters, spaces, hyphens, and apostrophes
    // Name contains invalid characters
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Name can only contain letters, spaces, hyphens, and apostrophes " . $errorIcon; // alert failed message to user
    
    // Redirect back to the payment page
    header("Location: ../frontend/payment.php");
    exit();
}


// Validate the card number field to ensire only numbers are accepted
// trim the card number to remove any spaces
$trimmedCardNumber = trim($cardNumber);

$cardnumberNoSpaces = str_replace(' ', '', $trimmedCardNumber); // remove the spaces the user could possibly type in the form field, as usging the is_numeric function on $cardNumber wouldn't work with the spaces

if (!is_numeric($cardnumberNoSpaces)) {
    // Card number contains non-numeric characters
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Enter Numeric characters only" . $errorIcon; // alert failed message to user
    
    // Redirect back to the payment page to let them try again
    header("Location: ../frontend/payment.php");
    exit();
}

// Next, validate card number length to ensure it is 16 digits long (account for 19 as the user can enter spaces o ndesktop)
$cardNumberNoSpaces = str_replace(' ', '', $cardNumber);
if (!preg_match('/^[0-9]{16,19}$/', $cardNumberNoSpaces)) {
    // Card number is not between 16-19 digits
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Card number must be between 16 and 19 digits " . $errorIcon; // 
    header("Location: ../frontend/payment.php"); // Redirect back to the payment page to let them try again
    exit();
}
    
// Validate the expiry date field to ensure only numbers are accepted

// Trim the expiry date to remove any spaces
$trimmedExpiryDate = trim($expiryDate);

// Check that the expiry date contains exactly 4 digits
if (!preg_match('/^[0-9]{4}$/', $trimmedExpiryDate)) {
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Expiry date must be 4 digits (MMYY) " . $errorIcon; // alert failed message to user
    header("Location: ../frontend/payment.php"); // Redirect back to the payment page to let them try again
    exit();
}

// Extract month and year and convert to integers
$month = (int)substr($trimmedExpiryDate, 0, 2); // get the month as an integer from the expiry date input
$year = (int)substr($trimmedExpiryDate, 2, 2); // get the year as an integer from the expiry date input

// Check that month is between 1-12
if ($month < 1 || $month > 12) {
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Invalid month in expiry date " . $errorIcon; // alert failed message to user
    header("Location: ../frontend/payment.php"); // Redirect back to the payment page to let them try again
    exit();
}

// Get current date as integers
$currentYear = (int)date('y'); // Get current year
$currentMonth = (int)date('m'); // Get current month

// Check that date is not in the past
if ($year < $currentYear || 
    ($year == $currentYear && $month < $currentMonth)) {
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "Card has expired " . $errorIcon; // alert failed message to user
    header("Location: ../frontend/payment.php"); // Redirect back to the payment page to let them try again
    exit();
}

// validate the CVV field to ensure only numbers are accepted
$trimmedCVV = trim($cvv); // trim the CVV to remove any spaces
if (!preg_match('/^[0-9]{3}$/', $trimmedCVV)) {
    $_SESSION['Failed'] = true; // set failed session flag to true
    $_SESSION['FailMessage'] = "CVV must be 3 digits (123)" . $errorIcon; // alert failed message to user
    header("Location: ../frontend/payment.php"); // Redirect back to the payment page to let them try again
    exit();

}

// once all of this validation passes and there are no errors, move on to payment processing and order confirmation

function generateOrderNumber() { // generate a random order number for each order
    return mt_rand(100000000, 999999999); // generate a random 9 digit number between 100000000 and 999999999
}

$orderNumber = generateOrderNumber();

// Check if order number already exists (probability is quite low anyways but good to check)
$checkOrderNumber = "SELECT COUNT(*) as count FROM user_orders WHERE order_number = ?";
$stmt = mysqli_prepare($conn, $checkOrderNumber);
mysqli_stmt_bind_param($stmt, "i", $orderNumber);
mysqli_stmt_execute($stmt);
$orderResult = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($orderResult);

// create a while loop, to keep generating order numbers until a unique one is generated

while ($row['count'] > 0) { // if a row contains the same order number
    $orderNumber = generateOrderNumber(); // call the function and update the order number variable with the newly generated order number
    mysqli_stmt_execute($stmt); // execute the statement to compare the generated order number with the existing order numbers in the db table
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
}
mysqli_stmt_close($stmt); 

// Next, determine if the user is logged in or a guest user

$isGuest = 1; // set a default value to the is guest variable (to be used as a flag)
$userID = null; // default to null

if (isset($_SESSION['user_id'])) { // check if the login session is set/active
    $userID = $_SESSION['user_id']; // use the user id of the logged in user
    $isGuest = 0; // update the flags value, to identify they aren't a guest
}

// Calculate the total amount (lifted from existing code in other files)
$totalAmount = 0; // Initialize the total amount
foreach ($_SESSION['basket'] as $basketKey => $item) {
        $itemTotal = $item['price'] * $item['quantity'];
        $totalAmount += $itemTotal;
    }

    // Calculate the current date for the order
    $orderDate = date('d m Y H:i:s');  // store the current date

    // Once we have all of this, submit the order

    mysqli_begin_transaction($conn); // use a transaction to allow for try/catch approach

    try{ // start of try block
        // Insert the new order into user_orders table
        $insertOrder = "INSERT INTO user_orders (order_number, user_id, is_guest, order_date, total_amount) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertOrder);
        mysqli_stmt_bind_param($stmt, "iissd", $orderNumber, $userID, $isGuest, $orderDate, $totalAmount);
                   
                   if(!mysqli_stmt_execute($stmt)){ // if the statement fails
                    throw new Exception ("Failed to create Order"); // throw error message
                   }
                   mysqli_stmt_close($stmt);
    
        // Process each item in the basket
        foreach ($_SESSION['basket'] as $basketKey => $item) { // loop through each item inside the basket
            if ($item['product_type'] === 'shirt'){ // since each shirt is a unique product (unlike equipment products that can have varying quantities) they will need to be deleted from the db table once purchase is completed
                $shirtID = $item['shirt_id']; // append the shirt id in the db table to the variable
    
                //Insert order details for the shirt
                $insertShirtOrder = "INSERT INTO order_details (order_number, product_id, product_type, quantity, price) VALUES (?, ?, 'shirt', ?, ?)";
                $stmt = mysqli_prepare($conn, $insertShirtOrder);
                mysqli_stmt_bind_param($stmt, "iiid", $orderNumber, $shirtID, $item['quantity'], $item['price']);
    
                if(!mysqli_stmt_execute($stmt)){ // if the statement fails
                    throw new Exception ("Failed to insert shirt order details"); // throw error message
                }
    
                mysqli_stmt_close($stmt);
    
                //Next, delete the shirt from the shirts table since it is unique
                $deleteShirt = "DELETE FROM shirts WHERE shirt_id = ?";
                $stmt = mysqli_prepare($conn, $deleteShirt);
                mysqli_stmt_bind_param($stmt, "i", $shirtID);
    
                if(!mysqli_stmt_execute($stmt)){ // if the statement fails
                    throw new Exception("Failed to update shirt availability"); // throw error message
                }
    
                mysqli_stmt_close($stmt);
            }
    
            elseif ($item['product_type'] === 'equipment'){
                //Process equipment item (this one will reduce the quantity of the item)
                $equipmentID = $item['equipment_id'];
                $equipmentQuantity = $item['quantity'];
    
                // Insert the order details for the equipment item
    
                $insertEquipmentOrder = "INSERT INTO order_details (order_number, product_id, product_type, quantity, price)  VALUES (?, ?, 'equipment', ?, ?)";
                $stmt = mysqli_prepare($conn, $insertEquipmentOrder);
                mysqli_stmt_bind_param($stmt, "iiid", $orderNumber, $equipmentID, $equipmentQuantity, $item['price']);
    
                if(!mysqli_stmt_execute($stmt)){ // if the statement fails
                    throw new Exception("Failed to insert equipment order details"); // throw error message
                }
                mysqli_stmt_close($stmt);
    
                // Update the equipment quantity in the equipment db table
    
                $updateEquipmentQuantity = "UPDATE equipment SET quantity = quantity - ? WHERE equipment_id = ?";
                $stmt = mysqli_prepare($conn, $updateEquipmentQuantity);
                mysqli_stmt_bind_param($stmt, "ii", $equipmentQuantity, $equipmentID);
    
                if(!mysqli_stmt_execute($stmt)){ // if the statement fails
                    throw new Exception("Failed to update equipment availability"); // throw error message
                }
                mysqli_stmt_close($stmt);
    
                // Finally, check if the stock is now sold out (negative stock or 0)
                $checkEquipmentStock = "SELECT quantity FROM equipment WHERE equipment_id = ?";
                $stmt = mysqli_prepare($conn, $checkEquipmentStock);
                mysqli_stmt_bind_param($stmt, "i", $equipmentID);
                mysqli_stmt_execute($stmt);
                $quantityResult = mysqli_stmt_get_result($stmt);
                $equipmentQuantityResult = mysqli_fetch_assoc($quantityResult);
    
                if($equipmentQuantityResult['quantity'] <= 0){ // if the quantity is less than or equal to 0
                    throw new Exception("Equipment out of stock"); // throw error message
                }
                mysqli_stmt_close($stmt);
            }
        }
        
        // if everything is successful and now errors or exceptions are thrown, commit the transaction
        mysqli_commit($conn); 
    
        // Clear the users basket session after successful order
        unset($_SESSION['basket']);
    
        // set success message
        $_SESSION['Success'] = true; // set success session flag to true
        $_SESSION['SuccessMessage'] = "Order Placed Successfully!" . $successIcon; // alert success message to user
    
        //redirect user to order confirmation page
        header("Location: ../frontend/ordersummary.php?order=" . $orderNumber); // direct user to their unique order number page
        exit();
    
    } catch (Exception $exception) {
        // if any error occurs
        mysqli_rollback($conn); // roll back the transaction
    
        $_SESSION['Failed'] = true; // set failed sesson flag to true
        $_SESSION['FailMessage'] = "Error processing your order: " . $exception->getMessage() . " " . $errorIcon; // alert error message to user
        header("Location: ../frontend/payment.php");
        exit();
    }










