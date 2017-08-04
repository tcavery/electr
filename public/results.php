<?php
    // configuration
    require("../includes/config.php");
    
    
    // if user reached page via GET
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // retrieve election from hash
        $query_template ="SELECT * FROM elections WHERE hash = :hash";
        $params = array('hash' => $_GET["election"]);
        $elections = exec_query($query_template, $params);
        
        //check election exists
        if ($elections == 'FAIL' || count($elections) != 1)
        {
            apologize("Election url is invalid.");
        }
        
        $election = $elections[0];
        
        // extract list of candidates
        $candidate_names = explode(";", $election["candidate_names"]);
        $num_candidates = $election["num_candidates"];
        
        // extract list of voters
        $voter_names = explode(";", $election["voter_names"]);
        $num_votes = $election["num_votes"];
        
        
        // retrieve votes for this election
        $query_template = "SELECT candidate_number, voter_number FROM votes WHERE election_id = :election_id";
        $params = array('election_id' => $election["id"]);
        $votes = exec_query($query_template, $params);
        
        // construct vote matrix
        $vote_matrix = array_fill(0, $num_candidates, array_fill(0, $num_votes, 0));
        
        // insert votes into matrix
        foreach ($votes as $vote)
        {
            $vote_matrix[$vote["candidate_number"]][$vote["voter_number"]] = 1;
        }

        
        // calculate totals
        $vote_totals = [];
        for ($i = 0; $i < $num_candidates; $i++)
        {
            $vote_totals[$i] = array_sum($vote_matrix[$i]);
        }
        
        // find winner(s)
        $max_votes = 0;
        $winners = [];
        for($i = 0; $i < $num_candidates; $i++)
        {
            if ($vote_totals[$i] > $max_votes)
            {
                $winners = [$i];
                $max_votes = $vote_totals[$i];
            }
            else if ($vote_totals[$i] == $max_votes)
            {
                $winners[] = $i;
            }
        }
        
        // check if results should be displayed anonymously
        $anon = $election["anonymous"];
        
        // check if election is tied
        $tied = (count($winners) > 1);
        
        //check is voting is still open
        $open = is_open($election);
        
        // display results page
        render("results_display.php", ["title" => "Results for " . htmlspecialchars($election["title"]),
                                       "election_title" => $election["title"],
                                       "num_candidates" => $num_candidates,
                                       "candidate_names" => $candidate_names,
                                       "num_votes" => $num_votes, "voter_names" => $voter_names,
                                       "vote_totals" => $vote_totals, "vote_matrix" => $vote_matrix,
                                       "winners" => $winners, "tied" => $tied,
                                       "anon" => $anon,
                                       "open" => $open]);

        

        
    }
?>