<?php


	/**
     * Apologizes to user with message.
     */
    function apologize($message)
    {
        render("apology.php", ["message" => $message]);
    }

    /**
     * Renders view, passing in values.
     */
	function render($view, $values = [])
	{
	    // if view exists, render it
	    if (file_exists("../views/{$view}"))
	    {
	        // extract variables into local scope
	        extract($values);

	        // render view (between header and footer)
	        require("../views/header.php");
	        require("../views/{$view}");
	        require("../views/footer.php");
	        exit;
	    }

	    // else err
	    else
	    {
	        trigger_error("Invalid view: {$view}", E_USER_ERROR);
	    }
	}

    /**
     * Redirects user to location, which can be a URL or
     * a relative path on the local host.
     *
     * http://stackoverflow.com/a/25643550/5156190
     *
     * Because this function outputs an HTTP header, it
     * must be called before caller outputs any HTML.
     */
    function redirect($location)
    {
        if (headers_sent($file, $line))
        {
            trigger_error("HTTP headers already sent at {$file}:{$line}", E_USER_ERROR);
        }
        header("Location: {$location}");
        exit;
    }

    function exec_query($query_template, $params = array())
    {
    	try {
    		$db = new PDO('mysql:dbname=electr;host=localhost', 'root', 'root');
        	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	        $stmt = $db->prepare($query_template);
	        $stmt->execute($params);
            $results = $stmt->fetchAll();

	        $db = null;

            return $results;
	        
    	}
    	catch (PDOException $e)
        {
    		return 'FAIL';
    	}
    	
    }


    /**
     * Logs out current user, if any.  Based on Example #1 at
     * http://us.php.net/manual/en/function.session-destroy.php.
     */
    function logout()
    {
        // unset any session variables
        $_SESSION = [];

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        session_destroy();
    }

    /**
     * checks whether the closing time for an election has passed.
     * and updates it's database entry if so. If the election is
     * configured to be closed manually, it just checks whether
     * it is currently open
    **/
    function is_open($election)
    {
        if (!$election["has_end_date"])
        {
            return $election["open"];
        }
        
        $end_datetime = DateTime::createFromFormat("Y-m-d H:i:s", $election["end_date"]);
        $current_datetime = new DateTime();
        
        if($current_datetime > $end_datetime)
        {
            $query_template = "UPDATE elections SET open = 0 WHERE id = :id";
            $params = array('id' => $election["id"]);
            exec_query($query_template, $params);
            return false;
        }
        else
        {
            $query_template = "UPDATE elections SET open = 1 WHERE id = :id";
            $params = array('id' => $election["id"]);
            exec_query($query_template, $params);
            return true;
        }
    }

?>