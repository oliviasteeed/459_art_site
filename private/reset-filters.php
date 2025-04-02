<?php
require_once('initialize.php');

unset($_SESSION['culture']);

// Clear only secondary filter values from the session
unset($_SESSION['artist_display_name']);
unset($_SESSION['department']);
unset($_SESSION['dimensions']);
unset($_SESSION['city']);
unset($_SESSION['state']);
unset($_SESSION['country']);
unset($_SESSION['medium']);
unset($_SESSION['object_name']);


// Redirect back to the browse page
header("Location: ../public/pages/browse.php");
exit();