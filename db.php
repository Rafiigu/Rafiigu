<?php

function get_connection()
{
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "db-reminder";

    $connection = mysqli_connect($hostname, $username, $password, $database);

    if (mysqli_connect_errno()) {
        die("Error: " . mysqli_connect_error());
    }

    return $connection;
}
