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
    function desactivateAd($index)
    {
        $updateQuery = [
            'status' => 'INACTIVE'
        ];

        $condition = ['id' => $index];
        pg_update($this->dbconn, 'advertisement', $updateQuery, $condition);
    }
    function makeReservation($startDate, $endDate, $id, $idProfile, $comment, $paymentMethod)
    {
        $query = "INSERT INTO Rental (idProfile, idAdvertisement, startDate, endDate, comment, statusRental, paymentMethod) VALUES ($1, $2, $3, $4, $5, $6, $7)";

        // Execute the query with pg_query_params
        pg_query_params($this->dbconn, $query, array($idProfile, $id, $startDate, $endDate, $comment, 'RESERVATION_ASKED', $paymentMethod));
    }
    function getPaymentMethod()
    {
        return $this->getEnum("PaymentMethod");
    }
    function getEnum($enum)
    {
        $tmpArray = pg_fetch_all($this->query("select enum_range(null::" . $enum . ");"));
        $txt = $tmpArray[0]['enum_range'];
        $txt = substr($txt, 1, -1);
        $array = explode(',', $txt);
        return $array;
    }
    function activateAd($index)
    {
        $updateQuery = [
            'status' => 'ACTIVE'
        ];

        // Condition for the WHERE clause
        $condition = ['id' => $index];
        pg_update($this->dbconn, 'advertisement', $updateQuery, $condition);
    }
    function deleteAd($index)
    {
        $updateQuery = [
            'status' => 'DELETED'
        ];

        // Condition for the WHERE clause
        $condition = ['id' => $index];
        pg_update($this->dbconn, 'advertisement', $updateQuery, $condition);
    }
    function userIsAdOwner($index, $userId)
    {
        $ad = $this->getAd($index);
        return $ad['idprofile'] == $userId;
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
        $result = $this->query("select * from advertisement WHERE idProfile = $index AND status != 'DELETED';");
        $array = pg_fetch_all($result);
        return $array;
    }

    function getProfile($index)
    {
        $result = $this->query("select * from profile WHERE id=$index;");
        $array = pg_fetch_all($result);
        return $array[0];
    }

    function getAllAds()
    {
        $result = $this->query("select * from advertisement WHERE status = 'ACTIVE';");
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

    function registerProfile($firstname, $lastname, $mail, $password, $phoneNumber, $zipCity, $street, $streetNumber)
    {
        $id = $this->addAddress($zipCity, $street, $streetNumber);
        // Prepare the SQL query with placeholders for parameters
        $query = "INSERT INTO Profile (idAddress, firstname, lastname, mail, password, phoneNumber, status) VALUES ($1, $2, $3, $4, $5, $6 , 'ACTIVE')";

        // Execute the query with pg_query_params
        pg_query_params($this->dbconn, $query, array($id, $firstname, $lastname, $mail, $password, $phoneNumber));
    }

    function connectProfile($mail, $password)
    {
        $sql = 'SELECT password, id FROM Profile WHERE mail = \'' . $mail . '\'; ';
        $result = $this->query($sql);
        return $password == pg_fetch_all($result)[0]['password'];
    }

    function getProfileIdByMail($mail)
    {
        $sql = 'SELECT id FROM Profile WHERE mail = \'' . $mail . '\'; ';
        $result = $this->query($sql);
        return pg_fetch_all($result)[0]['id'];
    }

    // TODO test
    function getRental($index)
    {
        $query = $this->query("Select A.idprofile as idowner ,R.id as rentalId, A.id, A.title, R.startDate, R.endDate, status, R.idprofile from Rental AS R INNER JOIN advertisement AS A ON R.idAdvertisement = A.id WHERE R.id=$index;");
        $array = pg_fetch_all($query);
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
        return $ad['idprofile'] == $userId;
    }

    function getAllRentalsFromProfile($userId)
    {
        $result = $this->query("Select R.id as rentalId, A.id, A.title, R.startDate, R.endDate from Rental AS R INNER JOIN advertisement AS A ON R.idAdvertisement = A.id WHERE R.idProfile = $userId;");
        $array = pg_fetch_all($result);
        return $array;
    }

    function getAllRentalsFromOwner($userId)
    {
        $result = $this->query("select R.idprofile as rentowner, A.idprofile as adowner, R.id as idrent, A.id as idAd, A.title as adtitle, R.startdate as rentstart, R.endDate as rentend
                                    from Rental AS R
                                    INNER JOIN advertisement AS A ON R.idAdvertisement = A.id
                                    WHERE A.idProfile = $userId;");
        $array = pg_fetch_all($result);
        return $array;
    }
}
