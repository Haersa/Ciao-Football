<?php
session_start();
$pageTitle = "Create Admin Account"; // This will be used in the title tag
$pageDescription = "Create a new Admin Account"; // This is used as the page desciption meta tag
$pageKeywords = "create, new, admin, account"; // This is used as the keywords meta tag

// Include the header file
include('../components/adminheader.php');
?>
<?php
// Inlude the menu file
include('../components/adminmenu.php');
?>



<main><!-- start of main content -->

<section class = "admin-account-creation"><!-- start of admin form section -->
    <div class = "account-creation-container"><!-- start of form container -->
        <div class = "admin-creation-form-card"><!-- start of form card -->
            <div class = "admin-creation-header"><!-- start of admin creation header -->
                <h1>Create Admin Account</h1>
            </div><!-- end of admin creation header -->
            <form class = "admin-creation-form" method = "POST" action = "../backend/createadminaccount.php"><!-- start of form -->
                <div class = "admin-creation-form-group"><!-- start of form group -->
                    <label for = "username">Email (Username)</label><!-- input label -->
                        <input type = "email" name = "username" placeholder = "Username:" minlength = "10" maxlength = "50" required><!-- input field -->
                </div><!-- end of form group -->

                <div class = "admin-creation-form-group"><!-- start of form group -->
                    <label for = "password">Password</label><!-- input label -->
                        <input type = "password" name = "password" placeholder = "Password:" minlength = "10" maxlength = "50" required><!-- input field -->
                </div><!-- end of form group -->
                <div class="admin-creation-form-group">
                    <button type="submit" class="admin-creation-submit-button">Create Admin Account</button>
                </div>
            </form><!-- end of form -->
            </div><!-- end of form card -->
        </div><!-- end of form container -->
</section><!-- end of admin form section -->

</main><!-- end of main content -->


<script src="../js/admin.js"></script>
<script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</body>
</html>