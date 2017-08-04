<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["username"]))
        {
            apologize("You must supply a username.");
        }
        elseif (empty($_POST["password"]))
        {
            apologize("You must supply a password.");
        }
        elseif ($_POST["password"] != $_POST["confirmation"])
        {
            apologize("Passwords did not match.");
        }

        // add user to database
        $query_template = 'INSERT INTO users (username, hash) VALUES(:username, :hash)';
        $params = array('username' => $_POST["username"], 'hash' => password_hash($_POST["password"], PASSWORD_DEFAULT));
        $result = exec_query($query_template, $params);

        if ($result != 'FAIL')
         {
            // get new user's id
             $query_template = 'SELECT * FROM users WHERE username = :username';
             $params = array('username' => $_POST["username"]);
             $rows = exec_query($query_template, $params);
             $id = $rows[0]['id'];
             

             // log in user
             $_SESSION["id"] = $id;

             // redirect to index
             redirect("index.php");
         }
         else
         {
            apologize("That username is already in use.");
         }

    }

?>

