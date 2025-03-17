<?php
require_once('initialize.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filter']) && isset($_POST['value'])) {
    $filter = $_POST['filter'];
    $value = $_POST['value'];

    // Store selection in session
    $_SESSION[$filter] = $value;

    // Perform your SQL query or any other action
    echo "in php: Filter '$filter' set to '$value'"; // This is sent back as response
} else {
    echo "Invalid request.";
}
?>
