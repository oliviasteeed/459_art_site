<!-- header start -->
 <?php
 require_once('../../private/initialize.php');
 ?>

<!doctype html>

<html lang="en">
  <head>
    <title>artexplore</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../css/layout.css">
  </head>

  <body>

  <div class="outer-container">

  <nav>
    <div class="nav-buttons">
    <a class="site-title" href='browse.php'>ARTEXPLORE</a>
    <a class="circle-button" href='browse.php'>browse</a>

    <?php
    if(!isset($_SESSION['username'])) {  //if they are not signed in
      echo "<a class='circle-button' href='sign-up.php'>sign up</a>";
      echo "<a class='circle-button' href='log-in.php'>log in</a>";
    } 
    else{ //if they are not signed in
      echo "<a class='circle-button' href='favourites.php'>faves</a>";
      echo "<a class='circle-button' href='log-out.php'>log out</a>";
    }
    ?>

</div>
  </nav>

  <div class="inner-container">


<!-- header end -->