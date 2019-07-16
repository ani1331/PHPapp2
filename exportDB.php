<?php
//
//require_once ('functionality.php');
//require_once ('connection.php');
require_once ('exportConditions.php');



export($withData = true);

function export($withData = true)
{
    global $argv;
    $file_name = $argv[3];
    $dbName = $argv[2];

    $connection = connection($dbName);

    $tableNames = getTableNames($dbName,$connection);




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