<?php
function DBConnection() {
    include 'personalConnectionDetails.php';

    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
        or die ("Could not connect to the database server, make sure you've updated personalConnectionDetails.php " . mysqli_connect_error());

    return $con;
}

function AffectedRowsExecution($query) {
    $dbConnection = DBConnection();
    $result = @mysqli_query($dbConnection, $query) . " row affected";
    @mysqli_close($dbConnection);
    return $result;
}
?>