<?php
class Postgresql
{
  private $host = "postgres";
  private $port = "5432";
  private $dbname = "BDRProject";
  private $user = "projectuser";
  private $password = "VP8%@TPNUn44D3Lg3Pkm";
  private $dbconn;

  public function __construct()
  {
    $this->connect();
  }

  private function connect()
  {
    $this->dbconn = pg_connect(
      "host=$this->host port=$this->port dbname=$this->dbname user=$this->user password=$this->password"
    );

    if (!$this->dbconn) {
      die("Connection failed: " . pg_last_error());
    }
  }

  public function query($sql)
  {
    $result = pg_query($this->dbconn, $sql);

    if (!$result) {
      die("Query failed: " . pg_last_error());
    }

    return $result;
  }
  function getAd($index)
  {
    $result = $this->query("select * from advertisement WHERE id=$index;");
    $array = pg_fetch_all($result);
    return $array[0];
  }
  function getUser($index)
  {
    $result = $this->query("select * from \"User\" WHERE id=$index;");
    $array = pg_fetch_all($result);
    return $array[0];
  }
  function getAllAds()
  {
    $result = $this->query("select * from advertisement;");
    $array = pg_fetch_all($result);
    return $array;
  }
  function addAddress($zipCity, $street, $streetNumber)
  {
    // Prepare the SQL query with placeholders for parameters
    $query = "INSERT INTO Address (zipCity, street, streetNumber) VALUES ($1, $2, $3)";

    // Execute the query with pg_query_params
    pg_query_params($this->dbconn, $query, array($zipCity, $street, $streetNumber));

    $result = $this->query("SELECT MAX(id) FROM Address;");
    $array = pg_fetch_all($result);
    return $array[0]['max'];
  }
  function registerUser($firstname, $lastname, $mail, $password, $phoneNumber, $zipCity, $street, $streetNumber)
  {
    $id = $this->addAddress($zipCity, $street, $streetNumber);
    // Prepare the SQL query with placeholders for parameters
    $query = "INSERT INTO \"User\" (idAddress, firstname, lastname, mail, password, phoneNumber, status) VALUES ($1, $2, $3, $4, $5, $6 , 'ACTIVE')";

    // Execute the query with pg_query_params
    pg_query_params($this->dbconn, $query, array($id, $firstname, $lastname, $mail, $password, $phoneNumber));
  }
}
