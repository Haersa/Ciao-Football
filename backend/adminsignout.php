<?php
session_start();

unset($_SESSION['admin_logged_in']); 

header("Location: ../frontend/index.php"); // redirect to index page on sign/log out
exit();
?>