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

    function userIsAdOwner($index, $userId)
    {
        $ad = $this->getAd($index);
        return $ad['iduser'] == $userId;
    }

    function getAd($index)
    {
        $result = $this->query("select * from advertisement WHERE id=$index;");
        $array = pg_fetch_all($result);
        $array[0]['avg'] = pg_fetch_all($this->query("SELECT avg(Ra.objectrating) FROM Rental as Re INNER JOIN Rating as Ra ON Ra.idRental = Re.id WHERE Re.idAdvertisement = " . $array[0]['id'] . ";"))[0]['avg'];
        return $array[0];
    }

    function getAllAdsFromUser($index)
    {
        $result = $this->query("select * from advertisement WHERE idUser = $index;");
        $array = pg_fetch_all($result);
        return $array;
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

    function connectUser($mail, $password)
    {
        $sql = 'SELECT password, id FROM "User" WHERE mail = \'' . $mail . '\'; ';
        $result = $this->query($sql);
        return $password == pg_fetch_all($result)[0]['password'];
    }

    function getUserIdByMail($mail)
    {
        $sql = 'SELECT id FROM "User" WHERE mail = \'' . $mail . '\'; ';
        $result = $this->query($sql);
        return pg_fetch_all($result)[0]['id'];
    }

    // todo test
    function getRental($index)
    {
        $result = $this->query("select * from Rental WHERE id=$index;");
        $array = pg_fetch_all($result);
        $array[0]['avg'] = pg_fetch_all($this->query("SELECT avg(Ra.objectrating) FROM Rental as Re INNER JOIN Rating as Ra ON Ra.idRental = Re.id WHERE Re.id = " . $array[0]['id'] . ";"))[0]['avg'];
        return $array[0];
    }

    function userIsRentalOwner($index, $userId)
    {
        $ad = $this->getRental($index);
        return $ad['idowner'] == $userId;
    }

    function userIsRentalUser($index, $userId)
    {
        $ad = $this->getRental($index);
        return $ad['iduser'] == $userId;
    }

    function getAllRentalsFromUser($userId)
    {
        $result = $this->query("Select * from Rental AS R
                                         INNER JOIN advertisement AS A ON R.idAdvertisement = A.id
         WHERE R.idUser = $userId;");
        $array = pg_fetch_all($result);
        return $array;
    }

    function getAllRentalsFromOwner($userId)
    {
        // todo correct sql to get details from rental and advertisement,
        $result = $this->query("select * from Rental AS R
                                         INNER JOIN advertisement AS A ON R.idAdvertisement = A.id
                                    WHERE A.iduser = $userId;");
        $array = pg_fetch_all($result);
        return $array;
    }
}
