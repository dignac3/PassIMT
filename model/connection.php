<?php

function getConnection()
{
    $mysqli = new mysqli("localhost", "user", "user", "password_manager") or die(mysqli_error());
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    return $mysqli;
}
?>