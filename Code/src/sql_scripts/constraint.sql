-- Un User ne peut pas louer ses propres Advertisement

-- Category ne peut pas être une sub-category de lui-même.

-- La creationDate de Rental ne peut pas se situer avant la creationDate de Advertisement
CREATE OR REPLACE FUNCTION chkDateCongruence() RETURNS TRIGGER
    LANGUAGE plpgsql
AS $$
BEGIN
    IF NEW.creationDate < (SELECT creationDate FROM Advertisement WHERE id = NEW.idAdvertisement) THEN
        RAISE EXCEPTION 'Rental creation date is before its advertisement creation date';
    END IF;
END;
$$;

CREATE CONSTRAINT TRIGGER checkRentalAdvertDate AFTER INSERT ON Rental
    DEFERRABLE INITIALLY DEFERRED
    FOR EACH ROW EXECUTE FUNCTION chkDateCongruence();


-- La creationDate de Rental ne peut pas se situer avant la registrationDate du User
CREATE CONSTRAINT TRIGGER checkRentalUserDate AFTER INSERT ON rental
    DEFERRABLE INITIALLY DEFERRED
    FOR EACH ROW EXECUTE FUNCTION chkDateCongruence();

-- La registrationDate d’un User doit être avant le creationDate d’un Rental d’un User

-- La registrationDate d’un User doit être avant le creationDate d’un Advertisement d’un User

-- Un User peut seulement faire un Rating pour un Rental pour lequel il est le locataire ou le propriétaire de l’Advertisement.
--TODO: WIP
CREATE OR REPLACE FUNCTION chkRating() RETURNS TRIGGER
    LANGUAGE plpgsql
AS $$
BEGIN
    IF (SELECT idProfile FROM Rental) != NEW.idProfile THEN
        RAISE EXCEPTION  'Cannot rates Rental where user not part of';
    end if;
END
$$;

CREATE CONSTRAINT TRIGGER checkRating AFTER INSERT ON Rating
    DEFERRABLE INITIALLY DEFERRED
    FOR EACH ROW EXECUTE FUNCTION chkRating();

-- La date d’un Rating doit être après la creationDate d’un Rental

-- Le User propriétaire d’un Advertisement peut seulement noter rentalRating dans le Rating

-- Le User locataire d’un Rental doit noter le rentalRating et le objectRating dans le Rating

-- Le streetNumber dans Address doit être strictement positif

-- Le price dans Advertisement ne peut pas être négatif