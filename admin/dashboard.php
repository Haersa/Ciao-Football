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

<?php
// Inlude the restriction alert file
include('../components/adminrestriction.php');
?>

<!-- Wrap all admin content in the admin-content-wrapper -->
<div class="admin-content-wrapper">
    <!-- Main content of the page starts here -->
    <main>
      <section class="hero">
        <h1>Welcome to the Admin Dashboard for Ciao Football</h1>
        <p>Your destination for premium football gear</p>
      </section>
    </main>
</div>

<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>