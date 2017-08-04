<?php

    // configuration
    require("../includes/config.php"); 
    
    // get username
    $query_template = "SELECT username FROM users WHERE id = :id";
    $params = array('id' => $_SESSION['id']);
    $usernames = exec_query($query_template, $params);

    // display greeting
    $username = $usernames[0]["username"];
    render("home.php", ["title"=> "Welcome", "username" => $username]);

?>
