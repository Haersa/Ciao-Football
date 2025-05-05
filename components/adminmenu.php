<?php 
// Get the current page name from the url
$current_page = basename($_SERVER['PHP_SELF']);

// Function to check if this is the active page
function isActive($page, $current_page) { // pass in the page and current page variables to the function to be used in comparison to check if it is active
    return ($current_page == $page) ? 'active' : ''; // if the current page matches the page parameter passed in, return the active class and add the active class (further down the page in the actual menu links)
}
?>


<nav class="admin-navbar">
    <div class="navbar-container">
        <div class="navbar-logo-container">
            <div class="logo-text">
                <p class="navbar-logo-text">Ciao Admin</p>
            </div>
        </div>  
        <div class="burger-menu-container">
            <div class="burger-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu-icon lucide-menu"><path d="M4 12h16"/><path d="M4 18h16"/><path d="M4 6h16"/></svg>
            </div>
        </div> 
    </div>
</nav>

<section class="admin-menu"> <!-- start of admin menu -->
    <div class="close-menu">
        <div class="close-menu-button">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x-icon lucide-x"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        </div>
    </div>
    
    <div class="menu-header">
        <p class="menu-logo-text">Ciao Admin</p>
    </div>
        
    <ul class="navigation-list">
    <li class="navigation-link <?php echo isActive('dashboard.php', $current_page); ?>">
        <a href="dashboard.php">Dashboard</a>
    </li>
    <li class="navigation-link <?php echo isActive('createadminaccount.php', $current_page); ?>">
        <a href="createadminaccount.php">Create Admin Account</a>
    </li>
    <li class="navigation-link <?php echo isActive('ciaoproducts.php', $current_page); ?>">
        <a href="ciaoproducts.php">Products</a>
    </li>
    <li class="navigation-link <?php echo isActive('userdetails.php', $current_page); ?>">
        <a href="userdetails.php">Customers</a>
    </li>
    <li class="navigation-link <?php echo isActive('formsubissions.php', $current_page); ?>">
        <a href="formsubissions.php">Customer Queries</a>
    </li>
</ul>

    <div class="admin-sign-out">
        <a href="../backend/adminsignout">Sign out <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg></a>
    </div>
</section><!-- end of admin menu -->