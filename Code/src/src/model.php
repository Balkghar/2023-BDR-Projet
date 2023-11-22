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
  function getAd($index)
  {
    //TODO select instead of this, this is just a workaround
    return $this->getAllAds()[$index - 1];
  }
  function getAllAds()
  {
    $ad1 = new Advertisements(1, date("m.d.y"), "UwU", "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.", 120);
    $ad2 = new Advertisements(2, date("m.d.y"), "Owo", "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.", 120);
    $ad3 = new Advertisements(3, date("m.d.y"), "0V0", "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.", 120);
    return array($ad1, $ad2, $ad3);
  }
  //TODO : les selects et les inserts, faudra juste avoir des cookies pour gérer les connexions utilisateurs
}
