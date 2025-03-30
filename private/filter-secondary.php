<?php
require_once('initialize.php');

if(is_post_request() && isset($_POST['filter']) && isset($_POST['value'])){
    // $_SESSION[$_POST['filter']] = $_POST['value'];

    if (str_contains($_POST['value'], "select")) {
        unset($_SESSION[$_POST['filter']]); //remove from session if set to default value
    } else {
        $_SESSION[$_POST['filter']] = $_POST['value']; // store if not default
    }
}

$mediums = isset($_SESSION['medium']) ? $_SESSION['medium'] : [];

$secondary_filters = [
    'artist_id' => $_SESSION['artist_id'] ?? null,
    'department' => $_SESSION['department'] ?? null,
    'dimensions' => $_SESSION['dimensions'] ?? null,
    'city' => $_SESSION['city'] ?? null,
    'state' => $_SESSION['state'] ?? null,
    'country' => $_SESSION['country'] ?? null,
    'accession_year' => $_SESSION['accession_year'] ?? null,
    'culture' => $_SESSION['culture'] ?? null,
];

print_r($mediums);
print_r($secondary_filters);

// Fetch updated artworks
$artworks = getArtworksFiltered($mediums, $secondary_filters);

$output = "";
foreach ($artworks as $a) {
    $output .= create_object_card($a);
}

echo $output;


?>


