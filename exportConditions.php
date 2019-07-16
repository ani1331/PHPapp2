<?php
require_once('functionality.php');
require_once('connection.php');


function structure_validation($argv,$connect){

    $dbName = $argv[2];
    $file_name = $argv[3];
    $sql = "SHOW DATABASES;";
    $db_names = mysqli_query($connect, $sql);
    if($argv[1] !== 'export' || $argv[1] !== 'import'){
        die("ERROR: Please write option export or import after file name.\n");
    }
    if (!in_array($dbName, $db_names )){
        die("ERROR: Database $dbName doesn't exist.");
    } elseif(preg_match('/[^A-Za-z0-9$_,]/', $dbName)){
        die('You have to specify database name only with A-Z , a-z , 0-9 , $ , _  characters');
    }
}

function check_file_name_extension($argv){

    if ((isset($argv[4])) || (isset($argv[3]) && $argv[3] !== "*" && strpos($argv[3], '.') !== false)) {
        $file_name = $argv[4] ?? $argv[3];
        if (preg_match('/[\w].sql$/', $file_name) == false) {
            die("ERROR: Your file extension is wrong!");
        }
    } else {
        $file_name = "dump-" . date('Y\-m\-d\-H:i:s') . ".sql";
    }
}

function check__table_names($argv,$connect,$dbName){
    if ($argv[3] === '*' || (count($argv) === 5 && strpos($argv[3], '.') !== false)) {
        $tableNames = getTableNames($dbName,$connect);
    } else {
        $table_names = explode(',', $argv[3]);
        for ($i = 0; $i < count($table_names); $i++) {
            $sql_query = "SELECT * FROM  $table_names[$i]";
            $sql = mysqli_query($connect, $sql_query);
            while($row = mysqli_fetch_array($sql , MYSQLI_BOTH)) {
                continue;
            }
        }
    }
}


