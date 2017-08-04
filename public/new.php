<?php

    // configuration
    require("../includes/config.php"); 

    // if user reached page via GET
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render form 1
        unset($_SESSION["new_election_options"]);
        render("new_form1.php", ["title" => "New Election"]);
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_SESSION["new_election_options"]))
    {
        // validate input
        if (empty($_POST["title"]))
        {
            apologize("You must supply a title.");
        }
        
        if (empty($_POST["num_candidates"]))
        {
            apologize("You must supply the number of candidates.");
        }
        
        if (!preg_match("/^\d+$/", $_POST["num_candidates"]))
        {
            apologize("The number of candidates must be a positive whole number.");
        }
        
        $has_end_date = isset($_POST["has_end_date"]);
        
        if ($has_end_date)
        {
            
            if (empty($_POST["end_date"]))
            {
                apologize("You must supply an end date.");
            }
            
            if (empty($_POST["end_time"]))
            {
                apologize("You must supply an end time.");
            }
            
            $end_datetime = DateTime::createFromFormat("d/m/Y H:i:s", $_POST["end_date"] . " " . $_POST["end_time"] . ":00");
            
            if($end_datetime == FALSE)
            {
                apologize("You must supply a valid end date and time, in the stated formats.");
            }
            
            $current_datetime = new DateTime();
            if($current_datetime >= $end_datetime)
            {
                apologize("The end date must be in the future.");
            }
        }
        else
        {
            $end_datetime = NULL;
        }
        
        // store inputted data in session
        $_SESSION["new_election_options"] = [ "title" => $_POST["title"],
                                              "num_candidates" => $_POST["num_candidates"],
                                              "anon" => isset($_POST["anon"]),
                                              "has_end_date" => $has_end_date,
                                              "end_datetime" => $end_datetime,
            ];
        
        
        // render form 2
        render("new_form2.php", ["title" => "New Election", "num_candidates" => $_POST["num_candidates"]]);
    }
    
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $options = $_SESSION["new_election_options"];

        // build list of candidates
        $candidate_list = "";
        for ($i = 1; $i <= $options["num_candidates"]; $i ++)
        {
            if (strpos($_POST["candidate" . $i], ';') != FALSE)
            {
                apologize("Candidate names may not include semicolons (;).");
            }
            else
            {
                $candidate_list = $candidate_list . $_POST["candidate" . $i] . ";";
            }
        }
        
        // generate unique identifier; will be used in voting and results urls
        $hash = hash('ripemd160', $_SESSION["id"] . time());
        
        // save election in database
        $query_template = "INSERT IGNORE INTO elections (user_id, hash, title, num_candidates, candidate_names, anonymous, has_end_date, end_date) VALUES(:user_id, :hash, :title, :num_candidates, :candidate_names, :anonymous, :has_end_date, :end_date)";
        $params = array('user_id' => $_SESSION["id"],
                        'hash' => $hash,
                        'title' => $options["title"],
                        'num_candidates' => $options["num_candidates"],
                        'candidate_names' => $candidate_list,
                        'anonymous' => $options["anon"],
                        'has_end_date' => $options["has_end_date"],
                        'end_date' => ($options["has_end_date"] ? $options["end_datetime"]->format('Y-m-d H:i:s') : NULL)
                        );

        $result = exec_query($query_template, $params);
        
        if($result != 'FAIL')
        {
            // go to confirmation page
            unset($_SESSION["new_election_options"]);
            render("new_done.php", ["title" => "New Election", "hash" => $hash]);
        }
        else
        {
            apologize("Failed to create new election.");
        }
    }


?>