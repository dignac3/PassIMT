<?php

function getConnection()
{
    $mysqli = new mysqli("localhost", "user", "user", "password_manager");
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    return $mysqli;
}
?>