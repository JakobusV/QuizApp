<?php
function DBConnection() {
    include 'personalConnectionDetails.php';

    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
        or die ("Could not connect to the database server, make sure you've updated personalConnectionDetails.php " . mysqli_connect_error());

    return $con;
}

/**
 * Execute insert, update, and delete query statements
 * @param mixed $query Passed in query to run using mysqli
 * @return string Result of the query execution
 */
function AffectedRowsExecution($query) {
    $dbConnection = DBConnection();
    $result = @mysqli_query($dbConnection, $query) . " row affected";
    @mysqli_close($dbConnection);
    return $result;
}

/**
 * Execute select query statements
 * @param mixed $query Passed in query to run using mysqli
 * @return string Result of the query execution
 */
function SelectExecution($query) {
    $dbConnection = DBConnection();
    $dataSet = @mysqli_query($dbConnection, $query);
    $result = "";

    
    if ($dataSet) {
        $rowArray = [];
        while ($row = @mysqli_fetch_array($dataSet)) {
            $rowArray[] = json_decode($row[0]);
        }
        $result = json_encode($rowArray);
    }
    @mysqli_close($dbConnection);
    return $result;
}
?>