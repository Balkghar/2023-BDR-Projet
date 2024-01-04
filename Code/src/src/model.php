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
        $result = $this->query("select Ad.id as id,
                                Ad.idProfile as idProfile, 
                                Ad.title as title, 
                                Ad.price as price, 
                                Ad.description as description, 
                                Ad.priceinterval as priceinterval, 
                                Ad.nameCategory as nameCategory,
                                Ad.status as status,
                                Ad.pictures as pictures,
                                Adr.zipCity as zipCity,
                                Adr.id as idAdrr,
                                Adr.street as street,
                                Adr.streetNumber as streetNumber,
                                Cit.Canton as canton,
                                Ad.creationDate as creationDate
                                from advertisement as Ad
                                INNER JOIN Address as Adr ON Ad.idAddress = Adr.id
                                INNER JOIN City as Cit ON Adr.zipCity = Cit.zip
                                WHERE Ad.id=$index;");
        $array = pg_fetch_all($result);
        $array[0]['avg'] = pg_fetch_all($this->query("SELECT avg(Ra.objectrating) FROM Rental as Re INNER JOIN Rating as Ra ON Ra.idRental = Re.id WHERE Re.idAdvertisement = " . $array[0]['id'] . ";"))[0]['avg'];
        return $array[0];
    }

    function getAllAdsFromUser($index)
    {
        $result = $this->query("select * from advertisement WHERE idProfile = $index AND status != 'DELETED' ORDER BY creationDate DESC;;");
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

    // TODO : il faut améliorer cette requête, peut être une vue ou quelque chose du genre 
    function getAllAds($search, $category, $canton, $zip)
    {
        $query = "select Ad.id as id, 
        Ad.title as title, 
        Ad.price as price, 
        Ad.description as description, 
        Ad.priceinterval as priceinterval, 
        Ad.nameCategory as nameCategory,
        Adr.zipCity as zipCity,
        Adr.street as street,
        Adr.streetNumber as streetNumber,
        Ad.pictures as pictures,
        Cit.Canton as canton,
        Ad.creationDate as creationDate
        from advertisement as Ad
        INNER JOIN Address as Adr ON Ad.idAddress = Adr.id
        INNER JOIN City as Cit ON Adr.zipCity = Cit.zip
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
        foreach ($array as &$ad) {
            $ad['avg'] = pg_fetch_all($this->query("SELECT avg(Ra.objectrating) FROM Rental as Re INNER JOIN Rating as Ra ON Ra.idRental = Re.id WHERE Re.idAdvertisement = " . $ad['id'] . ";"))[0]['avg'];
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
        $query = $this->query("Select POwner.mail AS ownermail, PRenter.mail AS rentermail, A.idprofile as idowner ,R.id as rentalId, A.id as adid, A.title, R.startDate, R.endDate, statusrental, R.idprofile as rentidowner, A.description, R.comment, R.paymentMethod, R.paymentdate from Rental AS R 
                                INNER JOIN advertisement AS A ON R.idAdvertisement = A.id
                                INNER JOIN Profile as POwner ON POwner.id = A.idprofile
                                INNER JOIN Profile as PRenter ON PRenter.id = R.idprofile
                                WHERE R.id=$index;");
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
        $result = $this->query("Select R.id as rentalId, A.id, A.title, R.startDate, R.endDate from Rental AS R 
                                INNER JOIN advertisement AS A ON R.idAdvertisement = A.id
                                WHERE R.idProfile = $userId;");
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
    function getAllCategory()
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
    function rateRental($idRental, $idProfile, $rating)
    {
        $query = "INSERT INTO Rating (idProfile, idRental, rentalRating) VALUES ($1,$2,$3);";
        pg_query_params($this->dbconn, $query, array($idProfile, $idRental, $rating));
    }
    function rateObject($idRental, $idProfile, $ratingObject, $ratingRental)
    {
        $query = "INSERT INTO Rating (idProfile, idRental, rentalRating, objectRATING) VALUES ($1,$2,$3,$4);";
        pg_query_params($this->dbconn, $query, array($idProfile, $idRental, $ratingRental, $ratingObject));
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
    function deleteImageFromAd($adId, $imagePath)
    {

        // Construct the SQL query to update the pictures array
        $sql = "UPDATE Advertisement SET pictures = array_remove(pictures, '$imagePath') WHERE id = $adId;";
        // Execute the query
        $this->query($sql);
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
}
