<?php

// check that there is no duplicate username (sign-up.php)
function checkUsername($username){
    global $db;
    $username_stmt = $db->prepare("SELECT COUNT(*) as count FROM members WHERE username = ?");
      $username_stmt->bind_param("s", $username);

      // execute prepared statement and get result
      $username_stmt->execute();
      $username_result = $username_stmt->get_result();
      $username_result_row = $username_result->fetch_assoc();

      return $username_result_row;
}

function addUser($username, $hashed_password, $email, $first_name, $last_name){
    global $db;
    $insert_stmt = $db->prepare("INSERT INTO members (username, password_hash, email, first_name, last_name) VALUES (?, ?, ?, ?, ?)");
        
    // bind parameters
    $insert_stmt->bind_param('sssss', $username, $hashed_password, $email, $first_name, $last_name);
        
    // execute statement and handle errors
    if ($insert_stmt->execute()) {
        $insert_stmt->close();
        $db->close();
        return true;
}
    return false;
}

//update individual column of user info (account.php)
function updateUserInfo($username, $column, $newInfo){
    global $db;

    //whitelisting columns
    $allowed_columns = ['email', 'password_hash', 'first_name', 'last_name']; // Add more as needed
    if (!in_array($column, $allowed_columns)) {
        return false; // Invalid column, do nothing
    }

    // update values accordingly
    $query = "UPDATE members SET $column = ? WHERE username = ?";
    $stmt = $db->prepare($query);

    if (!$stmt) {
        return false; // Handle error if prepare fails
    }

    // Bind parameters
    $stmt->bind_param('ss', $newInfo, $username);

    // Execute statement and handle errors
    $result = $stmt->execute();
    $stmt->close();
    
    return $result;
}


// get specified user info (for filling in account details in account.php page)
function getUserInfo($username, $column){
    global $db;
    if ($column == 'password' || $column == 'password_confirm') {
        $column = 'password_hash';
    }
    $query_str = "SELECT $column FROM members WHERE username = '$username'";
    $result = $db->query($query_str); 

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            return $row[$column];
        }
    }
    return null;
}


//get column value options from database (browse.php)
    function getDbColumn($title, $table){
        global $db;
        $array = []; //default option when not selecting by order number
        $query_str = "SELECT DISTINCT $title FROM $table ORDER BY $title ASC";
        $result = $db->query($query_str); 

        while ($row = $result->fetch_array()) {   
            array_push($array, $row[$title]);
        };

        return $array;
    }

    //get object information from database based on input id (object-details.php)
    function getObjectInfo($id){
        global $db;
        $array = []; //default option when not selecting by order number

        // $query_str = "SELECT 
        //             metobjects.object_id, title, medium, dimensions, department, object_name, city, state, country, culture 
        //             FROM metobjects 
        //             WHERE object_id = $id";

        $query_str = "SELECT 
        metobjects.object_id, 
        metobjects.title, 
        metobjects.medium, 
        metobjects.dimensions, 
        metobjects.department, 
        metobjects.city, 
        metobjects.state, 
        metobjects.country, 
        metobjects.culture, 
        metobjects.object_name, 
        artists.artist_display_name
        FROM metobjects
        LEFT JOIN artists ON metobjects.object_id = artists.artist_id 
        WHERE object_id = $id;";

        // $query_str = "SELECT object_id, title, artist_id, medium, dimensions, department, object_name, city, state, country, accession_year, culture, image_src FROM MetObjects WHERE object_id = $id";
        
        $result = $db->query($query_str); 

        while ($row = $result->fetch_assoc()) {   
            array_push($array, $row);
        };

        return $array;
    }

       //get artist info for the object (object-details.php)
       function getArtistInfo($id){
        global $db;
        $array = []; //default option when not selecting by order number
        $temp_str = "";
        $query_str = "SELECT 
                    artist_role, artist_display_name
                    FROM artists 
                    WHERE artist_id = $id";
        $result = $db->query($query_str); 

        while ($row = $result->fetch_assoc()) {   

            // remove the seperators for when there's multiple artists
            $roles = (explode('|', $row['artist_role']));
            $names = (explode('|', $row['artist_display_name']));

            // combine them in the new order
            for($i = 0; $i < count($roles); $i++){
                $temp_str .= $roles[$i].": ".$names[$i]."<br />";
            }
            array_push($array, $temp_str);

        };

        return $array;
    }

    // get list of favourite artworks
    function getFaves($username){
        global $db;
        $query_str = "SELECT object_id FROM member_favourites WHERE username = '$username'";
        $result = $db->query($query_str); 

        $faves = [];
            
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $faves[] = $row['object_id'];
            }
        }
        return $faves;
    }

      //insert new fave to db
      function insertFave($username, $object_id){
        global $db;
        $query_str = "INSERT INTO member_favourites (username, object_id) VALUES ('$username', $object_id)";
        if ($db->query($query_str)){
            return true;    //success
        }
        else{
            return false;   //failure
        }
    }

    // remove selected fave from db
    function removeFave($username, $object_id){
        global $db;
        $query_str = "DELETE FROM member_favourites WHERE username = '$username' AND object_id = $object_id";
        if ($db->query($query_str)){
            return true;    //success
        }
        else{
            return false;   //failure
        }
    }

    //get artworks from database based on selected mediums (browse.php)
    function getFaveArtworks($username){
        global $db;

        $query_str = "SELECT 
                    metobjects.object_id, 
                    metobjects.object_name, 
                    metobjects.title, 
                    metobjects.medium, 
                    metobjects.dimensions, 
                    artists.artist_display_name
                FROM metobjects
                LEFT JOIN artists ON metobjects.object_id = artists.artist_id
        WHERE object_id IN (SELECT object_id FROM Member_Favourites WHERE username = '$username');";


        // $query_str = "SELECT object_id, title, artist_id, medium, dimensions, image_src 
        // FROM MetObjects 
        // WHERE object_id IN (SELECT object_id FROM Member_Favourites WHERE username = '$username');";

        $result = $db->query($query_str); 

        $artworks = [];
            
        while ($row = $result->fetch_assoc()) { //save details as an associative array
            $artworks[] = [
            'object_id' => $row['object_id'], 
            'object_name' => $row['object_name'], 
            'title' => $row['title'], 
            'artist_display_name' => $row['artist_display_name'], 
            'medium' => $row['medium'], 
            'dimensions' => $row['dimensions']
        ];}
        return $artworks;
    }


    
    function getArtworksFiltered($mediums, $filters) {
        global $db;
    
        $query = "SELECT 
                    metobjects.object_id, 
                    metobjects.title, 
                    metobjects.medium, 
                    metobjects.dimensions, 
                    artists.artist_display_name
                FROM metobjects
                LEFT JOIN artists ON metobjects.object_id = artists.artist_id
                WHERE 1=1";

        // $query = "SELECT object_id, title, artist_display_name, medium, dimensions, image_src FROM MetObjects WHERE 1=1";

    
        $params = [];
        $types = "";
    
        // Medium filter
        if (!empty($mediums)) {
            $placeholders = implode(",", array_fill(0, count($mediums), "?"));
            $query .= " AND medium IN ($placeholders)";
            $params = array_merge($params, $mediums);
            $types .= str_repeat("s", count($mediums));
        }
    
        // Secondary filters
        foreach ($filters as $column => $value) {
            if (!empty($value)) {
                $query .= " AND $column = ?";
                $params[] = $value;
                $types .= "s";
            }
        }

        //select all if no selections
        if (empty($mediums) && empty(array_filter($filters))) {
            // $query = "SELECT object_id, title, artist_display_name, medium, dimensions FROM metobjects";
            
            $query = "SELECT 
                    metobjects.object_id, 
                    metobjects.title, 
                    metobjects.medium, 
                    metobjects.dimensions, 
                    artists.artist_display_name
                FROM metobjects
                LEFT JOIN artists ON metobjects.object_id = artists.artist_id;";

            $params = []; // No parameters needed
            $types = "";
        }

        echo $query;
    
        $stmt = $db->prepare($query);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
    
        $artworks = [];
        // while ($row = $result->fetch_assoc()) {
        //     $artworks[] = $row;
        // }

        while ($row = $result->fetch_assoc()) { //save details as an associative array
            $artworks[] = [
            'object_id' => $row['object_id'], 
            'title' => $row['title'], 
            'artist_display_name' => $row['artist_display_name'], 
            'medium' => $row['medium'], 
            'dimensions' => $row['dimensions']
        ];}
    
        return $artworks;
    }
    
    

    // //TODO: make this work
    // //get artworks from database based on selected mediums AND SECONDARY FILTERS (browse.php)
    // function getArtworksFiltered($selected_mediums, $secondary_filters){
    //     global $db;
    
    //     //TODO: make this work

    //     // $query_filter_string = "";

    //     // if(isset($secondary_filters['artist_id'])){
    //     //     $query_filter_string .= " AND artist_id = " . $secondary_filters['artist'];
    //     // }   
    //     // if(isset($secondary_filters['department'])){
    //     //     $query_filter_string .= "AND department = " . $secondary_filters['department'];
    //     // }   
    //     // if(isset($secondary_filters['city'])){
    //     //     $query_filter_string .= "AND city = " . $secondary_filters['city'];
    //     // }  
    //     // if(isset($secondary_filters['state'])){
    //     //     $query_filter_string .= "AND s†ate = " . $secondary_filters['s†ate'];
    //     // }  
    //     // if(isset($secondary_filters['country'])){
    //     //     $query_filter_string .= "AND country = " . $secondary_filters['country'];
    //     // } 
    //     // if(isset($secondary_filters['accession_year'])){
    //     //     $query_filter_string .= "accession_year = " . $secondary_filters['accession_year'];
    //     // } 
    //     // if(isset($secondary_filters['culture'])){
    //     //     $query_filter_string .= "culture = " . $secondary_filters['culture'];
    //     // } 

    //     // // create '?' placeholders for each selected medium
    //     // $placeholders = implode(',', array_fill(0, count($selected_mediums), '?')); 

    //     // $query = "SELECT object_id, title, artist_id, medium, dimensions, image_src 
    //     //         FROM MetObjects 
    //     //         WHERE medium IN ($placeholders) AND $query_filter_string;";

    //     // $stmt = $db->prepare($query);
    //     // $types = str_repeat('s', count($selected_mediums)); // 'sss...' for multiple strings
    //     // $stmt->bind_param($types, ...$selected_mediums);

    //     // Create '?' placeholders for each selected medium
    // $placeholders = implode(',', array_fill(0, count($selected_mediums), '?'));

    // // Base SQL Query
    // $sql = "SELECT object_id, title, artist_id, medium, dimensions, image_src FROM MetObjects WHERE medium IN ($placeholders)";

    // // Handle secondary filters
    // $params = $selected_mediums;
    // if (!empty($secondary_filters)) {
    //     foreach ($secondary_filters as $key => $value) {
    //         $sql .= " AND $key = ?";
    //         $params[] = $value;
    //     }
    // }

    // // Prepare and execute query
    // $stmt = $db->prepare($sql);
    // $stmt->bind_param(str_repeat("s", count($params)), ...$params); // 's' for each parameter
    // $stmt->execute();
    // $result = $stmt->get_result();

    //     // $stmt->execute();
    //     // $result = $stmt->get_result();

    //     $artworks = [];
            
    //     while ($row = $result->fetch_assoc()) { //save details as an associative array
    //         $artworks[] = [
    //         'object_id' => $row['object_id'], 
    //         'title' => $row['title'], 
    //         'artist_id' => $row['artist_id'], 
    //         'medium' => $row['medium'], 
    //         'dimensions' => $row['dimensions'],
    //         'image_src' => $row['image_src']
    //     ];}
    //     return $artworks;
    // }




    ?>