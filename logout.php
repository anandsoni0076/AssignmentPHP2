<?php
session_start();  // Start the session

// Unset all session variables
$_SESSION = array();
session_destroy();
header("Location: index.php");
exit();
?>
