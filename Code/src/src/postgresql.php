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
        function createUser()
        {
             $sql = "INSERT INTO PUBLIC.".$this->table_name."  
             (name,email,phone,address) "."VALUES('".
             $this->cleanData($_POST['name'])."','".
             $this->cleanData($_POST['email'])."','".
             $this->cleanData($_POST['phone'])."','".
             $this->cleanData($_POST['address'])."')";
             return pg_affected_rows(pg_query($this->dbconn, $sql));
        }

        function getUsers()
        {             
            $sql ="select *from public." . $this->table_name . "  
            ORDER BY id DESC";
            return pg_query($this->dbconn, $sql);
        } 

        function getUserById(){    
  
            $sql ="select *from public." . $this->table_name . "  
            where id='".$this->cleanData($_POST['id'])."'";
            return pg_query($this->dbconn, $sql);
        } 

       function deleteuser()
       {    
  
            $sql ="delete from public." . $this->table_name . "  
            where id='".$this->cleanData($_POST['id'])."'";
            return pg_query($this->dbconn, $sql);
       } 

       function updateUser($data=array())
       {       
     
          $sql = "update public.user set name='".
          $this->cleanData($_POST['name'])."',email='".
          $this->cleanData($_POST['email'])."', phone='".
          $this->cleanData($_POST['phone'])."',address='".
          $this->cleanData($_POST['address'])."' where id = '".
          $this->cleanData($_POST['id'])."' ";
          return pg_affected_rows(pg_query($this->dbconn, $sql));        
       }
       function cleanData($val)        {
         return pg_escape_string($this->dbconn, $val);
       }
      }
?>