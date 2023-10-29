<?php
// connect to the database
$host = "postgres";
$port = "5432";
$dbname = "BDRProject";
$user = "projectuser";
$password = "VP8%@TPNUn44D3Lg3Pkm"; 
$connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} ";
$dbconn = pg_connect($connection_string);
?>
