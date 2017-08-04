<?php
    // configuration
    require("../includes/config.php");
    
    
    // if user reached page via GET
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // retrieve election
        $query_template = "SELECT * FROM elections WHERE hash = :hash";
        $params = array('hash' => $_GET["election"]);
        $rows = exec_query($query_template, $params);
        
        if ($rows == 'FAIL' || count($rows) != 1)
        {
            apologize("Voting url is invalid.");
        }
        
        // store election id for adding vote to database
        $election = $rows[0];
        $_SESSION["vote_election"] = $election;
        
        // check voting is open
        if (is_open($election) != TRUE)
        {
            apologize("That election is no longer open.");
        }
        
        // generate voting form
        $candidate_names = explode(";", $election["candidate_names"]);
        $num_candidates = $election["num_candidates"];
        $election_title = $election["title"];
        
        render("vote_form.php", ["title" => "Vote",
                                 "candidate_names" => $candidate_names,
                                 "num_candidates" => $num_candidates,
                                 "election_title" => $election_title]);
    }
    // if user reached page via POST
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate input
        if (empty($_POST["voter_name"]))
        {
            apologize("You must supply your name.");
        }
        if (strpos($_POST["voter_name"], ';') != FALSE)
        {
            apologize("Names may not include semicolons (;).");
        }

        if (!isset($_POST["candidate"]))
        {
            apologize("You must choose a candidate.");
        }
        
        // find how many existing votes for this election
        $election = $_SESSION["vote_election"];
        $vote_number = $election["num_votes"];
        
        // increment votes for the election
        $query_template = "UPDATE elections SET num_votes = num_votes + 1 WHERE id = :id";
        $params = array('id' => $election['id']);
        exec_query($query_template, $params);

        // add name to list of voters for the election
        $query_template = "UPDATE elections SET voter_names = CONCAT(voter_names, :voter_name) WHERE id = :id";
        $params = array('voter_name' => $_POST["voter_name"] . ";", 'id' => $election["id"]);
        exec_query($query_template, $params);

        // record vote details
        $query_template = "INSERT INTO votes (election_id, voter_number, candidate_number) VALUES(:election_id,:voter_number,:candidate_number)";
        $params = array('election_id' => $election["id"], 'voter_number' => $vote_number, 'candidate_number' => $_POST["candidate"]);
        exec_query($query_template, $params);
        
        // display confirmation page
        unset($_SESSION["vote_election"]);
        render("vote_done.php", ["title" => "Vote"]);
    }
    

?>