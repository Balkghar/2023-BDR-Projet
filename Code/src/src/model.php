<?php
    $host = "postgres";
    $port = "5432";
    $dbname = "BDRProject";
    $user = "projectuser";
    $password = "VP8%@TPNUn44D3Lg3Pkm"; 
    $connection_string = "host={$host} port={$port} dbname={$dbname} user={$user} password={$password} ";
    
    // $dbconn = include_once('db_connection.php');
    class Postgresql
    {
        private $host = "postgres";
        private $port = "5432";
        private $dbname = "BDRProject";
        private $user = "projectuser";
        private $password = "VP8%@TPNUn44D3Lg3Pkm"; 
        //private $connection_string = "host={$this->host} port={$this->port} dbname={$this->dbname} user={$this->user} password={$this->password} ";        
        private $dbconn;
        private $table_name = 'user';

        function __construct() {
            $this->dbconn = pg_connect("host=postgres port=5432 dbname=BDRProject user=projectuser password=VP8%@TPNUn44D3Lg3Pkm");
        }
      }
?>