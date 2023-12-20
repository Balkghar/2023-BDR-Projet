-- Un Profile ne peut pas louer ses propres Advertisement

-- Category ne peut pas être une sub-category de lui-même.

-- La creationDate de Rental ne peut pas se situer avant la creationDate de Advertisement
CREATE OR REPLACE FUNCTION chkRentalDate() RETURNS TRIGGER
    LANGUAGE plpgsql
AS $$
    DECLARE creationDateAdv timestamp;
BEGIN
    SELECT A.creationdate FROM Advertisement AS A WHERE A.id = NEW.idAdvertisement INTO creationDateAdv;
    IF NEW.cretionDate < creationDateAdv THEN
        RAISE EXCEPTION 'Rental creation date is before its advertisement creation date';
    END IF;
END;
$$;

CREATE CONSTRAINT TRIGGER checkRentalAdvertCreation AFTER INSERT ON Rental
    DEFERRABLE INITIALLY DEFERRED
    FOR EACH ROW EXECUTE FUNCTION chkRentalDate()

-- La creationDate de Rental ne peut pas se situer avant la registrationDate du Profile

-- La registrationDate d’un Profile doit être avant le creationDate d’un Rental d’un Profile

-- La registrationDate d’un Profile doit être avant le creationDate d’un Advertisement d’un Profile

-- Un Profile peut seulement faire un Rating pour un Rental pour lequel il est le locataire ou le propriétaire de l’Advertisement.

-- La date d’un Rating doit être après la creationDate d’un Rental

-- Le Profile propriétaire d’un Advertisement peut seulement noter rentalRating dans le Rating

-- Le Profile locataire d’un Rental doit noter le rentalRating et le objectRating dans le Rating

-- Le streetNumber dans Address doit être strictement positif

-- Le price dans Advertisement ne peut pas être négatif
