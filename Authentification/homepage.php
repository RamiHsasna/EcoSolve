<?php
session_start();
include '../config/database.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
</head>

<body>
    <div style="text-align:center; padding:15%;">
        <p style="font-size:50px; font-weight:bold;">
            Hello <?php
                    if (isset($_SESSION['username'])) {
                        echo $_SESSION['username'];
                    }
                    ?> :)
        </p>
        <a href="logout.php">Logout</a>
    </div>
</body>

</html>