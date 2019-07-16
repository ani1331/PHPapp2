<?php

function connection($dbName){

    $connect = mysqli_connect('localhost', 'root', '1234', $dbName);
    if ($connect == false) {
        die("ERROR: Can not connect to $dbName \n" . mysqli_connect_error() . "");
    }
    $val = mysqli_query($connect, "USE " . $dbName . ";");
    if ($val == false) {
        die("Database $dbName don't exist" . mysqli_error($connect) . "\n");
    }

    return $connect;
}