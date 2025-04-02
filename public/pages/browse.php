<!-- main page -->
 <?php
require('../../private/initialize.php');
require('header.php');

 if(isset($_SESSION['username'])) {
    //anything sign in specific?
    }

    // get primary filters - cultures
    $culture_array = getDbColumn('culture', 'metobjects');
    //remove null values from culture array
    $culture_array = array_filter($culture_array, function ($value) {
        return !is_null($value);
    });

    $artists_array = getDbColumn('artist_display_name', 'artists'); 
    $artists_array[0] = "select artist"; 

    //this doesn't work??? ?? ?????? it should be the same as all the others though??
    $department_array = getDbColumn('department', 'metobjects');
    $department_array[0] = "select department"; 

    $dimensions_array = getDbColumn('dimensions', 'metobjects');
    $dimensions_array[0] = "select dimensions"; 

    $city_array = getDbColumn('city', 'metobjects');
    $city_array[0] = "select city";

    $state_array = getDbColumn('state', 'metobjects');
    $state_array[0] = "select state"; 

    $country_array = getDbColumn('country', 'metobjects');
    $country_array[0] = "select country"; 

    $object_array = getDbColumn('object_name', 'metobjects');
    $object_array[0] = "select object"; 

    $medium_array = getDbColumn('medium', 'metobjects');
    $medium_array[0] = "select medium"; 

    //initialize empty array for when cultures tag buttons are selected
    $selected_cultures = [];

    $secondary_filters = [
        'artist_display_name' => $_SESSION['artist_display_name'] ?? null,
        'department' => $_SESSION['department'] ?? null,
        'dimensions' => $_SESSION['dimensions'] ?? null,
        'city' => $_SESSION['city'] ?? null,
        'state' => $_SESSION['state'] ?? null,
        'country' => $_SESSION['country'] ?? null,
        'object_name' => $_SESSION['object_name'] ?? null,
        'medium' => $_SESSION['medium'] ?? null,
    ];

    $artworks = []; //initialize empty array for artworks (by medium)

    if(is_post_request()){ //if medium filters have been submitted
        if(isset($_POST['culture'])){
            $selected_cultures = $_POST['culture']; // get user input
            $_SESSION['culture'] = $selected_cultures;

            $artworks = getArtworksFiltered($selected_cultures, $secondary_filters); // get artworks with this medium from db
            
        } else {    //clear anything saved
            unset($_SESSION['culture']);
            $artworks = getArtworksFiltered($culture_array, $secondary_filters);    //get all artworks if no filters applied
        }
    }else{
        $artworks = getArtworksFiltered($culture_array, $secondary_filters);
    }


// ACTUAL UI

echo "<div class='left-align'>";
echo "<h1 class='small-m-bottom'>i'm interested in...</h1>";

//create tags for each medium
echo "<h4>culture of origin</h4>";

// form for culture filters
echo "<form class='h-box small-m-bottom' action='browse.php' method='post'>";
echo "<div class='h-box tag-box flex-3'>";
//making visible tags
foreach($culture_array as $c){
    create_tag($c, $selected_cultures);
}
echo "</div>";
// hidden input container for storing selected tags (since they are buttons not form elements)
echo "<div id='selected-tags'>";
if(isset($_SESSION['culture'])){    //put selected tags in post request always
    foreach($_SESSION['culture'] as $c){
        echo "<input type='hidden' name='culture[]' value='$c'>";
    }
}

echo "</div>";
echo "<div class='button-box flex-1'>";
echo "<input class='circle-button' type='submit' value='go >'/>";
echo "</div>";
echo "</form>";

// secondary filter dropdowns (ajax)
echo "<h4>artwork details</h4>";
echo "<div class='h-box m-bottom'>";

echo "<div class='dropdown-box flex-3'>";
echo create_select_input("artist_display_name", $artists_array);
echo create_select_input("department", $department_array);
echo create_select_input("medium", $medium_array);
echo create_select_input("object_name", $object_array);
echo create_select_input("city", $city_array);
echo create_select_input("state", $state_array);
echo create_select_input("country", $country_array);
echo "</div>";

echo "<div class='button-box flex-1'>";
echo "<button class='circle-button' id='reset-button'>reset all</button>";
echo "</div>";

echo "</div>";
echo "</div>";



// TODO: COMMENTS
//TODO: fix filtering mexican


//handling pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 9; //artworks per page
$totalArtworks = count($artworks);  //get total pages
$totalPages = ceil($totalArtworks / $perPage);
$page = max(1, min($page, $totalPages));    //keep page within max range
$startIndex = ($page - 1) * $perPage;   //get only first page
$displayArtworks = array_slice($artworks, $startIndex, $perPage);

// // display artworks
echo "<div class='artwork-box m-bottom' id='artwork-box'>";
foreach ($displayArtworks as $a) {
    create_object_card($a);
}
echo "</div>";

// prev and next buttons - only show when there is a prev or next to go to
echo "<div class='centered-box'>";
echo "<div class='centered-buttons'>";
if ($page > 1) { 
    echo "<a href='?page=" . ($page - 1) . "' class='circle-button'>&lt; prev</a>";
}
if ($page < $totalPages) { 
    echo "<a href='?page=" . ($page + 1) . "' class='circle-button'>next &gt;</a>";
}
echo "</div>";
echo "</div>";



if (empty($artworks)) {
    echo "<div class='v-box'>";
    echo "<h1>No results :,(</h1>";
    echo "<p>Try different filters, or reset all filters to keep browsing artworks.</p>";
    echo "</div>";
}


 require('footer.php');

?>
