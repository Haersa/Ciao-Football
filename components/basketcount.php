<?php
// php code to calculate how many items are in the users basket based on the session
$totalItems = 0;
if (isset($_SESSION['basket']) && !empty($_SESSION['basket'])) {
    // Loop through each item in the basket and add its quantity to the total, calculating the total number of items in theb asket
    foreach ($_SESSION['basket'] as $item) {
        $totalItems += $item['quantity'];
    }
}
?>