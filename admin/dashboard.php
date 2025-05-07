<?php
session_start();
$pageTitle = "Admin Dashboard"; // This will be used in the title tag
$pageDescription = "Ciao Football's Admin Dashboard"; // This is used as the page desciption meta tag
$pageKeywords = "Admin Dashboard"; // This is used as the keywords meta tag

// Include the header file
include('../components/adminheader.php');
?>
<?php
// Inlude the menu file
include('../components/adminmenu.php');
?>

<?php

// SQL Queries for admin dashboard analytics ///////////////////////////////////////////////

// get total amount of users fro mthe db table
$userQuery = "SELECT COUNT(*) as total FROM ciaousers WHERE Admin = 0"; // exclude admin accounts
$stmt = mysqli_prepare($conn, $userQuery);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$total_customers = $row['total'] ? $row['total'] : 0; // store the total amount in a variable to be echoed out
mysqli_stmt_close($stmt);

$shirtQuery =  "SELECT SUM(quantity) as shirts FROM shirts"; // next, get the total amount of shirts available from the shirts table
$stmt = mysqli_prepare($conn, $shirtQuery);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$shirts_count = $row['shirts'] ? $row['shirts'] : 0; // store the total amount in a variable to be used to add the two product types together
mysqli_stmt_close($stmt);

// get the total amount of equipment products from the equipment table
$equipmentQuery = "SELECT SUM(quantity) as equipment FROM equipment";
$stmt = mysqli_prepare($conn, $equipmentQuery);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$equipment_count = $row['equipment'] ? $row['equipment'] : 0; // store the total amount in a variable to be used to add the two product types together
mysqli_stmt_close($stmt);

$total_products = $shirts_count + $equipment_count; // set the total amount of products in a new variable, adding the two product type total counts together

// get the total amount of orders placed from the user_orders table

$orderQuery = "SELECT COUNT(*) as total FROM user_orders"; 
$stmt = mysqli_prepare($conn, $orderQuery);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$total_orders = $row['total'] ? $row['total'] : 0; // store the total amount in a variable to be echoed out
mysqli_stmt_close($stmt);

// get the total amount of sales from the user_orders table
$salesQuery = "SELECT SUM(total_amount) as total FROM user_orders";
$stmt = mysqli_prepare($conn, $salesQuery);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$total_sales = $row['total'] ? $row['total'] : 0; // store the total amount in a variable to be appended and formatted
mysqli_stmt_close($stmt);

$total_sales_formatted = '£' . number_format($total_sales, 2); // format the total amount to 2 deciamls and prefix the £ symbol before it

?>


<main><!-- start of main content -->

<section class = "dashboard-overview"><!-- start of dashboard overview -->
  <div class = "dashboard-title"><!-- start of dashboard title -->
    <h1>Dashboard Overview</h1>
  </div><!-- end of dashboard title -->
    <div class = "dashboard-welcome"><!-- start of dashboard welcome -->
      <p class = "dashboard-overview-text">Welcome back! Here is what's happening at Ciao Football today. <span class = "welcome-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-arrow-down-icon lucide-circle-arrow-down"><circle cx="12" cy="12" r="10"/><path d="M12 8v8"/><path d="m8 12 4 4 4-4"/></svg></span></p>
    </div><!-- end of dashboard welcome -->
</section><!-- end of dashboard overview -->

<section class = "dashboard-grid-container"><!-- start of dashboard grid container -->
  <div class = "dashboard-grid">
  <div class="dashboard-grid-item"><!-- start of dashboard grid item -->
  <div class="grid-item-content"><!-- start of grid item content -->
    <div class="grid-analytics"><!-- start of grid card analytics -->
      <p class="dashboard-card-title">Total Sales</p>
      <p class="dashboard-card-value"><?php echo $total_sales_formatted; ?></p>
      <p class="dashboard-card-trend positive">+12% from last month</p>
    </div><!-- end of grid card analytics -->
    <div class="dashboard-card-icon value"><!-- start of card icon -->
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-no-axes-column-icon lucide-chart-no-axes-column">
        <line x1="18" x2="18" y1="20" y2="10"/>
        <line x1="12" x2="12" y1="20" y2="4"/>
        <line x1="6" x2="6" y1="20" y2="14"/>
      </svg>
    </div><!-- end of card icon -->
  </div><!-- end of grid item content -->
</div><!-- end of dashboard grid item -->
<div class="dashboard-grid-item"><!-- start of dashboard grid item -->
  <div class="grid-item-content"><!-- start of grid item content -->
    <div class="grid-analytics"><!-- start of grid card analytics -->
      <p class="dashboard-card-title">Orders</p>
      <p class="dashboard-card-value"><?php echo $total_orders; ?></p>
      <p class="dashboard-card-trend positive">+5% from last month</p>
    </div><!-- end of grid card analytics -->
    <div class="dashboard-card-icon value"><!-- start of card icon -->
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card-icon lucide-credit-card"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
    </div><!-- end of card icon -->
  </div><!-- end of grid item content -->
</div><!-- end of dashboard grid item -->
<div class="dashboard-grid-item"><!-- start of dashboard grid item -->
  <div class="grid-item-content"><!-- start of grid item content -->
    <div class="grid-analytics"><!-- start of grid card analytics -->
      <p class="dashboard-card-title">New Users</p>
      <p class="dashboard-card-value"><?php echo $total_customers; ?></p>
      <p class="dashboard-card-trend positive">+9% from last month</p>
    </div><!-- end of grid card analytics -->
    <div class="dashboard-card-icon value"><!-- start of card icon -->
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-users-icon lucide-users"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><path d="M16 3.128a4 4 0 0 1 0 7.744"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><circle cx="9" cy="7" r="4"/></svg>
    </div><!-- end of card icon -->
  </div><!-- end of grid item content -->
</div><!-- end of dashboard grid item -->
<div class="dashboard-grid-item"><!-- start of dashboard grid item -->
  <div class="grid-item-content"><!-- start of grid item content -->
    <div class="grid-analytics"><!-- start of grid card analytics -->
      <p class="dashboard-card-title">Products</p>
      <p class="dashboard-card-value"><?php echo $total_products; ?></p>
      <p class="dashboard-card-trend negative">-7% from last year</p>
    </div><!-- end of grid card analytics -->
    <div class="dashboard-card-icon value"><!-- start of card icon -->
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-scan-barcode-icon lucide-scan-barcode"><path d="M3 7V5a2 2 0 0 1 2-2h2"/><path d="M17 3h2a2 2 0 0 1 2 2v2"/><path d="M21 17v2a2 2 0 0 1-2 2h-2"/><path d="M7 21H5a2 2 0 0 1-2-2v-2"/><path d="M8 7v10"/><path d="M12 7v10"/><path d="M17 7v10"/></svg>
    </div><!-- end of card icon -->
  </div><!-- end of grid item content -->
</div><!-- end of dashboard grid item -->
  </div><!-- end of dashboard grid -->
</section><!-- end of dashboard grid container -->

<?php
// query to get the 5 most recent orders in descending order, joins user_orders and order_details tables sum and quantity columns, then it groups by order
$tableQuery = "SELECT user_orders.order_number, user_orders.order_date, user_orders.total_amount, 
          SUM(order_details.quantity) as total_items 
          FROM user_orders, order_details
          WHERE user_orders.order_number = order_details.order_number
          GROUP BY user_orders.order_number, user_orders.order_date, user_orders.total_amount
          ORDER BY user_orders.order_date DESC
          LIMIT 5";
          
$stmt = mysqli_prepare($conn, $tableQuery);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>



<section class = "recent-orders"><!-- start of recent orders -->
  <div class = "recent-orders-heading"><!-- start of recent orders heading -->
    <h2>Recent Orders</h2>
  </div><!-- end of recent orders heading -->

  <section class="purchase-history-container"><!-- start of recent orders table -->
    <table class="purchase-history-table"><!-- start of orders table -->
      <thead>
        <tr><!-- table row -->
          <th>Order Number</th> <!-- table headings -->
          <th>Order Date</th>
          <th>Total Amount</th>
          <th>Items Purchased</th>
        </tr><!-- end of table row -->
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr><!--table row -->
            <td ><?php echo htmlspecialchars($row['order_number']); ?></td>
            <td ><?php echo date('d M Y H:i', strtotime($row['order_date'])); ?></td>
            <td >£<?php echo number_format($row['total_amount'], 2); ?></td>
            <td><?php echo $row['total_items']; ?></td>
          </tr><!-- end of table row -->
        <?php endwhile; ?>
      </tbody>
    </table><!-- end of orders table -->
  </section><!-- end of recent orders -->
  
  <?php mysqli_stmt_close($stmt); ?>

</main><!-- end of main content -->


<script src="../js/admin.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>