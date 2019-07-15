<?php
require_once ('functionality.php');
require_once ('connection.php');


function checkArguments($argv,$argc,$connection,$dbName){
    if ($argv[3] == '*'){
        $showTables = mysqli_query($connection,"SHOW TABLES");
        getTableNames($dbName,$connection);
    }
}
