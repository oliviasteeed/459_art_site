<?php
require_once('initialize.php');

if(is_post_request() && isset($_POST['filter']) && isset($_POST['value'])){

    if (str_contains($_POST['value'], "select")) {
        unset($_SESSION[$_POST['filter']]); //remove from session if set to default value
    } else {
        $_SESSION[$_POST['filter']] = $_POST['value']; // store if not default
    }
}

$culture = isset($_SESSION['culture']) ? $_SESSION['culture'] : [];

$secondary_filters = [
    'artist_display_name' => $_SESSION['artist_display_name'] ?? null,
    'department' => $_SESSION['department'] ?? null,
    'dimensions' => $_SESSION['dimensions'] ?? null,
    'city' => $_SESSION['city'] ?? null,
    'state' => $_SESSION['state'] ?? null,
    'country' => $_SESSION['country'] ?? null,
    'object_name' => $_SESSION['object_name'] ?? null,
    'medium' => $_SESSION['medium'] ?? null
];


// Fetch updated artworks
$artworks = getArtworksFiltered($culture, $secondary_filters);

$output = "";
foreach ($artworks as $a) {
    $output .= create_object_card($a);
}



?>


