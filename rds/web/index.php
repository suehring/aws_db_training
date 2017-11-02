<?php

require_once('creds.inc');

$user = RDSUSER;
$pass = RDSPASS;
$host = RDSHOST;
$db = "testdb";

$dbConn = mysqli_connect($host,$user,$pass,$db);

$query = "SELECT * FROM users";

$result = mysqli_query($dbConn,$query);

while ($row = mysqli_fetch_row($result)) {
  var_dump($row);
}

?>
