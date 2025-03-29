<?php
require_once('initialize.php');

// Clear only secondary filter values from the session
unset($_SESSION['artist_id']);
unset($_SESSION['department']);
unset($_SESSION['city']);
unset($_SESSION['state']);
unset($_SESSION['country']);
unset($_SESSION['accession_year']);
unset($_SESSION['culture']);

// Redirect back to the browse page
header("Location: browse.php");
exit();