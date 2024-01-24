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
        $query = "CALL insertRental($1, $2, $3, $4, $5, $6, $7)";

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
        $query = "UPDATE Advertisement SET status = 'ACTIVE' WHERE id = $index;";

        $this->query($query);
    }

    function deleteAd($index)
    {
        $query = "UPDATE Advertisement SET status = 'DELETED' WHERE id = $index;";
        $this->query($query);
    }

    function userIsAdOwner($index, $userId)
    {
        $ad = $this->getAd($index);
        return $ad['idprofile'] == $userId;
    }

    function getAd($index)
    {
        $result = $this->query("SELECT * FROM vAds WHERE id=$index;");
        $array = pg_fetch_all($result);
        return $array[0];
    }

    function getAllAdsFromUser($index)
    {
        $result = $this->query("SELECT * FROM vAds WHERE idProfile = $index AND status != 'DELETED' ORDER BY creationDate DESC;");
        $array = pg_fetch_all($result);
        return $array;
    }


    function getProfile($index)
    {
        $result = $this->query("
        SELECT * 
        FROM vProfile
        WHERE profileId=$index;");
        $array = pg_fetch_all($result);
        return $array[0];
    }

    function getAllAds($search, $category, $canton, $zip)
    {
        $query = "SELECT * 
        FROM vAds 
        WHERE status = 'ACTIVE'";
        if ($search != "") {
            $query .= "AND (LOWER(title) LIKE LOWER('%$search%') OR LOWER(description) LIKE LOWER('%$search%'))";
        }
        if ($category != "") {
            $query .= " AND (nameCategory = '$category' ";
            foreach ($this->getAllChildCategory($category) as $cat) {
                $query .= " OR nameCategory = '" . $cat['name'] . "' ";
            }
            $query .= ")";
        }
        if ($canton != "") {
            $query .= " AND canton = '$canton' ";
        }
        if ($zip != "") {
            $query .= " AND zipCity = '$zip'";
        }
        $query .= "ORDER BY creationDate DESC;";
        $result = $this->query($query);
        $array = pg_fetch_all($result);
        return $array;
    }

    function getAllChildCategory($category)
    {
        return pg_fetch_all($this->query("select * from category WHERE parentcategory='$category';"));
    }

    function registerProfile($firstname, $lastname, $mail, $password, $phoneNumber, $zipCity, $street, $streetNumber)
    {
        $query = "WITH newAddress AS (INSERT INTO Address (zipCity, street, streetNumber) VALUES ($1, $2, $3) RETURNING id)";
        $query .= "INSERT INTO Profile (idAddress, firstname, lastname, mail, password, phoneNumber, status) VALUES ((SELECT id FROM newAddress), $4, $5, $6, $7, $8 , 'ACTIVE')";

        // Execute the query with pg_query_params
        pg_query_params($this->dbconn, $query, array($zipCity, $street, $streetNumber, $firstname, $lastname, $mail, $password, $phoneNumber));
    }

    function connectProfile($mail, $password)
    {
        $sql = 'SELECT password, id FROM Profile WHERE mail = \'' . $mail . '\'; ';
        $result = $this->query($sql);
        if (pg_fetch_all($result) == null)
            return false;
        return $password == pg_fetch_all($result)[0]['password'];
    }

    function getProfileIdByMail($mail)
    {
        $sql = 'SELECT id FROM Profile WHERE mail = \'' . $mail . '\'; ';
        $result = $this->query($sql);
        return pg_fetch_all($result)[0]['id'];
    }

    function getRental($index)
    {
        $query = $this->query("SELECT * FROM vRentalInfo WHERE rentalId= $index");
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
        return $ad['rentidowner'] == $userId;
    }

    function getAllRentalsFromProfile($userId)
    {
        $result = $this->query("SELECT * FROM vRentals WHERE idRenter = $userId");
        $array = pg_fetch_all($result);
        return $array;
    }

    function getAllRentalsFromOwner($userId)
    {
        $result = $this->query("SELECT * FROM vRentals WHERE idOwner = $userId");
        $array = pg_fetch_all($result);
        return $array;
    }

    function paymentDone($id)
    {
        $query = "UPDATE Rental SET paymentdate = now() WHERE id = $id";
        $this->query($query);
    }

    function locationIsNotCanceled($id)
    {
        $result = $this->getRental($id);
        return ($result['statusrental'] != 'LOCATION_CANCELED' && $result['statusrental'] != 'RESERVATION_CANCELED');
    }

    function confirmateRental($id)
    {
        $this->updateRentalStatus($id, 'RESERVATION_CONFIRMED');
    }

    function cancelRental($id)
    {
        $this->updateRentalStatus($id, 'RESERVATION_CANCELED');
    }

    function locationOngoing($id)
    {
        $this->updateRentalStatus($id, 'LOCATION_ONGOING');
    }

    function itemReturned($id)
    {
        $this->updateRentalStatus($id, 'ITEM_RETURNED');
    }

    function finishLocation($id)
    {
        $this->updateRentalStatus($id, 'LOCATION_FINISHED');
    }

    function cancelLocation($id)
    {
        $this->updateRentalStatus($id, 'LOCATION_CANCELED');
    }

    function updateRentalStatus($id, $newStatus)
    {
        $query = "UPDATE Rental SET statusRental = '$newStatus' WHERE id = $id";
        $this->query($query);
    }

    /**
     * @return array
     */
    function getAllCategory(): array
    {
        $result = $this->query("SELECT name FROM category;");
        $array = pg_fetch_all($result);
        return $array;
    }

    function createAd($title, $description, $price, $categroy, $interval, $zip, $street, $streetNumber, $idProfile)
    {
        $query = "WITH newAddress AS (INSERT INTO Address (zipCity, street, streetNumber) VALUES ($1, $2, $3) RETURNING id)";

        $query .= "INSERT INTO Advertisement (idAddress, idProfile, creationdate, nameCategory, title, description, price, priceInterval,
        status) VALUES ((SELECT id FROM newAddress), $4, now(), $5, $6, $7, $8, $9, 'ACTIVE') RETURNING id";
        $result = pg_query_params($this->dbconn, $query, array($zip, $street, $streetNumber, $idProfile, $categroy, $title, $description, $price, $interval));
        return pg_fetch_result($result, 0, 0);
    }

    function getAllCity()
    {
        $result = $this->query("SELECT * FROM city;");
        $array = pg_fetch_all($result);
        return $array;
    }

    function getAllCanton()
    {
        return $this->getEnum("Canton");
    }

    function checkIfRentalIsNotRated($idRental, $idProfile)
    {
        $query = "SELECT * FROM Rating WHERE idRental=$idRental AND idProfile=$idProfile;";
        $array = pg_fetch_all($this->query($query));
        return !$array;
    }

    function rateRental($idRental, $idProfile, $rating, $comment)
    {
        if ($comment == "")
            $comment = null;
        $query = "INSERT INTO Rating (idProfile, idRental, rentalRating, comment) VALUES ($1,$2,$3,$4);";
        pg_query_params($this->dbconn, $query, array($idProfile, $idRental, $rating, $comment));
    }

    function rateObject($idRental, $idProfile, $ratingObject, $ratingRental, $comment)
    {
        if ($comment == "")
            $comment = null;
        $query = "INSERT INTO Rating (idProfile, idRental, rentalRating, objectRATING, comment) VALUES ($1,$2,$3,$4,$5);";
        pg_query_params($this->dbconn, $query, array($idProfile, $idRental, $ratingRental, $ratingObject, $comment));
    }

    function updateAddress($zip, $street, $streetNumber, $id)
    {
        $query = "UPDATE Address SET zipCity = $1 , street = $2, streetNumber = $3 WHERE id = $4;";
        pg_query_params($this->dbconn, $query, array($zip, $street, $streetNumber, $id));
    }

    function modifyAd($title, $description, $price, $category, $interval, $zip, $street, $streetNumber, $idAd, $idAddr)
    {
        $this->updateAddress($zip, $street, $streetNumber, $idAddr);
        $query = "UPDATE Advertisement SET title = $1, description = $2, price = $3, priceInterval = $4, nameCategory = $5 WHERE id = $6;";
        pg_query_params($this->dbconn, $query, array($title, $description, $price, $interval, $category, $idAd));
    }

    function addImagesToAd($adId, $imagePaths)
    {
        // Convert the array of image paths to a comma-separated string
        $imagePathsStr = implode(',', $imagePaths);

        // Prepare the SQL query with placeholders for parameters
        $query = "UPDATE Advertisement SET pictures = array_append(pictures, $1) WHERE id = $2";

        // Execute the query with pg_query_params
        pg_query_params($this->dbconn, $query, array($imagePathsStr, $adId));
    }

    function deleteImagesFromAd($adId, $imagePaths)
    {
        $stringCurrentImages = pg_fetch_all($this->query("SELECT pictures FROM Advertisement WHERE id = $adId"))[0]['pictures'];
        $currentPictures = array_map('trim', explode(',', str_replace("\"", "", trim($stringCurrentImages, '{}'))));

        $newPictures = array_diff($currentPictures, $imagePaths);
        if (!empty($newPictures)) {
            $newString = '{"' . implode(",", $newPictures) . '"}';
        } else {
            $newString = null;
        }
        $queryUpdate = "UPDATE Advertisement SET pictures = $1 WHERE id = $2";
        pg_query_params($this->dbconn, $queryUpdate, array($newString, $adId));
    }


    function updateProfile($firstname, $lastname, $mail, $phoneNumber, $zipCity, $street, $streetNumber, $idProfile)
    {
        $query = "SELECT addressid AS id 
        FROM vProfile  
        WHERE profileId=$idProfile;";
        $array = pg_fetch_all($this->query($query));
        $idAddr = $array[0]['id'];
        $this->updateAddress($zipCity, $street, $streetNumber, $idAddr);

        $query = "UPDATE Profile SET firstname = $1 , lastname = $2, mail = $3, phoneNumber = $4 WHERE id = $5;";
        pg_query_params($this->dbconn, $query, array($firstname, $lastname, $mail, $phoneNumber, $idProfile));
    }

    function getAllCommentsOfProfile($idAd)
    {
        $query = "SELECT firstname, lastname, comment FROM vRatingsComments WHERE id = $idAd AND objectrating IS NOT NULL;";
        $result = $this->query($query);
        return pg_fetch_all($result);
    }
}
