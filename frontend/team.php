<?php
// Get team and filter using the get method
$team = isset($_GET['team']) ? $_GET['team'] : '';
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Redirect if no team is specified
if (empty($team)) {
    header("Location: index.php");
    exit;
}

// Set dynamic page information based on team
$pageTitle = $team . " Football Products | Ciao Football"; // This will be used in the title tag
$pageDescription = "Browse " . $team . " football shirts and equipment at Ciao Football."; // This is used as the page desciption meta tag
$pageKeywords = $team . ", football, shirts, Ciao Football"; // This will be used as the keywords meta tag

// Include the header file
include('../components/header.php');

// Connect to database
include('../backend/conn/conn.php');

// SQL query based on filter
if ($filter == 'all') {
    $sql = "SELECT * FROM shirts WHERE team = '$team'"; // if no filter is applied, show all products
} else {
    $sql = "SELECT * FROM shirts WHERE team = '$team' AND type = '$filter'"; // if filter is applied, show only products that match the filter
}

// Run the query
$result = $conn->query($sql);
?>

<!-- Main content of the page starts here -->
<main>
<section class="hero">
  <h1><?php echo $team; ?> Products</h1>
  <p>Explore our selection of
    <?php 
    if($filter == 'replica') { // if filter is replica, show replica inside hero text
      echo 'Replica';
    } elseif($filter == 'Retro') { // if filter is retro, show retro inside hero text
      echo 'retro';
    } elseif($filter == 'specialist') { // if filter is specialist, show specialist inside hero text
      echo 'Specialist'; 
    }
    ?> <?php echo $team; // echo the team name ?> Football Shirts</p>
</section>
  
  <!-- Filter options -->
  <section class="team-filters">
    <div class="team-filter-container">
      <h2>Filter Products</h2>
      <div class="filter-buttons">
        <a href="team.php?team=<?php echo $team; ?>" class="filter-btn <?php if($filter == 'all') echo 'active'; ?>">All Products</a> <!-- if no filter is applied, show all products -->
        <a href="team.php?team=<?php echo $team; ?>&filter=replica" class="filter-btn <?php if($filter == 'replica') echo 'active'; ?>">Replica Kits</a> <!-- if filter is replica, show replica products -->
        <a href="team.php?team=<?php echo $team; ?>&filter=retro" class="filter-btn <?php if($filter == 'retro') echo 'active'; ?>">Retro Kits</a> <!-- if filter is retro, show retro products -->
        <a href="team.php?team=<?php echo $team; ?>&filter=specialist" class="filter-btn <?php if($filter == 'specialist') echo 'active'; ?>">Specialist</a> <!-- if filter is specialist, show specialist products -->
      </div>
    </div>
  </section>
  
</main>

<?php
// Include the footer file
include('../components/footer.php');
?>

<script src="../js/app.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>