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

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    
    <script src="../../private/js/filter-medium.js" type="text/javascript"></script>
    <script src="../../private/js/filter-secondary.js" type="text/javascript"></script>
    <script src="../../private/js/reset-filters.js" type="text/javascript"></script>

    <?php if(isset($_SESSION['username'])) {  //if they are signed in, show fave button
      echo "<script src='../../private/js/favourite.js' type='text/javascript'></script>";}
    ?>
    
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
      echo "<a class='circle-button' href='faves.php'>faves</a>";
      echo "<a class='circle-button' href='account.php'>account</a>";
      echo "<a class='circle-button' href='log-out.php'>log out</a>";
    }
    ?>

</div>
  </nav>

  <div class="inner-container centered-box">


<!-- header end -->