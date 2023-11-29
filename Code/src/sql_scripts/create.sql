DROP TYPE IF EXISTS Status;
CREATE TYPE Status AS ENUM (
    'ACTIVE',
    'INACTIVE',
    'DELETED'
    );

DROP TYPE IF EXISTS PaymentMethod;
CREATE TYPE PaymentMethod AS ENUM (
    'TWINT',
    'CASH'
    );

DROP TYPE IF EXISTS StatusRental;
CREATE TYPE StatusRental AS ENUM (
    'RESERVATION_ASKED',
    'RESERVATION_CONFIRMED',
    'RESERVATION_CANCELED',
    'LOCATION_ONGOING',
    'ITEM_RETURNED',
    'LOCATION_CANCELED',
    'LOCATION_FINISHED'
    );

DROP TYPE IF EXISTS PriceInterval;
CREATE TYPE PriceInterval AS ENUM (
    'DAY',
    'WEEK',
    'MONTH'
    );

DROP TYPE IF EXISTS Canton;
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
    CONSTRAINT CK_ZIP CHECK (zip >= 1000 && zip <= 9999)
);

DROP TABLE IF EXISTS Address CASCADE;
CREATE TABLE Address
(
    id           serial,
    zipCity      int NOT NULL,
    street       varchar(80),
    streetNumber smallint CHECK (streetNumber > 0),

    CONSTRAINT PK_Address PRIMARY KEY (id),
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
        ON UPDATE RESTRICT
        ON DELETE RESTRICT
);

DROP TABLE IF EXISTS "User" CASCADE;
CREATE TABLE "User"
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

    CONSTRAINT PK_User PRIMARY KEY (id),
    CONSTRAINT FK_User_Address FOREIGN KEY (idAddress)
        REFERENCES Address (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT CK_mail CHECK (mail like '%@%.%'),
    CONSTRAINT CK_phoneNumber CHECK (phoneNumber like '+41%[0-9]{9}')
);

DROP TABLE IF EXISTS Advertisement CASCADE;
CREATE TABLE Advertisement
(
    id            serial,
    idAddress     integer       NOT NULL,
    idUser        integer       NOT NULL,
    nameCategory  integer       NOT NULL,
    creationDate  timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    title         varchar(80)   NOT NULL,
    description   text          NOT NULL,
    price         real          NOT NULL CHECK (price >= 0),
    priceInterval PriceInterval NOT NULL,
    status        Status        NOT NULL,

    CONSTRAINT PK_Advertisement PRIMARY KEY (id),
    CONSTRAINT FK_Advertisement_idAddress FOREIGN KEY (idAddress)
        REFERENCES Address (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT FK_Advertisement_idUser FOREIGN KEY (idUser)
        REFERENCES "User" (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT FK_Advertisement_nameCategory FOREIGN KEY (nameCategory)
        REFERENCES Category (name)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT CK_creationDate CHECK (creationDate >= CURRENT_TIMESTAMP)
);

DROP TABLE IF EXISTS Rental CASCADE;
CREATE TABLE Rental
(
    id              serial,
    idUser          int           NOT NULL,
    idAdvertisement int           NOT NULL,
    creationDate    timestamp     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    startDate       timestamp     NOT NULL,
    endDate         timestamp     NOT NULL,
    paymentDate     timestamp,
    comment         text,
    statusRental    StatusRental  NOT NULL,
    paymentMethod   PaymentMethod NOT NULL,

    CONSTRAINT PK_Rental PRIMARY KEY (id),
    CONSTRAINT FK_Rental_User FOREIGN KEY (idUser)
        REFERENCES "User" (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT FK_Rental_Advertisement FOREIGN KEY (idAdvertisement)
        REFERENCES Advertisement (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT CK_creationDate CHECK (creationDate >= CURRENT_TIMESTAMP),
    CONSTRAINT CK_startDate CHECK (startDate >= CURRENT_TIMESTAMP),
    CONSTRAINT CK_endDate CHECK (endDate > startDate)
);

DROP TABLE IF EXISTS Rating CASCADE;
CREATE TABLE Rating
(
    id           serial,
    idUser       int       NOT NULL,
    idRental     int       NOT NULL,
    ratingDate   timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    rentalRating smallint  NOT NULL,
    objectRATING smallint,
    CONSTRAINT PK_Rating PRIMARY KEY (id),
    CONSTRAINT FK_Rating_User FOREIGN KEY (idUser)
        REFERENCES "User" (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT FK_Rating_Rental FOREIGN KEY (idRental)
        REFERENCES Rental (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT CK_rentalRating CHECK (rentalRating > 0 && rentalRating < 6),
    CONSTRAINT CK_objectRating CHECK (objectRating > 0 && objectRating < 6)
);