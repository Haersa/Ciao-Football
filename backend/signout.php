<?php
session_start();

unset($_SESSION['logged_in']); // this preserves the user's basket session, instead of using a session destroy which deletes all session data

header("Location: ../frontend/index.php"); // redirect to index page on sign/log out
exit();
?>