<?php
class Postgresql
{
  private $host = "postgres";
  private $port = "5432";
  private $dbname = "BDRProject";
  private $user = "projectuser";
  private $password = "VP8%@TPNUn44D3Lg3Pkm";
  private $dbconn;

  function __construct()
  {
    $this->dbconn = pg_connect("host={$this->host} port={$this->port} dbname={$this->dbname} user={$this->user} password={$this->password} ");
  }
}
