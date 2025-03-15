<!-- main page -->
 <?php
 require('public/pages/header.php');




// ACTUAL UI

echo "<h1>i'm interested in...</h1>";

echo "<div class='button'>Brass</div>";
echo "<div class='button'>Painting</div>";
echo "<div class='button'>Sculpture</div>";
echo "<div class='button'>Brass</div>";
echo "<div class='button'>Painting</div>";
echo "<div class='button'>Sculpture</div>";

echo "<br>";

echo " <select id='medium' class='button'>
        <option value='null'>Set Medium</option>
        <option value='painting'>Painting</option>
        <option value='drawing'>Drawing</option>
        <option value='sculpture'>Sculpture</option>
        </select>

        <select id='artist' class='button'>
        <option value='null'>Set Artist</option>
        <option value='1'>Bob Jones</option>
        <option value='drawing'>Jones Bob</option>
        <option value='sculpture'>Bones Job</option>
        <option value='sculpture'>Job Bones</option>
        </select>
";



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








 require('public/pages/footer.php');

?>
