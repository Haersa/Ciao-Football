<?php
$pageTitle = "Shop"; // This will be used in the title tag
$pageDescription = "Ciao Football's Shop Page. View all of our products."; // This is used as the page desciption meta tag
$pageKeywords = "Ciao, Football, Ciao Football, Soccer, replica, shirt, football shirts, equipment, store, premium, shop, shop page, products"; // This is used as the keywords meta tag

// Include the header file 
include('../components/header.php');
?>


<?php
// Include the back to top button file
include('../components/backtotopbutton.php');
?>

<?php
// query variables, kept empty for now
$priceFilter = "";
$equipmentSql = "";
$shirtsSql = "";
$rangeText = "";

// Check if price parameter exists in URL
if (isset($_GET['price'])) {
    $priceRange = $_GET['price'];
    
    // WHERE clause based on price range, update empty varaibles defined above
    if ($priceRange == 'under50') {
        $priceFilter = "WHERE price < 50 AND sale = 'no'";
        $rangeText = "Under £50";
    } else if ($priceRange == '50-75') {
        $priceFilter = "WHERE price >= 50 AND price <= 75 AND sale = 'no'";
        $rangeText = "£50 - £75";
    } else if ($priceRange == '75-100') {
        $priceFilter = "WHERE price > 75 AND price <= 100 AND sale = 'no'";
        $rangeText = "£75 - £100";
    } else if ($priceRange == 'over100') {
        $priceFilter = "WHERE price > 100 AND sale = 'no'";
        $rangeText = "Over £100";
    }
} 

?>

<main>
   
</main>

<?php
// Include the footer file
include('../components/footer.php');
?>

<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>