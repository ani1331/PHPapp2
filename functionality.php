<?php

function getTableStructureSQl($connection, $tableName) {
    $sql = "SHOW CREATE TABLE {$tableName};\n";
    $result = mysqli_query($connection, $sql);
    $r = mysqli_fetch_array($result);
    return isset($r[1]) ? $r[1] : null;
}
function getTableDataSQl($connection, $tableName) {
    $sql = "SELECT * FROM {$tableName};";
    $result = mysqli_query($connection, $sql);
    $r = '';

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        foreach ($row as &$val){
            if (empty($val)== true){
            $val = 'NULL';
//            $val = $val ?? 'NULL';
            $val = addslashes($val);
            } elseif($val !== 'NULL') {
                $values = "'" . implode("', '", $row) . "'";
            }
        }
        $r .= "INSERT INTO {$tableName} VALUES ({$values}); \n";

    }
    return $r;
}
function getTableNames($dbName,$connection){
    $sql = "SHOW TABLES FROM $dbName;";
    $result = mysqli_query($connection,$sql);
    while ($row = mysqli_fetch_array($result)) {
        $tables[] = $row[0];
    }
    return $tables;
}
