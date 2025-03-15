<?php
require_once('../../private/initialize.php');

// uset the username in sessions - this way the username protected pages will not be accessible
unset($_SESSION['username']);
redirect_to('browse.php');

?>