<?php

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
    <div class = "dashboard-grid-item"><!-- start of dashboard grid item -->
      <div class = "grid-item-content"><!-- start of grid item content -->
          <div class = "grid-analytics"><!-- start of grid card analytics -->
            <p class = "dashboard-card-title">Total Sales</p>
            <p class = "dashboard-card-value">£24,890</p>
            <p class = "dashboard-card-trend positive">+12% from last month</p>
          </div><!-- end of grid card analytics -->
      </div><!-- end of grid item content -->
      <div class = "dashboard-card-icon value"><!-- start of card icon -->
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-no-axes-column-icon lucide-chart-no-axes-column">
          <line x1="18" x2="18" y1="20" y2="10"/>
          <line x1="12" x2="12" y1="20" y2="4"/>
          <line x1="6" x2="6" y1="20" y2="14"/>
        </svg>
      </div><!-- end of card icon -->
    </div><!-- end of dashboard grid item -->
  </div><!-- end of dashboard grid -->
</section><!-- end of dashboard grid container -->


</main><!-- end of main content -->


<script src="../js/admin.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>