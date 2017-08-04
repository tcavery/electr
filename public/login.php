<?php

    // configuration
    require("../includes/config.php"); 

    // if user reached page via GET
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("login_form.php", ["title" => "Log In"]);
    }

    // else if user reached page via POST
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["username"]))
        {
            apologize("You must provide a username.");
        }
        else if (empty($_POST["password"]))
        {
            apologize("You must provide your password.");
        }

        // query database for user
        $query_template = "SELECT * FROM users WHERE username = :username";
        $params = array('username' => $_POST["username"]);
        $rows = exec_query($query_template, $params);

        // if we found user, check password
        if ($rows != 'FAIL' && count($rows) == 1)
        {
            $row = $rows[0];

            // compare hash of user's input against hash that's in database
            if (password_verify($_POST["password"], $row["hash"]))
            {
                // login and go to welcome page
                $_SESSION["id"] = $row["id"];

                redirect("index.php");
            }
        }

        // else apologize
        apologize("Invalid username and/or password.");
    }

?>
