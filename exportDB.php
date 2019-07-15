<?php

$file_name = $argv[3];
$dbName = $argv[2];
require_once ('functionality.php');
require_once ('connection.php');

function export($file_name, $dbName, $withData = true)
{


//CONNECTION
    $connection = connection($dbName);
//CONNECTION

//TABLE STRUCTURE
    $tableNames = getTableNames($dbName,$connection);
//TABLE STRUCTURE

//PRINTING TO FILE

    $fileOpen = fopen($file_name, "a");
    fwrite($fileOpen, "CREATE DATABASE IF NOT EXISTS $dbName;");
    fwrite($fileOpen, "\n");
    fwrite($fileOpen, "SET FOREIGN_KEY_CHECKS=0;");
    fwrite($fileOpen, "\n");
    fwrite($fileOpen, "USE $dbName;");
    fwrite($fileOpen, "\n");
    foreach ($tableNames as $table) {
        $structureSql = getTableStructureSQl($connection, $table);
        fwrite($fileOpen, "DROP TABLE IF EXISTS `$table`;\n");
        fwrite($fileOpen, "\n");
        fwrite($fileOpen, $structureSql.';');
        fwrite($fileOpen, "\n");
        if ($withData) {
            $dataSql = getTableDataSQl($connection, $table);
            fwrite($fileOpen, "\n");
            fwrite($fileOpen, $dataSql);
            fwrite($fileOpen, "\n");
        }
        fwrite($fileOpen, "SET FOREIGN_KEY_CHECKS=1;");

    }

    fclose($fileOpen);
}
export($file_name, $dbName);
