DROP TYPE IF EXISTS Status CASCADE;
CREATE TYPE Status AS ENUM (
    'ACTIVE',
    'INACTIVE',
    'DELETED'
    );

DROP TYPE IF EXISTS PaymentMethod CASCADE;
CREATE TYPE PaymentMethod AS ENUM (
    'TWINT',
    'CASH'
    );

DROP TYPE IF EXISTS StatusRental CASCADE;
CREATE TYPE StatusRental AS ENUM (
    'RESERVATION_ASKED',
    'RESERVATION_CONFIRMED',
    'RESERVATION_CANCELED',
    'LOCATION_ONGOING',
    'ITEM_RETURNED',
    'LOCATION_CANCELED',
    'LOCATION_FINISHED'
    );

DROP TYPE IF EXISTS PriceInterval CASCADE;
CREATE TYPE PriceInterval AS ENUM (
    'DAY',
    'WEEK',
    'MONTH'
    );

DROP TYPE IF EXISTS Canton CASCADE;
CREATE TYPE Canton AS ENUM (
    'AG',
    'AI',
    'AR',
    'BE',
    'BL',
    'BS',
    'FR',
    'GE',
    'GL',
    'GR',
    'JU',
    'LU',
    'NE',
    'NW',
    'OW',
    'SG',
    'SH',
    'SO',
    'SZ',
    'TG',
    'TI',
    'UR',
    'VD',
    'VS',
    'ZG',
    'ZH'
    );

DROP TABLE IF EXISTS City CASCADE;
CREATE TABLE City
(
    zip    int,
    name   varchar(80) NOT NULL,
    canton Canton      NOT NULL,

    CONSTRAINT PK_City PRIMARY KEY (zip),
    CONSTRAINT CK_ZIP CHECK (zip >= 1000 AND zip <= 9999)
);

DROP TABLE IF EXISTS Address CASCADE;
CREATE TABLE Address
(
    id           serial,
    zipCity      int         NOT NULL,
    street       varchar(80) NOT NULL,
    streetNumber varchar(5),

    CONSTRAINT PK_Address PRIMARY KEY (id),
    CONSTRAINT CK_Address_streetNumber check (streetNumber SIMILAR TO '[0-9]{1,3}[a-zA-z]?'),
    CONSTRAINT FK_Address_idZip FOREIGN KEY (zipCity)
        REFERENCES City (zip)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT
);

DROP TABLE IF EXISTS Category CASCADE;
CREATE TABLE Category
(
    name           varchar(80),
    parentCategory varchar(80),

    CONSTRAINT PK_Category PRIMARY KEY (name),
    CONSTRAINT FK_Category FOREIGN KEY (parentCategory)
        REFERENCES Category (name)
        ON UPDATE CASCADE
        ON DELETE SET NULL
);

DROP TABLE IF EXISTS Profile CASCADE;
CREATE TABLE Profile
(
    id               serial,
    idAddress        int,
    registrationDate timestamp   NOT NULL DEFAULT CURRENT_TIMESTAMP,
    firstname        varchar(80) NOT NULL,
    lastname         varchar(80) NOT NULL,
    mail             varchar(80) NOT NULL,
    password         varchar(80) NOT NULL,
    phoneNumber      varchar(20) NOT NULL,
    status           Status      NOT NULL,

    CONSTRAINT PK_Profile PRIMARY KEY (id),
    CONSTRAINT FK_Profile_Address FOREIGN KEY (idAddress)
        REFERENCES Address (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT CK_mail CHECK (mail like '%@%.%')
);

DROP TABLE IF EXISTS Advertisement CASCADE;
CREATE TABLE Advertisement
(
    id            serial,
    idAddress     integer       NOT NULL,
    idProfile     integer       NOT NULL,
    nameCategory  varchar(80)   NOT NULL,
    creationDate  timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    title         varchar(80)   NOT NULL,
    description   text          NOT NULL,
    price         real          NOT NULL CHECK (price >= 0),
    priceInterval PriceInterval NOT NULL,
    status        Status        NOT NULL,
    pictures      text[],

    CONSTRAINT PK_Advertisement PRIMARY KEY (id),
    CONSTRAINT FK_Advertisement_idAddress FOREIGN KEY (idAddress)
        REFERENCES Address (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT FK_Advertisement_idProfile FOREIGN KEY (idProfile)
        REFERENCES Profile (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT FK_Advertisement_nameCategory FOREIGN KEY (nameCategory)
        REFERENCES Category (name)
        ON UPDATE CASCADE
        ON DELETE CASCADE, --Not sure about this one really, maybe should just be null
    CONSTRAINT CK_creationDate CHECK (creationDate <= CURRENT_TIMESTAMP)
);

DROP TABLE IF EXISTS Rental CASCADE;
CREATE TABLE Rental
(
    id              serial,
    idProfile       int           NOT NULL,
    idAdvertisement int           NOT NULL,
    creationDate    timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    startDate       timestamp     NOT NULL,
    endDate         timestamp     NOT NULL,
    paymentDate     timestamp,
    comment         text,
    statusRental    StatusRental  NOT NULL,
    paymentMethod   PaymentMethod NOT NULL,
    price           real          NOT NULL CHECK (price >= 0),

    CONSTRAINT PK_Rental PRIMARY KEY (id),
    CONSTRAINT FK_Rental_Profile FOREIGN KEY (idProfile)
        REFERENCES Profile (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT FK_Rental_Advertisement FOREIGN KEY (idAdvertisement)
        REFERENCES Advertisement (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT CK_creationDate CHECK (creationDate <= CURRENT_TIMESTAMP),
    CONSTRAINT CK_startDate CHECK (startDate >= creationDate),
    CONSTRAINT CK_endDate CHECK (endDate > startDate),
    CONSTRAINT CK_paymentDate CHECK (paymentDate >= creationDate)
);

DROP TABLE IF EXISTS Rating CASCADE;
CREATE TABLE Rating
(
    id           serial,
    idProfile    int       NOT NULL,
    idRental     int       NOT NULL,
    ratingDate   timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    rentalRating smallint  NOT NULL,
    objectRATING smallint,
    comment      text,

    CONSTRAINT PK_Rating PRIMARY KEY (id),
    CONSTRAINT FK_Rating_Profile FOREIGN KEY (idProfile)
        REFERENCES Profile (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT FK_Rating_Rental FOREIGN KEY (idRental)
        REFERENCES Rental (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT CK_rentalRating CHECK (rentalRating > 0 AND rentalRating < 6),
    CONSTRAINT CK_objectRating CHECK (objectRating > 0 AND objectRating < 6)
);

-- VIEWS --
CREATE OR REPLACE VIEW vAds AS
SELECT Ad.id                    AS id,
       Ad.idProfile             as idProfile,
       Ad.title                 AS title,
       Ad.price                 AS price,
       Ad.description           AS description,
       Ad.priceinterval         AS priceinterval,
       Ad.nameCategory          AS nameCategory,
       Address.id               AS idaddr,
       Address.zipCity          AS zipCity,
       Address.street           AS street,
       Address.streetNumber     AS streetNumber,
       Ad.pictures              AS pictures,
       City.name                AS city,
       City.Canton              AS canton,
       Ad.creationDate          AS creationDate,
       Ad.status                AS status,
       avg(Rating.objectrating) AS ratingAvg
FROM Advertisement AS Ad
         INNER JOIN Address ON Ad.idAddress = Address.id
         INNER JOIN City ON Address.zipCity = City.zip
         LEFT JOIN Rental ON Rental.idAdvertisement = Ad.id
         LEFT JOIN Rating ON Rating.idRental = Rental.id
GROUP BY Ad.id, Address.id, City.name, City.canton;


CREATE OR REPLACE PROCEDURE insertRental(idProfile integer, idAdvertisement integer, startDate timestamp,
                                         endDate timestamp, comment text, statusRental StatusRental,
                                         paymentMethod PaymentMethod)
    LANGUAGE plpgsql
AS
$$
DECLARE
    dateDifference  Interval = endDate - startDate;
    totalPrice      integer;
    priceAd         integer;
    priceIntervalAd PriceInterval;
BEGIN
    SELECT A.price, A.priceInterval FROM Advertisement AS A WHERE A.id = idAdvertisement INTO priceAd, priceIntervalAd;
    -- if date difference isn't in days exact but in hours, add 23h59:59'
    IF DATE_PART('hour', dateDifference) != 0 THEN
        dateDifference := dateDifference + '1 day'::interval - '1 second'::interval;
    END IF;

    IF priceIntervalAd = 'DAY'::PriceInterval THEN
        totalPrice := priceAd * DATE_PART('day', dateDifference);
    ELSIF priceIntervalAd = 'WEEK'::PriceInterval THEN
        totalPrice := priceAd * CEILING(DATE_PART('day', dateDifference) / 7);
    ELSIF priceIntervalAd = 'MONTH'::PriceInterval THEN
        totalPrice := priceAd * CEILING(DATE_PART('day', dateDifference) / 30);
    END IF;

    INSERT INTO Rental (idProfile, idAdvertisement, startDate, endDate, comment, statusRental,
                        paymentMethod, price)
    VALUES (idProfile, idAdvertisement, startDate, endDate, comment, statusRental, paymentMethod,
            totalPrice);
END
$$;

CREATE OR REPLACE VIEW vRatingsComments AS
SELECT Rental.idAdvertisement AS id,
       Rating.objectrating,
       Profile.firstname,
       Profile.lastname,
       Rental.comment
FROM Rating
         INNER JOIN Rental ON Rental.id = Rating.idRental
         INNER JOIN Profile ON Profile.id = Rating.idProfile;

CREATE OR REPLACE VIEW vRentalInfo AS
SELECT POwner.mail      AS ownermail,
       PRenter.mail     AS rentermail,
       Ad.idprofile     AS idowner,
       Rental.id        AS rentalId,
       Ad.id            AS adid,
       Ad.title,
       Rental.startDate,
       Rental.endDate,
       Rental.statusrental,
       Rental.idprofile AS rentidowner,
       Ad.description,
       Rental.comment,
       Rental.paymentMethod,
       Rental.paymentdate,
       Rental.price
from Rental
         INNER JOIN Advertisement AS Ad ON Rental.idAdvertisement = Ad.id
         INNER JOIN Profile AS POwner ON POwner.id = Ad.idprofile
         INNER JOIN Profile AS PRenter ON PRenter.id = Rental.idprofile;

CREATE OR REPLACE VIEW vRentals AS
SELECT Rental.id        AS idRental,
       Ad.id            AS idAd,
       Rental.idProfile AS idRenter,
       Ad.idProfile     AS idOwner,
       Ad.title,
       Rental.startDate,
       Rental.endDate,
       Rental.idProfile
FROM Rental
         INNER JOIN advertisement AS Ad ON Rental.idAdvertisement = Ad.id;


CREATE OR REPLACE VIEW vProfile AS
SELECT Profile.id      AS profileId,
       Profile.firstname,
       Profile.lastname,
       Profile.mail,
       Profile.phoneNumber,
       Address.id      AS addressId,
       Address.zipCity AS zip,
       Address.street,
       Address.streetNumber,
       City.name
FROM Profile
         INNER JOIN Address ON Profile.idAddress = Address.id
         INNER JOIN City ON Address.zipCity = City.zip;



-- TRIGGER ON VIEW UPDATE --
CREATE OR REPLACE FUNCTION updateAdFromView() RETURNS TRIGGER
    LANGUAGE plpgsql
AS
$$
BEGIN
    IF TG_OP = 'INSERT' THEN
        INSERT INTO advertisement
        VALUES (NEW.idaddr, NEW.idprofile, NEW.creationdate, NEW.namecategory, NEW.title, NEW.description, NEW.price,
                NEW.priceinterval, NEW.status);
        INSERT INTO Address VALUES (NEW.zipcity, NEW.street, NEW.streetnumber);
    ELSEIF TG_OP = 'UPDATE' THEN
        UPDATE Advertisement
        SET idAddress     = NEW.idaddr,
            idProfile     = NEW.idprofile,
            creationdate  = NEW.creationdate,
            nameCategory  = NEW.namecategory,
            title         = NEW.title,
            description   = NEW.description,
            price         = NEW.price,
            priceinterval = NEW.priceinterval,
            status        = NEW.status
        WHERE id = NEW.id;
        UPDATE Address
        SET zipCity      = NEW.zipcity,
            street       = NEW.street,
            streetNumber = NEW.streetnumber
        WHERE id = NEW.idaddr;
    ELSEIF TG_OP = 'DELETE' THEN
        DELETE FROM Advertisement WHERE id = OLD.id;
        DELETE FROM Address WHERE id = OLD.idaddr;
    END IF;
    RETURN NEW;
END
$$;
CREATE OR REPLACE TRIGGER vAdTrigger
    INSTEAD OF INSERT OR UPDATE OR DELETE
    ON vAds
    FOR EACH ROW
EXECUTE FUNCTION updateAdFromView();

CREATE OR REPLACE FUNCTION updateProfileFromView() RETURNS TRIGGER
    LANGUAGE plpgsql
AS
$$
BEGIN
    IF TG_OP = 'INSERT' THEN
    ELSEIF TG_OP = 'UPDATE' THEN
        UPDATE Profile
        SET idAddress = NEW.addressid,
            firstname = NEW.firstname,
            lastname  = NEW.lastname,
            mail      = NEW.mail
        WHERE id = NEW.profileId;
        UPDATE Address
        SET zipCity      = NEW.zip,
            street       = NEW.street,
            streetNumber = NEW.streetnumber
        WHERE id = NEW.addressId;
        UPDATE City
        SET name = NEW.name
        WHERE zip = NEW.zip;
    END IF;
    RETURN NEW;
END
$$;
CREATE OR REPLACE TRIGGER vProfileTrigger
    INSTEAD OF INSERT OR UPDATE OR DELETE
    ON vProfile
    FOR EACH ROW
EXECUTE FUNCTION updateProfileFromView();


-- CONTRAINTS --

-- La creationDate d’un Advertisement ne peut pas se situer avant la registrationDate du User
CREATE OR REPLACE FUNCTION chkAdvertisement() RETURNS TRIGGER
    LANGUAGE plpgsql
AS
$$
BEGIN
    IF NEW.creationDate < (SELECT registrationDate FROM Profile WHERE id = NEW.idProfile) THEN
        RAISE EXCEPTION 'Advertisement creation date is before its owner registration date';
    END IF;
    RETURN NULL;
END
$$;

CREATE CONSTRAINT TRIGGER checkAdvertisement
    AFTER INSERT
    ON Advertisement
    DEFERRABLE INITIALLY DEFERRED
    FOR EACH ROW
EXECUTE FUNCTION chkAdvertisement();


-- Category ne peut pas être une sub-category de lui-même.
CREATE OR REPLACE FUNCTION chkCategory() RETURNS TRIGGER
    LANGUAGE plpgsql
AS
$$
BEGIN
    IF NEW.name = NEW.parentcategory THEN
        RAISE EXCEPTION 'Category cannot be a sub-category of itself';
    END IF;
    RETURN NULL;
END
$$;

CREATE CONSTRAINT TRIGGER checkCategory
    AFTER INSERT
    ON Category
    DEFERRABLE INITIALLY DEFERRED
    FOR EACH ROW
EXECUTE FUNCTION chkCategory();


-- Un User ne peut pas louer ses propres Advertisement
-- La creationDate d’un Rental ne peut pas se situer avant la creationDate de l’Advertisement
-- La creationDate d’un Rental ne peut pas se situer avant la registrationDate du User
CREATE OR REPLACE FUNCTION chkRental() RETURNS TRIGGER
    LANGUAGE plpgsql
AS
$$
BEGIN
    IF NEW.creationDate < (SELECT creationDate FROM Advertisement WHERE id = NEW.idAdvertisement) THEN
        RAISE EXCEPTION 'Rental creation date is before its advertisement creation date';
    END IF;
    IF NEW.creationDate < (SELECT registrationDate FROM Profile WHERE id = NEW.idProfile) THEN
        RAISE EXCEPTION 'Rental creation date is before its owner registration date';
    END IF;
    IF (SELECT idprofile FROM Advertisement WHERE id = NEW.idAdvertisement) = NEW.idProfile THEN
        RAISE EXCEPTION 'Cannot rent your own advertisement';
    END IF;
    RETURN NULL;
END;
$$;

CREATE CONSTRAINT TRIGGER checkRental
    AFTER INSERT
    ON Rental
    DEFERRABLE INITIALLY DEFERRED
    FOR EACH ROW
EXECUTE FUNCTION chkRental();


-- Un User peut seulement faire un Rating pour un Rental pour lequel il est le locataire ou le propriétaire de l’Advertisement.
-- La date d’un Rating doit être après la creationDate d’un Rental
-- Le User propriétaire d’un Advertisement peut seulement noter rentalRating dans le Rating
-- Le User locataire d’un Rental doit noter le rentalRating et le objectRating dans le Rating
CREATE OR REPLACE FUNCTION chkRating() RETURNS TRIGGER
    LANGUAGE plpgsql
AS
$$
BEGIN
    IF (SELECT idprofile FROM Rental WHERE id = NEW.idRental) != NEW.idProfile AND
       (SELECT A.idprofile
        FROM Rental AS R
                 INNER JOIN advertisement AS A ON R.idAdvertisement = A.id
        WHERE R.id = NEW.idRental) != NEW.idProfile THEN
        RAISE EXCEPTION 'Cannot rate Rental where user is not involved as a owner or customer';
    END IF;
    IF NEW.ratingdate < (SELECT creationDate FROM Rental WHERE id = NEW.idRental) THEN
        RAISE EXCEPTION 'Rating creation date is before its rental creation date';
    END IF;
    IF (SELECT idprofile FROM Rental WHERE id = NEW.idRental) = NEW.idProfile THEN
        IF NEW.rentalRating IS NULL THEN
            RAISE EXCEPTION 'Rental rating cannot be null';
        END IF;
        IF NEW.objectRating IS NULL THEN
            RAISE EXCEPTION 'Object rating cannot be null';
        END IF;
    ELSE
        IF NEW.rentalRating IS NULL THEN
            RAISE EXCEPTION 'Rental rating cannot be null';
        END IF;
        IF NEW.objectRating IS NOT NULL THEN
            RAISE EXCEPTION 'Object rating must be null';
        END IF;
    END IF;
    RETURN NULL;
END;
$$;

CREATE CONSTRAINT TRIGGER checkRating
    AFTER INSERT
    ON Rating
    DEFERRABLE INITIALLY DEFERRED
    FOR EACH ROW
EXECUTE FUNCTION chkRating();
