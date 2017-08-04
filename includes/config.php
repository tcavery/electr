<?php

    // display errors, warnings, and notices
    ini_set("display_errors", true);
    error_reporting(E_ALL);

    // requirements
    require("helpers.php");

    // enable sessions
    session_start();

    // require authentication for all pages except /login.php, /logout.php, and /register.php
    if (!in_array($_SERVER["PHP_SELF"], ["/~tom/electr/public/login.php", "/~tom/electr/public/logout.php", "/~tom/electr/public/register.php", "/~tom/electr/public/vote.php", "/~tom/electr/public/results.php"]))
    {
        if (empty($_SESSION["id"]))
        {
            redirect("login.php");
        }
    }


?>
