<!-- main page -->
 <?php
require('../../private/initialize.php');
require('header.php');

 if(isset($_SESSION['username'])) {
    // get set filters and make them set (jquery?)
    }

    // get list of mediums from db 
    $mediums_array = getDbColumn('medium', 'MetObjects');

    //get secondary filters from db
    $artists_array = getDbColumn('artist_id', 'MetObjects'); 
    $artists_array[0] = "select artist"; 

    $department_array = getDbColumn('dimensions', 'MetObjects');
    $department_array[0] = "select department"; 

    $city_array = getDbColumn('city', 'MetObjects');
    $city_array[0] = "select city";

    $state_array = getDbColumn('state', 'MetObjects');
    $state_array[0] = "select state"; 

    $country_array = getDbColumn('country', 'MetObjects');
    $country_array[0] = "select country"; 

    $accession_year_array = getDbColumn('accession_year', 'MetObjects');
    $accession_year_array[0] = "select accession year";

    $culture_array = getDbColumn('culture', 'MetObjects');
    $culture_array[0] = "select culture"; 



    if(is_post_request()){ //if filters have been submitted
        //save filters in session
        $_SESSION['mediums_selected'] = $_POST['medium'];
        // $_SESSION['artist_selected'] = $_POST['artist'];
        // $_SESSION['department_selected'] = $_POST['department'];
        // $_SESSION['city_selected'] = $_POST['city'];
        // $_SESSION['state_selected'] = $_POST['state'];
        // $_SESSION['country_selected'] = $_POST['country'];
        // $_SESSION['accession_year_selected'] = $_POST['accession_year'];
        // $_SESSION['culture_selected'] = $_POST['culture'];

        $medium = $_POST['medium']; // Get user input

        // Prepare statement
        $stmt = $db->prepare("SELECT title, artist_id, medium, dimensions FROM MetObjects WHERE medium = ?");
        $stmt->bind_param("s", $medium); // Bind as a string

        // Execute and fetch results
        $stmt->execute();
        $result = $stmt->get_result();

        $artworks = []; // initialize an empty array

        while ($row = $result->fetch_assoc()) { //save details as an associative array
            $artworks[] = [
            'title' => $row['title'], 
            'artist_id' => $row['artist_id'], 
            'medium' => $row['medium'], 
            'dimensions' => $row['dimensions']
    ];
}

    }


// ACTUAL UI

echo "<h1>i'm interested in...</h1>";

//create tags for each medium
echo "<h3>medium</h3>";

echo "<form action='browse.php' method='post'>";
foreach($mediums_array as $m){
    create_tag($m);
}
echo "</form>";

echo "<h4>artwork details</h4>";

echo "<form action='browse.php' method='post'>";
echo create_select_input("artist", $artists_array);
echo create_select_input("department", $department_array);
echo create_select_input("city", $city_array);
echo create_select_input("state", $state_array);
echo create_select_input("country", $country_array);
echo create_select_input("accession-year", $accession_year_array);
echo create_select_input("culture", $culture_array);
echo "</form>";

// need to use jquery to see when clicked on, save in session, do something, initiate filter by

// $_SESSION['username'] = $_POST['username'];

// $_SESSION['mediums_selected'][] = $_POST['mediums_selected'];

function create_object_card($object_information){
    $id = $object_information['object_id'];
    $title = $object_information['object_title'];
    $artist_id = $object_information['artist_id'];
    $medium = $object_information['medium'];
    $dimensions = $object_information['dimensions'];
    $image = $object_information['image'];

    echo "<div class='artwork-box'>";
    echo "<div class='v-box art-container' onclick='location.href='object-details.php?object_id=' . urlencode($id)';'>";

    echo "<div class='img-container'>";
    echo "<img class='browse-image' src='$image'>";
    echo "</div>";
    
    echo "<h3>$title</h3>";
    echo "<p>$artist_id</p>";
    echo "<p>$medium".", ("."$dimensions</p>".")";

    echo "</div>";
}

$test_artwork_info = ['object_id' => 1, 'object_title' => "It's Art", 'artist_id' => 'Boberta Bobbert', 'medium' => 'code on computer screen', 'dimensions' => '1280x920', 'image' => 'https://media.timeout.com/images/106006274/1920/1440/image.webp'];

create_object_card($test_artwork_info);

echo"

<div class='artwork-box'>

<div class='v-box art-container' onclick='location.href='artwork.php';'>

    <div class='img-container'>
    <img class='browse-image' src='https://media.timeout.com/images/106006274/1920/1440/image.webp'>
    </div>
    
    <h3>Artwork Name</h3>
    <p>Artist</p>
    <p>Medium</p>

</div>

<div class='v-box art-container' onclick='location.href='artwork.php';'>

    <div class='img-container'>
    <img class='browse-image' src='https://media.timeout.com/images/106006274/1920/1440/image.webp'>
    </div>
    
    <h3>Artwork Name</h3>
    <p>Artist</p>
    <p>Medium</p>

</div>

<div class='v-box art-container' onclick='location.href='artwork.php';'>

    <div class='img-container'>
    <img class='browse-image' src='https://media.timeout.com/images/106006274/1920/1440/image.webp'>
    </div>
    
    <h3>Artwork Name</h3>
    <p>Artist</p>
    <p>Medium</p>

</div>

</div>



";








 require('footer.php');

?>
