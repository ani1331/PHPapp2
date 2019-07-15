<?php
//$arr = ["import","export"];
function import()
{
    global $argv;
    $dbName = $argv[2];

    $connect = mysqli_connect('localhost', 'root', '1234');


    if ($connect == false) {
        die("ERROR: Couldn't connect to MYSQL" . mysqli_connect_error() . "\n");
    }

    if (isset($argv[3])) {
        $fileName = $argv[3];
        $file_ext = pathinfo($argv[3]);

        if ($file_ext['extension'] !== "sql") {
            die("ERROR: your file extension is wrong\n");
        }

        $file_query = file_get_contents($fileName);
        $val = mysqli_query($connect, "USE $argv[2];");
        if ($val !== false) {
            echo "Database $argv[2] already exists\n";
        } else {
            mysqli_query($connect, "CREATE DATABASE $dbName");
            mysqli_multi_query($connect, $file_query);
            echo "$dbName database created successfully\n";
        }
        mysqli_close($connect);
    } else {
        echo "You don't specified file name\n";
    }
}

import();
//if ($argv[1] === $arr[0]){
//    import();
//} elseif($argv[1] === $arr[1]) {
//    require('exportDB.php');
////    export($argv);
//}







