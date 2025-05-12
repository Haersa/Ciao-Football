<?php 
session_start();
include('../backend/conn/conn.php'); // connection to database file
include('basketcount.php');

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0"); // these make sure the login feedback message on login is only displayed once, and isn't shown again if a user clicks the browser back arrow (found on stack overflow)
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Display success message if exists
if (isset($_SESSION['Success']) && $_SESSION['Success']) {
    echo '<div class="success-message">' . $_SESSION['SuccessMessage'] . '</div>';
    unset($_SESSION['Success']);
    unset($_SESSION['SuccessMessage']);
}

// Display failure message if exists
if (isset($_SESSION['Failed']) && $_SESSION['Failed']) {
    echo '<div class="error-message">' . $_SESSION['FailMessage'] . '</div>';
    unset($_SESSION['Failed']);
    unset($_SESSION['FailMessage']);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" /> <!-- Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="<?php echo isset($pageDescription) ? $pageDescription : ''; ?>" />
    <meta name="author" content="Ciao Football" />
    <meta name="keywords" content="<?php echo isset($pageKeywords) ? $pageKeywords : ''; ?>"/>
    <title><?php echo isset($pageTitle) ? $pageTitle.' - ' : ''; ?>Ciao Football</title> <!--Page title-->
    <!-- Light mode favicon-->
    <link rel = "icon" type = "svg+xml" href = "../images/favicondark.svg" media = "(prefers-color-scheme: light)">
     <!-- Dark mode favicon-->
    <link rel = "icon" type = "svg+xml" href = "../images/favicon.svg" media = "(prefers-color-scheme: dark)">
  
    <link rel="stylesheet" href="../css/style.css" /> <!-- CSS file-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flickity/2.3.0/flickity.min.css">
  </head>
  <body>
  <div id = "top"></div>
    <header>
      <!-- start of header-->
      <div class="top-container">
        <!--start of top container-->
        <div class="top-text">
          <!--start of top text-->
          <p>Exclusive Sales for Members</p>
        </div>
        <!--end of top text-->
      </div>
      <!--end of top container-->
      <div class="nav-container">
        <!--start of navigation container-->
        <div class="logo-container">
          <!-- logo container-->
          <a  href="index.php">
            <img
              src="../images/ciaologo.svg"
              alt="Ciao Football Logo"
              class="logo"
            />
          </a>
        </div>
        <div class="text-logo"> <!-- text logo-->
          <a class="mobile-logo" href="index.php" >
            Ciao Football
          </a>
        </div> <!-- end of text logo-->
        <!-- logo container-->
        <nav class="navigation">
        <div class="nav-links">
  <!-- start of navigation links-->
  <ul>
    <li><a  href="index.php">Home</a></li><!--page link-->
    <li>
      <a  href="equipment.php">Equipment</a>
    </li><!--page link-->
    <li>
      <a  href = "shirts.php" id="shopby">Shop By</a>
    </li><!--page link-->
    <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
      <li>
      <a   href="forsale.php">Sale</a>
    </li><!--page link-->
  <?php endif; ?>
    <?php if(!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']): ?>
      <li><a  href="login.php">Sign in</a></li><!--page link-->
      <li><a  href="register.php">Register</a></li><!--page link-->
    <?php else: ?>
      <li><a  href="../backend/signout.php">Sign out</a></li><!--page link-->
    <?php endif; ?>
  </ul>
</div>
          <!-- end of navigation links-->
        </nav>
      
        <div class="action-container">
  <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
    <div class="user-container"> 
      <a href="profile.php" >
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      </a>          
    </div>
  <?php endif; ?>
          <!-- start of action container-->
          <div class="search-container">
            <!-- start of search container-->
              <!-- search icon-->
            <svg
              id="search-icon"
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              stroke="#050505"
              stroke-width="2"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="lucide lucide-search"
            > 
              <circle cx="11" cy="11" r="8" />
              <path d="m21 21-4.3-4.3" />
            </svg><!-- search icon-->
    
            <div class="search-dropdown"> <!-- search input dropdown-->
              <div class="search-input-container">
                <input type="text" placeholder="Search..." />
                <button type="button" aria-label="Search" class="close-container">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="20"
                    height="20"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="#050505"
                    stroke-width="2"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    class="lucide lucide-x"
                    id="close-search-icon"
                  >
                    <path d="M18 6 6 18" />
                    <path d="m6 6 12 12" />
                  </svg>
                </button>
              </div>
              <input type="submit" value="Search" />
            </div><!-- end of search input dropdown-->
          </div>
          <!-- end of search container-->
          <div class="cart-container">
  <!-- start of cart container-->
  <a href="basket.php" aria-label="Basket" class="basket-link">
    <!-- shopping bag/basket icon-->
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="24"
      height="24"
      viewBox="0 0 24 24"
      fill="none"
      stroke="#050505"
      stroke-width="2"
      stroke-linecap="round"
      stroke-linejoin="round"
      class="lucide lucide-shopping-bag"
    >
      <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
      <path d="M3 6h18" />
      <path d="M16 10a4 4 0 0 1-8 0" />
    </svg>
    
    <?php
    // Display the counter if there are items in the basket
    if ($totalItems > 0) {
        echo '<span class="basket-count">' . $totalItems . '</span>';
    }
    ?>
  </a>
</div>
<!-- end of cart container-->
           <div class = "tablet-burger-container"><!-- burger menu for tablet screens -->
           <svg id="tablet-burger-button" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shirt-icon lucide-shirt"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/></svg>        </div>
        <div class="burger-container">
          <svg id="burger-button" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
        </div>
        <!--end of action container-->
      </div>
      <!-- end of navigation container-->
      <div id="megabox" class="megabox">
        <div class="megabox-container">
          <div class="megabox-content">
            <!-- Main category tabs -->
            <div class="megabox-row">
            <a href = "shirts.php"  class="megabox-title">All Shirts</a>
              <a href = "replicakits.php"  class="megabox-title">Replica Shirts</a>
              <a href = "retrokits.php"  class="megabox-title">Retro Shirts</a>
              <a  href = "specialistkits.php"  class="megabox-title">Specialist Shirts</a>
            </div>
<div class="content-box">
  <!-- Column 1 -->
  <div class="category-column">
    <h4 class="category-heading">Premier League</h4>
    <ul class="category-list">
      <li class="category-item"><a href="team.php?team=Man Utd" class="category-link">Manchester United</a></li>
      <li class="category-item"><a href="team.php?team=Liverpool" class="category-link">Liverpool</a></li>
      <li class="category-item"><a href="team.php?team=Arsenal" class="category-link">Arsenal</a></li>
      <li class="category-item"><a href="team.php?team=Chelsea" class="category-link">Chelsea</a></li>
      <li class="category-item"><a href="team.php?team=Manchester City" class="category-link">Manchester City</a></li>
    </ul>
  </div>
  
  <!-- Column 2 -->
  <div class="category-column">
    <h4 class="category-heading">La Liga</h4>
    <ul class="category-list">
      <li class="category-item"><a href="team.php?team=Barcelona" class="category-link">Barcelona</a></li>
      <li class="category-item"><a href="team.php?team=Real Madrid" class="category-link">Real Madrid</a></li>
      <li class="category-item"><a href="team.php?team=Atletico Madrid" class="category-link">Atletico Madrid</a></li>
      <li class="category-item"><a href="team.php?team=Sevilla" class="category-link">Sevilla</a></li>
      <li class="category-item"><a href="team.php?team=Valencia" class="category-link">Valencia</a></li>
    </ul>
  </div>
  
  <!-- Column 3 -->
  <div class="category-column">
    <h4 class="category-heading">Bundesliga</h4>
    <ul class="category-list">
      <li class="category-item"><a href="team.php?team=Dortmund" class="category-link">Borussia Dortmund</a></li>
      <li class="category-item"><a href="team.php?team=Bayern Munich" class="category-link">Bayern Munich</a></li>
      <li class="category-item"><a href="team.php?team=Bayern Leverkusen" class="category-link">Bayern Leverkusen</a></li>
      <li class="category-item"><a href="team.php?team=St. Pauli" class="category-link">St. Pauli</a></li>
      <li class="category-item"><a href="team.php?team=Frankfurt" class="category-link">Eintracht Frankfurt</a></li>
    </ul>
  </div>

  <!-- Column 4 -->
  <div class="category-column">
    <h4 class="category-heading">SPFL</h4>
    <ul class="category-list">
      <li class="category-item"><a href="team.php?team=Celtic" class="category-link">Celtic</a></li>
      <li class="category-item"><a href="team.php?team=Rangers" class="category-link">Rangers</a></li>
      <li class="category-item"><a href="team.php?team=Hibernian" class="category-link">Hibernian</a></li>
      <li class="category-item"><a href="team.php?team=Hearts" class="category-link">Hearts</a></li>
      <li class="category-item"><a href="team.php?team=Aberdeen" class="category-link">Aberdeen</a></li>
    </ul>
  </div>
  
  <!-- Column 5 -->
  <div class="category-column">
    <h4 class="category-heading">Serie A</h4>
    <ul class="category-list">
      <li class="category-item"><a href="team.php?team=Napoli" class="category-link">Napoli</a></li>
      <li class="category-item"><a href="team.php?team=Roma" class="category-link">Roma</a></li>
      <li class="category-item"><a href="team.php?team=Juventus" class="category-link">Juventus</a></li>
      <li class="category-item"><a href="team.php?team=Inter Milan" class="category-link">Inter Milan</a></li>
      <li class="category-item"><a href="team.php?team=AC Milan" class="category-link">AC Milan</a></li>
    </ul>
  </div>
</div>    <!-- end of megabox-->
</header>

<section class="tablet-shop-menu" id = "tablet-menu"> <!-- tablet shop by menu -->
  <div class="tablet-menu-top-row"><!-- start of tablet menu top row -->
    <div class="tablet-menu-heading"><!-- tablet menu heading -->
      <h2>Shop by:</h2>
    </div>
    <div id="close-tablet-menu" class="tablet-menu-close"> <!-- tablet menu closing button -->
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#050505" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x">
        <path d="M18 6 6 18" />
        <path d="m6 6 12 12" />
      </svg>
    </div>
  </div><!-- end of tablet menu top row -->
  <div class = "tablet-link-row"><!-- tablet link row -->
  <a href = "shirts.php"  class="tablet-link-row-title">All Shirts</a>
              <a href = "replicakits.php"  class="tablet-link-item">Replica Shirts</a>
              <a href = "retrokits.php"  class="tablet-link-item">Retro Shirts</a>
              <a  href = "specialistkits.php"  class="tablet-link-item">Specialist Shirts</a>
              <a href = "equipment.php"  class="tablet-link-item">Equipment</a>
  </div><!-- end of tablet link row -->
  <div class="tablet-nav-menu"><!-- start of tablet navigation-->
  <div class="tablet-content-box">
    <div class="tablet-nav-menu-row"><!-- nav menu row  -->
      <!-- Column 1 -->
      <div class="tablet-category-column">
        <h4 class="tablet-category-heading">Premier League</h4>
        <ul class="tablet-category-list">
          <li class="tablet-category-item"><a href="team.php?team=Man Utd" class="tablet-category-link">Manchester United</a></li>
          <li class="tablet-category-item"><a href="team.php?team=Liverpool" class="tablet-category-link">Liverpool</a></li>
          <li class="tablet-category-item"><a href="team.php?team=Arsenal" class="tablet-category-link">Arsenal</a></li>
          <li class="tablet-category-item"><a href="team.php?team=Chelsea" class="tablet-category-link">Chelsea</a></li>
          <li class="tablet-category-item"><a href="team.php?team=Manchester City" class="tablet-category-link">Manchester City</a></li>
        </ul>
      </div>
      
      <!-- Column 2 -->
      <div class="tablet-category-column">
        <h4 class="tablet-category-heading">La Liga</h4>
        <ul class="tablet-category-list">
          <li class="tablet-category-item"><a href="team.php?team=Barcelona" class="tablet-category-link">Barcelona</a></li>
          <li class="tablet-category-item"><a href="team.php?team=Real Madrid" class="tablet-category-link">Real Madrid</a></li>
          <li class="tablet-category-item"><a href="team.php?team=Atletico Madrid" class="tablet-category-link">Atletico Madrid</a></li>
          <li class="tablet-category-item"><a href="team.php?team=Sevilla" class="tablet-category-link">Sevilla</a></li>
          <li class="tablet-category-item"><a href="team.php?team=Valencia" class="tablet-category-link">Valencia</a></li>
        </ul>
      </div>
      
      <!-- Column 3 -->
      <div class="tablet-category-column">
        <h4 class="tablet-category-heading">Bundesliga</h4>
        <ul class="tablet-category-list">
          <li class="tablet-category-item"><a href="team.php?team=Dortmund" class="tablet-category-link">Borussia Dortmund</a></li>
          <li class="tablet-category-item"><a href="team.php?team=Bayern Munich" class="tablet-category-link">Bayern Munich</a></li>
          <li class="tablet-category-item"><a href="team.php?team=Bayern Leverkusen" class="tablet-category-link">Bayern Leverkusen</a></li>
          <li class="tablet-category-item"><a href="team.php?team=St. Pauli" class="tablet-category-link">St. Pauli</a></li>
          <li class="tablet-category-item"><a href="team.php?team=Frankfurt" class="tablet-category-link">Eintrach Frankfurt</a></li>
        </ul>
      </div>
      <!-- Column 4 -->
      <div class="tablet-category-column">
        <h4 class="tablet-category-heading">SPFL</h4>
        <ul class="tablet-category-list">
          <li class="tablet-category-item"><a href="team.php?team=Celtic" class="tablet-category-link">Celtic</a></li>
          <li class="tablet-category-item"><a href="team.php?team=Rangers" class="tablet-category-link">Rangers</a></li>
          <li class="tablet-category-item"><a href="team.php?team=Hibernian" class="tablet-category-link">Hibernian</a></li>
          <li class="tablet-category-item"><a href="team.php?team=Hearts" class="tablet-category-link">Hearts</a></li>
          <li class="tablet-category-item"><a href="team.php?team=Aberdeen" class="tablet-category-link">Aberdeen</a></li>
        </ul>
      </div>
      
      <!-- Column 5 -->
      <div class="tablet-category-column">
        <h4 class="tablet-category-heading">Serie A</h4>
        <ul class="tablet-category-list">
          <li class="tablet-category-item"><a href="team.php?team=Napoli" class="tablet-category-link">Napoli</a></li>
          <li class="tablet-category-item"><a href="team.php?team=Roma" class="tablet-category-link">Roma</a></li>
          <li class="tablet-category-item"><a href="team.php?team=Juventus" class="tablet-category-link">Juventus</a></li>
          <li class="tablet-category-item"><a href="team.php?team=Inter Milan" class="tablet-category-link">Inter Milan</a></li>
          <li class="tablet-category-item"><a href="team.php?team=AC Milan" class="tablet-category-link">AC Milan</a></li>
        </ul>
      </div>
    </div><!-- end of tablet nav menu row  -->
  </div> 
</div><!-- end of tablet navigation-->
</section> <!-- end of tablet shop by menu -->



<!-- Mobile Menu -->
<section id="Mobile-Menu" class="mobile-menu">
<section class="mobile-menu-header">
  <section class="mobile-logo">
    <a  href="index.php">Ciao Football</a>
  </section>
  
  <section class="menu-actions">
  <section class="basket-icon">
  <a href="basket.php" aria-label="Basket" class="basket-link">
    <!-- shopping bag/basket icon-->
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width="24"
      height="24"
      viewBox="0 0 24 24"
      fill="none"
      stroke="#050505"
      stroke-width="2"
      stroke-linecap="round"
      stroke-linejoin="round"
      class="lucide lucide-shopping-bag"
    >
      <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
      <path d="M3 6h18" />
      <path d="M16 10a4 4 0 0 1-8 0" />
    </svg>
    
    <?php
    // Display the counter if there are items in the basket
    if ($totalItems > 0) {
        echo '<span class="basket-count">' . $totalItems . '</span>';
    }
    ?>
  </a>
</section>
    
    <section id="close-burger" class="close-button">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#050505" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x">
        <path d="M18 6 6 18" />
        <path d="m6 6 12 12" />
      </svg>
    </section>
  </section>
</section>

  <section class="mobile-search"> <!-- mobile menu search bar -->
    <input type="text" placeholder="Search..." />
      <button aria-label="Search" type="submit">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search">
          <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.3-4.3" />
        </svg>
      </button>
  </section> <!-- end of mobile menu search bar -->
  <section class="mobile-user-action"> <!-- start of mobile user actions -->
  <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
        <a  href="profile.php">My Account</a>
        <a  href="forsale.php">Sale items</a>
        <a  href="../backend/signout.php">Sign out</a>
      <?php else: ?>
        <a  href="login.php">Sign in</a>
        <a  href="register.php">Register</a>
      <?php endif; ?>
      </section><!-- end of mobile user actions -->
  
  <nav class="mobile-navigation"><!-- main mobile navigation -->
    <ul class="mobile-nav-links">
      <li><a  href="index.php">Home</a></li>
      <li><a  href="equipment.php">Equipment</a></li>
      <li>
        <h2>Shop By</h2>
        <ul class="mobile-submenu">
          <li><a  href="shirts.php">All Shirts</a></li>
          <li><a  href="replicakits.php">Replica Shirts</a></li>
          <li><a  href="retrokits.php">Retro Shirts</a></li>
          <li><a  href="specialistkits.php">Specialist Shirts</a></li>
        </ul>
      </li>
    </ul>
    <section class="mobile-teams-navigation">
  <h2 class="mobile-teams-heading">Shop by Team</h2>
  
  <details class="mobile-league-accordion">
    <summary class="mobile-league-title">Premier League</summary>
    <ul class="mobile-teams-list">
      <li class="mobile-team-item"><a href="team.php?team=Man Utd" class="mobile-team-link">Manchester United</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Liverpool" class="mobile-team-link">Liverpool</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Arsenal" class="mobile-team-link">Arsenal</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Chelsea" class="mobile-team-link">Chelsea</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Manchester City" class="mobile-team-link">Manchester City</a></li>
    </ul>
  </details>
  
  <details class="mobile-league-accordion">
    <summary class="mobile-league-title">La Liga</summary>
    <ul class="mobile-teams-list">
      <li class="mobile-team-item"><a href="team.php?team=Barcelona" class="mobile-team-link">Barcelona</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Real Madrid" class="mobile-team-link">Real Madrid</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Atletico Madrid" class="mobile-team-link">Atletico Madrid</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Sevilla" class="mobile-team-link">Sevilla</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Valencia" class="mobile-team-link">Valencia</a></li>
    </ul>
  </details>
  
  <details class="mobile-league-accordion">
    <summary class="mobile-league-title">Bundesliga</summary>
    <ul class="mobile-teams-list">
      <li class="mobile-team-item"><a href="team.php?team=Dortmund" class="mobile-team-link">Borussia Dortmund</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Bayern Munich" class="mobile-team-link">Bayern Munich</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Bayern Leverkusen" class="mobile-team-link">Bayern Leverkusen</a></li>
      <li class="mobile-team-item"><a href="team.php?team=St. Pauli" class="mobile-team-link">St. Pauli</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Frankfurt" class="mobile-team-link">Eintrach Frankfurt</a></li>
    </ul>
  </details>

  <details class="mobile-league-accordion">
    <summary class="mobile-league-title">SPFL</summary>
    <ul class="mobile-teams-list">
      <li class="mobile-team-item"><a href="team.php?team=Celtic" class="mobile-team-link">Celtic</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Rangers" class="mobile-team-link">Rangers</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Hibernian" class="mobile-team-link">Hibernian</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Hearts" class="mobile-team-link">Hearts</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Aberdeen" class="mobile-team-link">Aberdeen</a></li>
    </ul>
  </details>
  
  <details class="mobile-league-accordion">
    <summary class="mobile-league-title">Serie A</summary>
    <ul class="mobile-teams-list">
      <li class="mobile-team-item"><a href="team.php?team=Napoli" class="mobile-team-link">Napoli</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Roma" class="mobile-team-link">Roma</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Juventus" class="mobile-team-link">Juventus</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Inter Milan" class="mobile-team-link">Inter Milan</a></li>
      <li class="mobile-team-item"><a href="team.php?team=AC Milan" class="mobile-team-link">AC Milan</a></li>
    </ul>
  </details>

</section>
  </nav><!-- end of main mobile navigation-->
</section><!-- end of mobile menu -->