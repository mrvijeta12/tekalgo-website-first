<?php
// check if the session is already running or not
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Function to check if a user is logged in
function check_login()
{
    if (!isset($_SESSION['email'])) {
        header("Location: logout.php");
        exit();
    }
}
