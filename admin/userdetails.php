<?php
session_start();
$pageTitle = "Customer Accounts"; // This will be used in the title tag
$pageDescription = "Ciao Football's Customer Portal"; // This is used as the page desciption meta tag
$pageKeywords = "ACustomer Portal"; // This is used as the keywords meta tag

// Include the header file
include('../components/adminheader.php');
?>
<?php
// Inlude the menu file
include('../components/adminmenu.php');
?>


<?php
// Query to get users who last logged in less than 6 months ago, excluding admin accounts
$recentUsersQuery = "SELECT * FROM ciaousers WHERE Admin = 0 AND last_login > DATE_SUB(NOW(), INTERVAL 6 MONTH)";
$stmt = mysqli_prepare($conn, $recentUsersQuery);
mysqli_stmt_execute($stmt);
$recentUsers = mysqli_stmt_get_result($stmt); // store the user accounts in recent users variable
$recentUsersCount = mysqli_num_rows($recentUsers); // Count of users
mysqli_stmt_close($stmt);

// Query to get users who last logged in more than  6 months ago, excluding admin accounts
$inactiveUsersQuery = "SELECT * FROM ciaousers WHERE Admin = 0 AND last_login <= DATE_SUB(NOW(), INTERVAL 6 MONTH)";
$stmt = mysqli_prepare($conn, $inactiveUsersQuery);
mysqli_stmt_execute($stmt);
$inactiveUsers = mysqli_stmt_get_result($stmt); // store the user accounts in inactive users variable
$inactiveUsersCount = mysqli_num_rows($inactiveUsers); // Count of users
mysqli_stmt_close($stmt);

?>

<main><!-- start of main content -->

<section class="user-summary"><!-- start of user summary heading section -->
  <div class="user-summary-card active-card">
    <div class="user-summary-number active-user"><?php echo $recentUsersCount; ?></div>
    <div class="user-summary-label">Active Users</div>
  </div>
  
  <div class="user-summary-card inactive-card">
    <div class="user-summary-number inactive-user"><?php echo $inactiveUsersCount; ?></div>
    <div class="user-summary-label">Inactive Users</div>
  </div>
  
  <div class="user-summary-card total-card">
    <div class="user-summary-number total-user"><?php echo $recentUsersCount + $inactiveUsersCount; ?></div>
    <div class="user-summary-label">Total Users</div>
  </div>
  
  <div class="user-summary-card percentage-card">
    <?php
      // Calculate the percentage of active users
      $percentActive = ($recentUsersCount + $inactiveUsersCount > 0) 
      // If there are users, calculate the percentage and round to a whole number
      ? round(($recentUsersCount / ($recentUsersCount + $inactiveUsersCount)) * 100) 
      // If there are no users, return 0 to avoid division by zero
      : 0;
    ?>
    <div class="user-summary-number percentage-user"><?php echo $percentActive; ?>%</div>
    <div class="user-summary-label">Activity Rate</div>
  </div>
</section><!-- end of user summary heading section -->


  <!-- Active Users -->
  <section class="active-users"><!-- start of active users -->
    <div class="active-users-heading"><!-- start of active users heading -->
      <h2>Active Users (Last 6 Months)</h2>
    </div><!-- end of active users heading -->

    <section class="active-users-table"><!-- start of active users table -->
      <table class="users-table"><!-- start of users table -->
        <thead>
          <tr><!-- table row -->
            <th>ID</th><!-- table headings -->
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Last Login</th>
            <th class = "th-center">Actions</th>
          </tr><!-- end of table row -->
        </thead>
        <tbody>
          <?php while ($user = mysqli_fetch_assoc($recentUsers)): ?> <!-- loop through each user and create a table record -->
            <tr><!--table row -->
              <td><?php echo htmlspecialchars($user['userid']); ?></td>
              <td>
                <form method="POST" action="../backend/updateUser.php" class="edit-user-form">
                  <input type="hidden" name="userid" value="<?php echo htmlspecialchars($user['userid']); ?>">
                  <input type="text" minlength = "3" maxlength = "50" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">
              </td>
              <td>
                  <input type="text" minlength = "3" maxlength = "50" name="surname" value="<?php echo htmlspecialchars($user['surname']); ?>">
              </td>
              <td>
                  <input type="email" minlength = "8" maxlength = "50" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
              </td>
              <td class = "table-last-login"><?php echo date('d M Y H:i', strtotime($user['last_login'])); ?></td>
              <td class="action-buttons">
                  <button type="submit" name="updateButton" value="update" class="update-button">Update</button>
                </form>
                <form method="POST" action="../backend/deleteUser.php" class="delete-user-form">
                  <input type="hidden" name="userid" value="<?php echo htmlspecialchars($user['userid']); ?>">
                  <button type="button" class="delete-button" onclick="document.getElementById('delete-user-id').value='<?php echo htmlspecialchars($user['userid']); ?>'; document.getElementById('delete-confirmation-dialog').showModal();"> Delete </button> <!-- on click, open the delete confirmation modal and tie it to the userid of the user that the delete button was clicked for -->
                </form>
              </td>
            </tr><!-- end of table row -->
          <?php endwhile; ?>
        </tbody>
      </table><!-- end of users table -->
    </section><!-- end of active users table -->
  </section><!-- end of active users -->

  <!-- Inactive Users -->
  <section class="inactive-users"><!-- start of inactive users -->
    <div class="inactive-users-heading"><!-- start of inactive users heading -->
      <h2>Inactive Users (More Than 6 Months)</h2>
    </div><!-- end of inactive users heading -->

    <section class="inactive-users-table"><!-- start of inactive users table -->
      <table class="users-table"><!-- start of users table -->
        <thead>
          <tr><!-- table row -->
            <th>ID</th><!-- table headings -->
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>Last Login</th>
            <th class = "th-center">Actions</th>
          </tr><!-- end of table row -->
        </thead>
        <tbody>
          <?php while ($user = mysqli_fetch_assoc($inactiveUsers)): ?> <!-- loop through each user and create a table record -->
            <tr><!--table row -->
              <td><?php echo htmlspecialchars($user['userid']); ?></td>
              <td>
                <form method="POST" action="../backend/updateUser.php" class="edit-user-form">
                  <input type="hidden" name="userid" value="<?php echo htmlspecialchars($user['userid']); ?>">
                  <input type="text" minlength = "3" maxlength = "50" name="name" value="<?php echo htmlspecialchars($user['name']); ?>">
              </td>
              <td>
                  <input type="text" minlength = "3" maxlength = "50" name="surname" value="<?php echo htmlspecialchars($user['surname']); ?>">
              </td>
              <td>
                  <input type="email" name="email" minlength = "8" maxlength = "50" value="<?php echo htmlspecialchars($user['email']); ?>">
              </td>
              <td class = "table-last-login"><?php echo date('d M Y H:i', strtotime($user['last_login'])); ?></td>
              <td class="action-buttons">
                  <button type="submit" name="updateButton" value="update" class="update-button">Update</button>
                </form>
                <form method="POST" action="../backend/deleteUser.php" class="delete-user-form">
                  <input type="hidden" name="userid" value="<?php echo htmlspecialchars($user['userid']); ?>">
                  <button type="button" class="delete-button" onclick="document.getElementById('delete-user-id').value='<?php echo htmlspecialchars($user['userid']); ?>'; document.getElementById('delete-confirmation-dialog').showModal();"> Delete </button> <!-- on click, open the delete confirmation modal and tie it to the userid of the user that the delete button was clicked for -->
                </form>
              </td>
            </tr><!-- end of table row -->
          <?php endwhile; ?>
        </tbody>
      </table><!-- end of users table -->
    </section><!-- end of inactive users table -->
  </section><!-- end of inactive users -->
</main><!-- end of main content -->

<dialog id="delete-confirmation-dialog" class="delete-dialog"><!-- delete user confirmation modal -->
  <div class="dialog-content">
    <h3>Confirm Deletion</h3>
    <p>Are you sure you want to delete this user? This action cannot be undone.</p>
    <div class="dialog-buttons">
      <button class="cancel-button" onclick="document.getElementById('delete-confirmation-dialog').close();">Cancel</button> <!-- on click, close the modal -->
      <form id="confirm-delete-form" method="POST" action="../backend/deleteUser.php">
        <input type="hidden" id="delete-user-id" name="userid" value="">
        <button type="submit" name="deleteButton" value="delete" class="delete-button">Delete</button>
      </form>
    </div>
  </div>
</dialog><!-- end of delete user confirmation modal -->



<script src="../js/admin.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>