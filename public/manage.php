<?php
    // configuration
    require("../includes/config.php");
    
    
    // if user reached page via GET
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // get user id
        $id = $_SESSION["id"];
        
        // look up elections owned by the current user
        $query_template = "SELECT * FROM elections WHERE user_id = :user_id";
        $params = array('user_id' => $id);
        $elections = exec_query($query_template, $params);
        
        if ($elections == 'FAIL' || count($elections) < 1)
        {
            apologize("You have not created any elections yet.");
        }
        

        // prepare parameters for election management page
        $num_elections = count($elections);
        
        $title_array = [];
        $anon_array = [];
        $open_array = [];
        $has_end_date_array = [];
        $end_date_array = [];
        $num_votes_array = [];
        $voting_link_array = [];
        $results_link_array = [];
        $hash_array = [];
        for ($i = 0; $i < $num_elections; $i++)
        {
            $title_array[$i] = $elections[$i]["title"];
            $anon_array[$i] = $elections[$i]["anonymous"];
            $open_array[$i] = is_open($elections[$i]);
            $has_end_date_array[$i] = $elections[$i]["has_end_date"];
            $end_date_array[$i] = $elections[$i]["end_date"];
            $num_votes_array[$i] = $elections[$i]["num_votes"];
            $voting_link_array[$i] = "http://localhost/~tom/electr/public/vote.php?election=" . $elections[$i]["hash"];
            $results_link_array[$i] = "http://localhost/~tom/electr/public/results.php?election=" . $elections[$i]["hash"];
            $hash_array[$i] = $elections[$i]["hash"];
        }
        
        render("manage_display.php", ["title" => "Your Elections",
                                      "num_elections" => $num_elections,
                                      "title_array" => $title_array,
                                      "anon_array" => $anon_array,
                                      "open_array" => $open_array,
                                      "has_end_date_array" => $has_end_date_array,
                                      "end_date_array" => $end_date_array,
                                      "num_votes_array" => $num_votes_array,
                                      "voting_link_array" => $voting_link_array,
                                      "results_link_array" => $results_link_array,
                                      "hash_array" => $hash_array
                                      ]);
    }
?>