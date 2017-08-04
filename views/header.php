<!DOCTYPE html>

<html>

    <head>

        <!-- http://getbootstrap.com/ -->
        <link href="css/bootstrap.min.css" rel="stylesheet"/>

        <link href="css/styles.css" rel="stylesheet"/>

        <?php if (isset($title)): ?>
            <title>Electr: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>Electr</title>
        <?php endif ?>

        <!-- https://jquery.com/ -->
        <script src="js/jquery-1.11.3.min.js"></script>

        <!-- http://getbootstrap.com/ -->
        <script src="js/bootstrap.min.js"></script>

        <script src="js/scripts.js"></script>

    </head>

    <body>

        <div class="container">

            <div id="top">
                <div>
                    <a href="/~tom/electr/public/index.php"><img src="img/logo.png" alt="Electr"/></a>
                </div>
                    <ul class="nav nav-pills">
                        <li><a href="new.php">New Election</a></li>
                        <li><a href="manage.php">My Elections</a></li>
                        <li><a href="logout.php">Log Out</a></li>
                    </ul>
            </div>

            <div id="middle">
