-- Un User ne peut pas louer ses propres Advertisement

-- Category ne peut pas être une sub-category de lui-même.

-- La creationDate d’un Rental ne peut pas se situer avant la creationDate de l’Advertisement
CREATE OR REPLACE FUNCTION chkDateCongruence() RETURNS TRIGGER
    LANGUAGE plpgsql
AS
$$
BEGIN
    IF NEW.creationDate < (SELECT creationDate FROM Advertisement WHERE id = NEW.idAdvertisement) THEN
        RAISE EXCEPTION 'Rental creation date is before its advertisement creation date';
    END IF;
END;
$$;

CREATE CONSTRAINT TRIGGER checkRentalAdvertDate
    AFTER INSERT
    ON Rental
    DEFERRABLE INITIALLY DEFERRED
    FOR EACH ROW
EXECUTE FUNCTION chkDateCongruence();


-- La creationDate d’un Rental ne peut pas se situer avant la registrationDate du User
CREATE CONSTRAINT TRIGGER checkRentalUserDate
    AFTER INSERT
    ON rental
    DEFERRABLE INITIALLY DEFERRED
    FOR EACH ROW
EXECUTE FUNCTION chkDateCongruence();

-- La creationDate d’un Advertisement ne peut pas se situer avant la registrationDate du User
CREATE OR REPLACE FUNCTION chkDateAdvertisement() RETURNS TRIGGER
    LANGUAGE plpgsql
AS
$$
BEGIN
    IF NEW.creationDate < (SELECT registrationDate FROM Profile WHERE id = NEW.idProfile) THEN
        RAISE EXCEPTION 'Advertisement creation date is before its owner registration date';
    END IF;
END
$$;

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
    IF NEW.creationDate < (SELECT creationDate FROM Rental WHERE id = NEW.idRental) THEN
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
    END;
$$;

CREATE CONSTRAINT TRIGGER checkRating
    AFTER INSERT
    ON Rating
    DEFERRABLE INITIALLY DEFERRED
    FOR EACH ROW
EXECUTE FUNCTION chkRating();
