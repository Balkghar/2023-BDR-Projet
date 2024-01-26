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
    // Connect to the database
    private function connect()
    {
        $this->dbconn = pg_connect(
            "host=$this->host port=$this->port dbname=$this->dbname user=$this->user password=$this->password"
        );

        if (!$this->dbconn) {
            die("Connection failed: " . pg_last_error());
        }
    }
    /**
     * Execute a query and return the result
     * @param string $sql the query to execute
     * @return PgSql\Result
     */
    public function query($sql)
    {
        $result = pg_query($this->dbconn, $sql);

        if (!$result) {
            die("Query failed: " . pg_last_error());
        }

        return $result;
    }
    /**
     * Desactivate an ad at the given index
     */
    function desactivateAd($index)
    {
        $query = "UPDATE Advertisement SET status = 'INACTIVE' WHERE id = $index;";

        $this->query($query);
    }
    /**
     * Make a reservation for the given ad
     */
    function makeReservation($startDate, $endDate, $id, $idProfile, $comment, $paymentMethod)
    {
        $query = "CALL insertRental($1, $2, $3, $4, $5, $6, $7)";

        // Execute the query with pg_query_params
        pg_query_params($this->dbconn, $query, array($idProfile, $id, $startDate, $endDate, $comment, 'RESERVATION_ASKED', $paymentMethod));
    }
    /**
     * Get all the enum for the payment method
     * @return array
     */
    function getPaymentMethod()
    {
        return $this->getEnum("PaymentMethod");
    }
    /**
     * Get all the enum for the given enum name
     * @param string $enum the enum name
     * @return array
     */
    function getEnum($enum)
    {
        $tmpArray = pg_fetch_all($this->query("select enum_range(null::" . $enum . ");"));
        $txt = $tmpArray[0]['enum_range'];
        $txt = substr($txt, 1, -1);
        $array = explode(',', $txt);
        return $array;
    }
    /**
     * Activate the given ad
     */
    function activateAd($index)
    {
        $query = "UPDATE Advertisement SET status = 'ACTIVE' WHERE id = $index;";

        $this->query($query);
    }
    /**
     * Delete the given ad
     */
    function deleteAd($index)
    {
        $query = "UPDATE Advertisement SET status = 'DELETED' WHERE id = $index;";
        $this->query($query);
    }
    /**
     * Check if the user is the ad owner
     * @param int $index the index of the ad
     * @param int $userId the id of the profile
     * @return bool true if it is the owner otherwise false
     */
    function userIsAdOwner($index, $userId)
    {
        $ad = $this->getAd($index);
        return $ad['idprofile'] == $userId;
    }

    /**
     * Get the specified ad
     * @param int $index the index of the ad
     * @return array the ad
     */
    function getAd($index)
    {
        $result = $this->query("SELECT * FROM vAds WHERE id=$index;");
        $array = pg_fetch_all($result);
        return $array[0];
    }

    /**
     * Get all the ads from the given user
     * @param int $userId the id of the user
     * @return array the ads
     */
    function getAllAdsFromUser($userId)
    {
        $result = $this->query("SELECT * FROM vAds WHERE idProfile = $userId AND status != 'DELETED' ORDER BY creationDate DESC;");
        return pg_fetch_all($result);
    }

    /**
     * Get the profile of the given user
     * @param int $userId the id of the user
     * @return array the profile
     */
    function getProfile($userId)
    {
        $result = $this->query("
        SELECT * 
        FROM vProfile
        WHERE profileId=$userId;");
        $array = pg_fetch_all($result);
        return $array[0];
    }

    /**
     * Get all the ads
     * @param string $search the search string
     * @param string $category the category
     * @param string $canton the canton
     * @param string $zip the zip
     * @return array the ads
     */
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

    /**
     * Get all the child of a category
     * @param string $category the category
     * @return array the child categories
     */
    function getAllChildCategory($category)
    {
        return pg_fetch_all($this->query("select * from category WHERE parentcategory='$category';"));
    }

    /**
     * Register a new profile
     * @param string $firstname the firstname
     * @param string $lastname the lastname
     * @param string $mail the mail
     * @param string $password the password
     * @param string $phoneNumber the phone number
     * @param string $zipCity the zip
     * @param string $street the street
     * @param string $streetNumber the street number
     */
    function registerProfile($firstname, $lastname, $mail, $password, $phoneNumber, $zipCity, $street, $streetNumber)
    {
        $query = "CALL insertProfile($1, $2, $3, $4, $5, $6, $7, $8 , 'ACTIVE')";
        // Execute the query with pg_query_params
        pg_query_params($this->dbconn, $query, array($zipCity, $street, $streetNumber, $firstname, $lastname, $mail, $password, $phoneNumber));
    }

    /**
     * connect the profile
     * @param string $mail the mail
     * @param string $password the password
     * @return bool true if the profile exist otherwise false
     */
    function connectProfile($mail, $password)
    {
        $sql = 'SELECT password, id FROM Profile WHERE mail = \'' . $mail . '\'; ';
        $result = $this->query($sql);
        if (pg_fetch_all($result) == null)
            return false;
        return $password == pg_fetch_all($result)[0]['password'];
    }

    /**
     * Get the profile id by the mail
     * @param string $mail the mail
     * @return int the id of the profile
     */
    function getProfileIdByMail($mail)
    {
        $sql = 'SELECT id FROM Profile WHERE mail = \'' . $mail . '\'; ';
        $result = $this->query($sql);
        return pg_fetch_all($result)[0]['id'];
    }

    /** 
     * Get the rental
     * @param int $index the index of the rental
     * @return array the rental
     */
    function getRental($index)
    {
        $query = $this->query("SELECT * FROM vRentalInfo WHERE rentalId= $index");
        $array = pg_fetch_all($query);
        return $array[0];
    }

    /**
     * check if the user is the rental owner
     * @param int $index the index of the rental
     * @param int $userId the id of the user
     * @return bool true if it is the owner otherwise false
     */
    function userIsRentalOwner($index, $userId)
    {
        $ad = $this->getRental($index);
        return $ad['idowner'] == $userId;
    }

    /**
     * check if the user is the rental user
     * @param int $index the index of the rental
     * @param int $userId the id of the user
     * @return bool true if it is the user otherwise false
     */
    function userIsRentalUser($index, $userId)
    {
        $ad = $this->getRental($index);
        return $ad['rentidowner'] == $userId;
    }

    /**
     * Get all the rentals from the given user
     * @param int $userId the id of the user
     * @return array the rentals
     */
    function getAllRentalsFromProfile($userId)
    {
        $result = $this->query("SELECT * FROM vRentals WHERE idRenter = $userId");
        $array = pg_fetch_all($result);
        return $array;
    }

    /**
     * Get all the rentals from the given owner
     * @param int $userId the id of the user
     * @return array the rentals
     */
    function getAllRentalsFromOwner($userId)
    {
        $result = $this->query("SELECT * FROM vRentals WHERE idOwner = $userId");
        $array = pg_fetch_all($result);
        return $array;
    }

    /**
     * Execute the payment for the given Rental
     * @param int $id the id of the rental
     */
    function paymentDone($id)
    {
        $query = "UPDATE Rental SET paymentdate = now() WHERE id = $id";
        $this->query($query);
    }

    /**
     * Check if the rental is not canceled
     * @param int $id the id of the rental
     * @return bool true if it is not canceled otherwise false
     */
    function locationIsNotCanceled($id)
    {
        $result = $this->getRental($id);
        return ($result['statusrental'] != 'LOCATION_CANCELED' && $result['statusrental'] != 'RESERVATION_CANCELED');
    }

    /**
     * Confirmate the rental
     * @param int $id the id of the rental
     */
    function confirmateRental($id)
    {
        $this->updateRentalStatus($id, 'RESERVATION_CONFIRMED');
    }

    /**
     * Cancel the rental
     * @param int $id the id of the rental
     */
    function cancelRental($id)
    {
        $this->updateRentalStatus($id, 'RESERVATION_CANCELED');
    }

    /**
     * Change the status of the rental to ongoing
     * @param int $id the id of the rental
     */
    function locationOngoing($id)
    {
        $this->updateRentalStatus($id, 'LOCATION_ONGOING');
    }

    /**
     * change the status of the rental to item returned
     * @param int $id the id of the rental
     */
    function itemReturned($id)
    {
        $this->updateRentalStatus($id, 'ITEM_RETURNED');
    }

    /**
     * change the status of the rental to location finished
     * @param int $id the id of the rental
     */
    function finishLocation($id)
    {
        $this->updateRentalStatus($id, 'LOCATION_FINISHED');
    }

    /**
     * change the status of the rental to location canceled
     * @param int $id the id of the rental
     */
    function cancelLocation($id)
    {
        $this->updateRentalStatus($id, 'LOCATION_CANCELED');
    }

    /**
     * Update the status of the rental
     * @param int $id the id of the rental
     * @param string $newStatus the new status
     */
    function updateRentalStatus($id, $newStatus)
    {
        $query = "UPDATE Rental SET statusRental = '$newStatus' WHERE id = $id";
        $this->query($query);
    }

    /**
     * Get all the category
     * @return array the category
     */
    function getAllCategory()
    {
        $result = $this->query("SELECT name FROM category;");
        $array = pg_fetch_all($result);
        return $array;
    }

    /**
     * Create a new ad
     * @param string $title the title
     * @param string $description the description
     * @param float $price the price
     * @param string $categroy the category
     * @param string $interval the interval
     * @param string $zip the zip
     * @param string $street the street
     * @param string $streetNumber the street number
     * @param int $idProfile the id of the profile
     * @return int the id of the ad
     */
    function createAd($title, $description, $price, $categroy, $interval, $zip, $street, $streetNumber, $idProfile)
    {
        $query = "WITH newAddress AS (INSERT INTO Address (zipCity, street, streetNumber) VALUES ($1, $2, $3) RETURNING id)";

        $query .= "INSERT INTO Advertisement (idAddress, idProfile, creationdate, nameCategory, title, description, price, priceInterval,
        status) VALUES ((SELECT id FROM newAddress), $4, now(), $5, $6, $7, $8, $9, 'ACTIVE') RETURNING id";
        $result = pg_query_params($this->dbconn, $query, array($zip, $street, $streetNumber, $idProfile, $categroy, $title, $description, $price, $interval));
        return pg_fetch_result($result, 0, 0);
    }

    /**
     * Get all the cities
     * @return array the cities
     */
    function getAllCity()
    {
        $result = $this->query("SELECT * FROM city;");
        $array = pg_fetch_all($result);
        return $array;
    }

    /**
     * Get all the canton
     * @return array the canton
     */
    function getAllCanton()
    {
        return $this->getEnum("Canton");
    }

    /**
     * Check if the rental is not rated
     * @param int $idRental the id of the rental
     * @param int $idProfile the id of the profile
     * @return bool true if it is not rated otherwise false
     */
    function checkIfRentalIsNotRated($idRental, $idProfile)
    {
        $query = "SELECT * FROM Rating WHERE idRental=$idRental AND idProfile=$idProfile;";
        $array = pg_fetch_all($this->query($query));
        return !$array;
    }

    /**
     * Rate the rental
     * @param int $idRental the id of the rental
     * @param int $idProfile the id of the profile
     * @param int $rating the rating
     * @param string $comment the comment
     */
    function rateRental($idRental, $idProfile, $rating, $comment)
    {
        if ($comment == "")
            $comment = null;
        $query = "INSERT INTO Rating (idProfile, idRental, rentalRating, comment) VALUES ($1,$2,$3,$4);";
        pg_query_params($this->dbconn, $query, array($idProfile, $idRental, $rating, $comment));
    }

    /**
     * Rate the object
     * @param int $idRental the id of the rental
     * @param int $idProfile the id of the profile
     * @param int $ratingObject the rating of the object
     * @param int $ratingRental the rating of the rental
     * @param string $comment the comment
     */
    function rateObject($idRental, $idProfile, $ratingObject, $ratingRental, $comment)
    {
        if ($comment == "")
            $comment = null;
        $query = "INSERT INTO Rating (idProfile, idRental, rentalRating, objectRATING, comment) VALUES ($1,$2,$3,$4,$5);";
        pg_query_params($this->dbconn, $query, array($idProfile, $idRental, $ratingRental, $ratingObject, $comment));
    }

    /**
     * Update the address
     * @param string $zip the zip
     * @param string $street the street
     * @param string $streetNumber the street number
     * @param int $id the id of the address
     */
    function updateAddress($zip, $street, $streetNumber, $id)
    {
        $query = "UPDATE Address SET zipCity = $1 , street = $2, streetNumber = $3 WHERE id = $4;";
        pg_query_params($this->dbconn, $query, array($zip, $street, $streetNumber, $id));
    }

    /**
     * Modify the ad
     * @param string $title the title
     * @param string $description the description
     * @param float $price the price
     * @param string $category the category
     * @param string $interval the interval
     * @param string $zip the zip
     * @param string $street the street
     * @param string $streetNumber the street number
     * @param int $idAd the id of the ad
     * @param int $idAddr the id of the address
     */
    function modifyAd($title, $description, $price, $category, $interval, $zip, $street, $streetNumber, $idAd, $idAddr)
    {
        $query = "
        WITH updated_ad AS (
            UPDATE Advertisement
            SET title = $1, description = $2, price = $3, priceInterval = $4, nameCategory = $5
            WHERE id = $6
            RETURNING *
        )
        UPDATE Address
        SET zipCity = $7, street = $8, streetNumber = $9
        WHERE id = $10;
        ";

        pg_query_params($this->dbconn, $query, array($title, $description, $price, $interval, $category, $idAd, $zip, $street, $streetNumber, $idAddr));
    }

    /**
     * Add image(s) to an ad
     * @param int $adId the id of the ad
     * @param array $imagePaths the path of the image(s)
     */
    function addImagesToAd($adId, $imagePaths)
    {
        // Convert the array of image paths to a comma-separated string
        $imagePathsStr = implode(',', $imagePaths);

        // Prepare the SQL query with placeholders for parameters
        $query = "UPDATE Advertisement SET pictures = array_append(pictures, $1) WHERE id = $2";

        // Execute the query with pg_query_params
        pg_query_params($this->dbconn, $query, array($imagePathsStr, $adId));
    }

    /**
     * Delete image(s) from an ad
     * @param int $adId the id of the ad
     * @param array $imagePaths the path of the image(s)
     */
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

    /**
     * Update the profile
     * @param string $firstname the firstname
     * @param string $lastname the lastname
     * @param string $mail the mail
     * @param string $phoneNumber the phone number
     * @param string $zipCity the zip
     * @param string $street the street
     * @param string $streetNumber the street number
     * @param int $idProfile the id of the profile
     */
    function updateProfile($firstname, $lastname, $mail, $phoneNumber, $zipCity, $street, $streetNumber, $idProfile)
    {
        $query = "WITH updateProfile AS (UPDATE Profile SET firstname = $1, lastname = $2, mail = $3, phoneNumber = $4 WHERE id = $5 RETURNING id),
              getAddress AS (SELECT addressid AS id FROM vProfile WHERE profileId = $5)";
        $query .= "UPDATE Address SET zipCity = $6 , street = $7, streetNumber = $8 WHERE id = (SELECT id FROM getAddress);";
        pg_query_params($this->dbconn, $query, array($firstname, $lastname, $mail, $phoneNumber, $idProfile, $zipCity, $street, $streetNumber));
    }
    /**
     * Get all the comments of the given ad
     * @param int $idAd the id of the ad
     * @return array the comments
     */
    function getAllCommentsOfProfile($idAd)
    {
        $query = "SELECT firstname, lastname, comment FROM vRatingsComments WHERE id = $idAd AND objectrating IS NOT NULL;";
        $result = $this->query($query);
        return pg_fetch_all($result);
    }
}
