<?php

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
        $query_str = "SELECT title, artist_id, medium, dimensions, department, object_name, city, state, country, accession_year, culture FROM MetObjects WHERE object_id = $id";
        $result = $db->query($query_str); 

        while ($row = $result->fetch_assoc()) {   
            array_push($array, $row);
        };

        return $array;
    }

      //insert new fave to db
      function insertFave($username, $object_id){
        global $db;
        $query_str = "INSERT INTO Member_Favourites (username, object_id) VALUES ('$username', $object_id)";
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
        $query_str = "DELETE FROM Member_Favourites WHERE username = '$username' AND object_id = $object_id";
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

        $query_str = "SELECT object_id, title, artist_id, medium, dimensions, image_src 
        FROM MetObjects 
        WHERE object_id IN (SELECT object_id FROM Member_Favourites WHERE username = '$username');";

        $result = $db->query($query_str); 

        $artworks = [];
            
        while ($row = $result->fetch_assoc()) { //save details as an associative array
            $artworks[] = [
            'object_id' => $row['object_id'], 
            'title' => $row['title'], 
            'artist_id' => $row['artist_id'], 
            'medium' => $row['medium'], 
            'dimensions' => $row['dimensions'],
            'image_src' => $row['image_src']
        ];}
        return $artworks;
    }


    //get artworks from database based on selected mediums (browse.php)
    function getArtworks($selected_mediums){
        global $db;
    
        // create '?' placeholders for each selected medium
        $placeholders = implode(',', array_fill(0, count($selected_mediums), '?')); 

        $query = "SELECT object_id, title, artist_id, medium, dimensions, image_src 
                FROM MetObjects 
                WHERE medium IN ($placeholders)";

        $stmt = $db->prepare($query);
        $types = str_repeat('s', count($selected_mediums)); // 'sss...' for multiple strings
        $stmt->bind_param($types, ...$selected_mediums);

        $stmt->execute();
        $result = $stmt->get_result();

        $artworks = [];
            
        while ($row = $result->fetch_assoc()) { //save details as an associative array
            $artworks[] = [
            'object_id' => $row['object_id'], 
            'title' => $row['title'], 
            'artist_id' => $row['artist_id'], 
            'medium' => $row['medium'], 
            'dimensions' => $row['dimensions'],
            'image_src' => $row['image_src']
        ];}
        return $artworks;
    }

    // // get artworks from database based on selected mediums AND SECONDARY FILTERS (used in get-artworks.php)
    // function getArtworksFiltered($mediums, $filters) {
    //     global $db;
    
    //     $query = "SELECT object_id, title, artist_id, medium, dimensions, image_src 
    //               FROM MetObjects 
    //               WHERE 1=1"; // Ensures the query is always valid
    
    //     $params = [];
    //     $types = "";
    
    //     // Apply medium filter from session
    //     if (!empty($mediums)) {
    //         $placeholders = implode(",", array_fill(0, count($mediums), "?"));
    //         $query .= " AND medium IN ($placeholders)";
    //         $params = array_merge($params, $mediums);
    //         $types .= str_repeat("s", count($mediums));
    //     }
    
    //     // Apply secondary filters dynamically
    //     foreach ($filters as $column => $value) {
    //         if (!empty($value) && $value !== "*") { 
    //             // If a filter has a value, apply exact match
    //             $query .= " AND $column = ?";
    //             $params[] = $value;
    //             $types .= "s";
    //         }
    //     }
    
    //     // Debugging: Print the final SQL query (before executing)
    //     echo "Final Query: " . $query . "<br>";
    //     echo "Parameters: " . json_encode($params) . "<br>";
    
    //     // Prepare and execute query
    //     $stmt = $db->prepare($query);
    //     if (!empty($params)) {
    //         $stmt->bind_param($types, ...$params);
    //     }
    
    //     $stmt->execute();
    //     $result = $stmt->get_result();
    
    //     $artworks = [];
    //     while ($row = $result->fetch_assoc()) {
    //         $artworks[] = $row;
    //     }
    
    //     return $artworks;
    // }
    
    function getArtworksFiltered($mediums, $filters) {
        global $db;
    
        $query = "SELECT object_id, title, artist_id, medium, dimensions, image_src FROM MetObjects WHERE 1=1";
    
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

        if (empty($mediums) && empty(array_filter($filters))) {
            $query = "SELECT object_id, title, artist_id, medium, dimensions, image_src FROM MetObjects";
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
            'artist_id' => $row['artist_id'], 
            'medium' => $row['medium'], 
            'dimensions' => $row['dimensions'],
            'image_src' => $row['image_src']
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