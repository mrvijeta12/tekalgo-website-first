<?php
// call the current session 
session_start();
// remove the session variable
session_unset();
// destroy the whole session
session_destroy();

// redirect to login page after logout
header("Location: login");

// stop further execution
exit();
