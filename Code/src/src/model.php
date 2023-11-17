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
  function getAllAdvertisements()
  {
    $test1 = new Advertisements(1, date("m.d.y"), "UwU", "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.", 120);
    $test2 = new Advertisements(1, date("m.d.y"), "Owo", "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Nam at lectus urna duis convallis convallis tellus id. Tortor pretium viverra suspendisse potenti nullam ac tortor vitae purus. Facilisis volutpat est velit egestas dui. Amet justo donec enim diam vulputate ut. Nulla posuere sollicitudin aliquam ultrices. Pulvinar elementum integer enim neque volutpat ac. Consequat interdum varius sit amet mattis. Diam quam nulla porttitor massa id neque aliquam vestibulum. Scelerisque eleifend donec pretium vulputate sapien nec.", 40);
    $test3 = new Advertisements(1, date("m.d.y"), "OvO", "Dolor sit amet consectetur adipiscing elit ut. Sodales neque sodales ut etiam. Viverra nibh cras pulvinar mattis. At varius vel pharetra vel turpis nunc. Dictumst quisque sagittis purus sit. Etiam non quam lacus suspendisse. In metus vulputate eu scelerisque felis. Ipsum consequat nisl vel pretium lectus quam id. Consequat nisl vel pretium lectus quam id leo in. Amet luctus venenatis lectus magna fringilla urna. Nibh nisl condimentum id venenatis. Commodo sed egestas egestas fringilla phasellus faucibus scelerisque eleifend donec. Bibendum enim facilisis gravida neque convallis.", 20);
    $ad = array($test1, $test2, $test3);
    return $ad;
  }
  //TODO : les selects et les inserts, faudra juste avoir des cookies pour gérer les connexions utilisateurs
}
