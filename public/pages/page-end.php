<!-- close db connection once done with it -->
<?php
require_once('../../private/database.php');
db_disconnect($db);
?>