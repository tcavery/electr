<?php
    // configuration
    require("../includes/config.php");
    
    
    // if user reached page via GET
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        redirect("index.php");
    }
    // if user reached page via POST
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if(!isset($_POST["election"]))
        {
            http_response_code(400);
        }
        
        // retrieve election
        $query_template = "SELECT * from elections WHERE hash = :hash";
        $params = array('hash' => $_POST["election"]);
        $elections = exec_query($query_template, $params);
        
        // check election was found
        if (count($elections) < 1)
        {
            apologize("Election was not found.");
        }
        
        if ($elections[0]["user_id"] != $_SESSION["id"])
        {
            apologize("You are not the administrator of that election.");
        }
        
        // update database entry for specified election to closed
        $query_template = "UPDATE elections SET open = FALSE WHERE hash = :hash";
        $params = array('hash' => $_POST["election"]);
        $success = exec_query($query_template, $params);
        
        if(!$success)
        {
            apologize("The election could not be closed");
        }
        
        render("close_done.php", ["title" => "Election closed", "hash" => $_POST["election"]]);
    }
    
?>