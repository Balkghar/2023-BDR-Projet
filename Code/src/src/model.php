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
        $result = $this->query("SELECT * FROM vAds WHERE id=$index;");
        $array = pg_fetch_all($result);
        # TODO : add rating of object in the view vAds ?
        // TODO : trouvre un moyen de faire l'average directement dans la requête de base
        $array[0]['avg'] = pg_fetch_all($this->query("SELECT avg(objectrating) 
        FROM vRatingsComments
        WHERE id = " . $array[0]['id'] . ";"))[0]['avg'];
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
        $result = $this->query("select * from profile AS P 
                                INNER JOIN Address AS A ON P.idAddress = A.id
                                INNER JOIN City as C ON A.zipCity = C.zip
                                WHERE P.id=$index;");
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
        // TODO : trouvre un moyen de faire l'average directement dans la requête de base
        foreach ($array as &$ad) {
            $ad['avg'] = pg_fetch_all($this->query("SELECT avg(Ra.objectrating) 
            FROM Rental as Re 
            INNER JOIN Rating as Ra 
            ON Ra.idRental = Re.id WHERE Re.idAdvertisement = " . $ad['id'] . ";"))[0]['avg'];
        }
        return $array;
    }
    function getAllChildCategory($category)
    {
        return pg_fetch_all($this->query("select * from category WHERE parentcategory='$category';"));
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
    function getCurrentTime()
    {
        // TODO : adapt timezone
        $now = new DateTime();
        $now->format('Y-m-d H:i:s');
        return date("Y-m-d H:i:s", $now->getTimestamp());
    }
    function paymentDone($id)
    {
        $updateQuery = [
            'paymentdate' => $this->getCurrentTime()
        ];

        // Condition for the WHERE clause
        $condition = ['id' => $id];
        pg_update($this->dbconn, 'rental', $updateQuery, $condition);
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
        $updateQuery = [
            'statusrental' => $newStatus
        ];

        // Condition for the WHERE clause
        $condition = ['id' => $id];
        pg_update($this->dbconn, 'rental', $updateQuery, $condition);
    }

    /**
     * @return array
     */
    function getAllCategory(): array
    {
        $result = $this->query("select name from category;");
        $array = pg_fetch_all($result);
        return $array;
    }
    function createAd($title, $description, $price, $categroy, $interval, $zip, $street, $streetNumber, $idProfile)
    {
        $idAdress = $this->addAddress($zip, $street, $streetNumber);
        // Prepare the SQL query with placeholders for parameters
        $query = "INSERT INTO Advertisement (idAddress, idProfile, creationdate, nameCategory, title, description, price, priceInterval,
        status) VALUES ($1, $2, $3, $4, $5, $6, $7, $8, 'ACTIVE');";
        // Execute the query with pg_query_params
        pg_query_params($this->dbconn, $query, array($idAdress, $idProfile, $this->getCurrentTime(), $categroy, $title, $description, $price, $interval));

        $result = $this->query("SELECT MAX(id) FROM Advertisement;");
        $array = pg_fetch_all($result);
        return $array[0]['max'];
    }
    function getAllCity()
    {
        $result = $this->query("select * from city ;");
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

        $updateQuery = [
            'zipcity' => $zip,
            'street' => $street,
            'streetnumber' => $streetNumber
        ];

        // Condition for the WHERE clause
        $condition = ['id' => $id];
        pg_update($this->dbconn, 'address', $updateQuery, $condition);
    }
    function modifyAd($title, $description, $price, $category, $interval, $zip, $street, $streetNumber, $idAd, $idAddr)
    {
        $this->updateAddress($zip, $street, $streetNumber, $idAddr);

        $updateQuery = [
            'title' => $title,
            'description' => $description,
            'price' => $price,
            'namecategory' => $category,
            'priceinterval' => $interval
        ];

        // Condition for the WHERE clause
        $condition = ['id' => $idAd];
        pg_update($this->dbconn, 'advertisement', $updateQuery, $condition);
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
        $query = "SELECT P.idAddress AS id from profile AS P 
                    INNER JOIN Address AS A ON P.idAddress = A.id
                    WHERE P.id=$idProfile;";
        $array = pg_fetch_all($this->query($query));
        $idAddr = $array[0]['id'];
        $this->updateAddress($zipCity, $street, $streetNumber, $idAddr);

        $updateQuery = [
            'firstname' => $firstname,
            'lastname' => $lastname,
            'mail' => $mail,
            'phonenumber' => $phoneNumber
        ];

        // Condition for the WHERE clause
        $condition = ['id' => $idProfile];
        pg_update($this->dbconn, 'profile', $updateQuery, $condition);
    }

    function getAllCommentsOfProfile($idAd)
    {
        $query = "SELECT firstname, lastname, comment FROM vRatingsComments WHERE id = $idAd AND objectrating IS NOT NULL;";
        $result = $this->query($query);
        return pg_fetch_all($result);
    }
}
