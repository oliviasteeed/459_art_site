<?php
require_once('initialize.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filter']) && isset($_POST['value'])) {
    $filter = $_POST['filter'];
    $value = $_POST['value'];

    // if not the default empty value, save
    if(!str_contains($value, "select")){
        $_SESSION[$filter] = $value;

    echo "filter-secondary: Filter '$filter' set to '$value'";
    }
    else{
        // if default value is selected, unset the session variable
        unset($_SESSION[$filter]);
        echo "filter-secondary: Filter '$filter' unset"; 
    }
} else {
    echo "Invalid request.";
}
?>
