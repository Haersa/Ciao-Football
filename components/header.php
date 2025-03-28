<?php 
session_start();
include('../backend/conn/conn.php'); // connection to database file

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
          <a rel="noopener noreferrer" href="index.php">
            <img
              src="../images/ciaologo.svg"
              alt="Ciao Football Logo"
              class="logo"
            />
          </a>
        </div>
        <div class="text-logo"> <!-- text logo-->
          <a class="text-logo-text" href="index.php" rel="noopener noreferrer">
            Ciao Football
          </a>
        </div> <!-- end of text logo-->
        <!-- logo container-->
        <nav class="navigation">
        <div class="nav-links">
  <!-- start of navigation links-->
  <ul>
    <li><a rel="noopener noreferrer" href="index.php">Home</a></li><!--page link-->
    <li>
      <a rel="noopener noreferrer" href="equipment.php">Equipment</a>
    </li><!--page link-->
    <li>
      <a rel="noopener noreferrer" id="shopby" href="shirts.php">Shop By</a>
    </li><!--page link-->
    <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
      <li>
      <a rel="noopener noreferrer"  href="forsale.php">Sale</a>
    </li><!--page link-->
  <?php endif; ?>
    <?php if(!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']): ?>
      <li><a rel="noopener noreferrer" href="login.php">Sign in</a></li><!--page link-->
      <li><a rel="noopener noreferrer" href="register.php">Register</a></li><!--page link-->
    <?php else: ?>
      <li><a rel="noopener noreferrer" href="../backend/signout.php">Sign out</a></li><!--page link-->
    <?php endif; ?>
  </ul>
</div>
          <!-- end of navigation links-->
        </nav>
      
        <div class="action-container">
  <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
    <div class="user-container"> 
      <a href="profile.php" rel="noopener noreferrer">
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
                <button type="button" class="close-container">
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
            <a rel="noopener noreferrer" href="basket.php">
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
              </svg> <!-- shopping bag/basket icon-->
            </a>
          </div>
          <!-- end of cart container-->
        </div>
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
            <a href = "shirts.php" rel = "noopener noreferrer" class="megabox-title">All Shirts</a>
              <a href = "replicakits.php" rel = "noopener noreferrer" class="megabox-title">Replica Shirts</a>
              <a href = "retrokits.php" rel = "noopener noreferrer" class="megabox-title">Retro Replica's</a>
              <a  href = "specialistkits.php" rel = "noopener noreferrer" class="megabox-title">Replica Specialist Shirts</a>
              <a href = "equipment.php" rel="noopener noreferrer" class="megabox-title">Equipment</a>
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
    <h4 class="category-heading">Serie A</h4>
    <ul class="category-list">
      <li class="category-item"><a href="team.php?team=Juventus" class="category-link">Juventus</a></li>
      <li class="category-item"><a href="team.php?team=AC Milan" class="category-link">AC Milan</a></li>
      <li class="category-item"><a href="team.php?team=Inter Milan" class="category-link">Inter Milan</a></li>
      <li class="category-item"><a href="team.php?team=Napoli" class="category-link">Napoli</a></li>
      <li class="category-item"><a href="team.php?team=Roma" class="category-link">Roma</a></li>
    </ul>
  </div>
  
  <!-- Column 4 -->
  <div class="category-column">
    <h4 class="category-heading">International</h4>
    <ul class="category-list">
      <li class="category-item"><a href="team.php?team=England" class="category-link">England</a></li>
      <li class="category-item"><a href="team.php?team=Scotland" class="category-link">Scotland</a></li>
      <li class="category-item"><a href="team.php?team=Germany" class="category-link">Germany</a></li>
      <li class="category-item"><a href="team.php?team=Brazil" class="category-link">Brazil</a></li>
      <li class="category-item"><a href="team.php?team=Argentina" class="category-link">Argentina</a></li>
    </ul>
  </div>
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
</div>    <!-- end of megabox-->
</header>

<!-- Mobile Menu -->
<section id="Mobile-Menu" class="mobile-menu">
<section class="mobile-menu-header">
  <section class="mobile-logo">
    <a href="index.php">Ciao Football</a>
  </section>
  
  <section class="menu-actions">
    <section class="basket-icon">
      <a rel="noopener noreferrer"  href="basket.php">
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
      <button type="submit">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search">
          <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.3-4.3" />
        </svg>
      </button>
  </section> <!-- end of mobile menu search bar -->
  <section class="mobile-user-action"> <!-- start of mobile user actions -->
  <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']): ?>
        <a rel="noopener noreferrer" href="profile.php">My Account</a>
        <a rel="noopener noreferrer" href="forsale.php">Sale items</a>
        <a rel="noopener noreferrer" href="../backend/signout.php">Sign out</a>
      <?php else: ?>
        <a rel="noopener noreferrer" href="login.php">Sign in</a>
        <a rel="noopener noreferrer" href="register.php">Register</a>
      <?php endif; ?>
      </section><!-- end of mobile user actions -->
  
  <nav class="mobile-navigation"><!-- main mobile navigation -->
    <ul class="mobile-nav-links">
      <li><a rel="noopener noreferrer" href="index.php">Home</a></li>
      <li><a rel="noopener noreferrer" href="equipment.php">Equipment</a></li>
      <li>
        <h2>Shop By</h2>
        <ul class="mobile-submenu">
          <li><a rel="noopener noreferrer" href="shirts.php">All Shirts</a></li>
          <li><a rel="noopener noreferrer" href="replicakits.php">Replica Shirts</a></li>
          <li><a rel="noopener noreferrer" href="retrokits.php">Retro Replicas</a></li>
          <li><a rel="noopener noreferrer" href="specialistkits.php">Replica Specialist Shirts</a></li>
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
    <summary class="mobile-league-title">Serie A</summary>
    <ul class="mobile-teams-list">
      <li class="mobile-team-item"><a href="team.php?team=Juventus" class="mobile-team-link">Juventus</a></li>
      <li class="mobile-team-item"><a href="team.php?team=AC Milan" class="mobile-team-link">AC Milan</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Inter Milan" class="mobile-team-link">Inter Milan</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Napoli" class="mobile-team-link">Napoli</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Roma" class="mobile-team-link">Roma</a></li>
    </ul>
  </details>
  
  <details class="mobile-league-accordion">
    <summary class="mobile-league-title">International</summary>
    <ul class="mobile-teams-list">
      <li class="mobile-team-item"><a href="team.php?team=England" class="mobile-team-link">England</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Scotland" class="mobile-team-link">Scotland</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Germany" class="mobile-team-link">Germany</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Brazil" class="mobile-team-link">Brazil</a></li>
      <li class="mobile-team-item"><a href="team.php?team=Argentina" class="mobile-team-link">Argentina</a></li>
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
</section>
  </nav><!-- end of main mobile navigation-->
</section><!-- end of mobile menu -->