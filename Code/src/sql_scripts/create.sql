
CREATE TYPE IF NOT EXISTS Status AS ENUM (
    'ACTIVE',
    'INACTIVE',
    'DELETED'
)

CREATE TYPE IF NOT EXISTS PaymentMethod AS ENUM (
    'TWINT',
    'CASH'
)

CREATE TYPE IF NOT EXISTS StatusRental AS ENUM (
    'RESERVATION_ASKED',
    'RESERVATION_CONFIRMED',
    'RESERVATION_CANCELED',
    'LOCATION_ONGOING',
    'ITEM_RETURNED',
    'LOCATION_CANCELED',
    'LOCATION_FINISHED'
)

CREATE TYPE IF NOT EXISTS Canton AS ENUM (
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
)

CREATE TABLE IF NOT EXISTS City (
    id serial,
    name varchar(80),
    canton varchar(80),

    CONSTRAINT PK_City PRIMARY KEY(id)
);

CREATE TABLE IF NOT EXISTS Address (
    id serial,
    idZip int NOT NULL,
    street varchar(80),
    streetNumber smallint

    CONSTRAINT PK_Adress PRIMARY KEY (id)
    CONSTRAINT FK_Address_idZip FOREIGN KEY (idZip)
        REFERENCES City (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT
);

CREATE TABLE IF NOT EXISTS Category (
    name varchar(80),
    parentCategory varchar(80),

    CONSTRAINT PK_Category PRIMARY KEY (name),
    CONSTRAINT FK_Category FOREIGN KEY (parentCategory)
        REFERENCES Category (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
);

CREATE TABLE IF NOT EXISTS User (
    id serial,
    idAddress int,
    registrationDate timestamp NOT NULL,
    firstname varchar(80) NOT NULL,
    lastname varchar(80) NOT NULL,
    mail varchar(80) NOT NULL,
    password varchar (80) NOT NULL,
    phoneNumber varchar (20) NOT NULL,
    status Status NOT NULL,


    CONSTRAINT PK_User PRIMARY KEY (id),
    CONSTRAINT FK_User_Address FOREIGN KEY (idAddress)
        REFERENCES Address (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT
    CONSTRAINT DF_User_RegistrationDate Default (registrationDate) getdate()
)


CREATE TABLE IS NOT EXISTS Advertisement (
    id serial,
    idAddress integer NOT NULL,
    idUser integer NOT NULL,
    nameCategory integer NOT NULL,
    creationDate timestamp NOT NULL,
    title varchar(80) NOT NULL,
    -- TODO: add description, priceInfo, status

    CONSTRAINT PK_Advertisement PRIMARY KEY (id)
    CONSTRAINT FK_Advertisement_idAddress FOREIGN KEY (idAddress)
    REFERENCES Address (id)
    ON UPDATE RESTRICT
    ON DELETE RESTRICT
    CONSTRAINT FK_Advertisement_idUser FOREIGN KEY (idUser)
    REFERENCES User (id)
    ON UPDATE RESTRICT
    ON DELETE RESTRICT
    CONSTRAINT FK_Advertisement_nameCategory FOREIGN KEY (nameCategory)
    REFERENCES Category (name)
    ON UPDATE RESTRICT
    ON DELETE RESTRICT
    CONSTRAINT DF_Advertisement_CreationDate Default (CreationDate) getdate()
    );

CREATE TABLE IF NOT EXISTS Rental (
    id serial,
    idUser int NOT NULL,
    idAdvertisement int NOT NULL,
    creationDate timestamp NOT NULL,
    startDate timestamp NOT NULL,
    endDate timestamp NOT NULL,
    paymentDate timestamp,
    comment text,
    statusRental StatusRental NOT NULL,
    paymentMethod PaymentMethod NOT NULL,

    CONSTRAINT PK_Rental PRIMARY KEY (id),
    CONSTRAINT FK_Rental_User FOREIGN KEY (idUser)
        REFERENCES User (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT FK_Rental_Advertisement FOREIGN KEY (idAdvertisement)
        REFERENCES Advertisement (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT DF_Rental_CreationDate Default (creationDate) getdate()
)

CREATE TABLE IF NOT EXISTS Rating (
    id serial,
    idUser int NOT NULL,
    idRental int NOT NULL,
    ratingDate timestamp NOT NULL,
    rentalRating smallint NOT NULL,
    objectRATING smallint,

    CONSTRAINT PK_Rating PRIMARY KEY (id),
    CONSTRAINT FK_Rating_User FOREIGN KEY (idUser)
        REFERENCES User (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT FK_Rating_Rental FOREIGN KEY (idRental)
        REFERENCES Rental (id)
        ON UPDATE RESTRICT
        ON DELETE RESTRICT,
    CONSTRAINT DF_Rating_Date Default (ratingDate) getdate()
)