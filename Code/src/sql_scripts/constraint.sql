-- Un User ne peus pas louer ses propres Advertisement

-- On ne peut pas créer un Rental avec le startDate dans le passé (donc après la creationDate). Le startDate d’un Rental doit être avant le endDate. Le paymentDate doit être après la creationDate.

-- Category ne peut pas être une sub-category de lui-même.

-- La creationDate de Rental ne peut pas se situer avant la creationDate de Advertisement

-- La creationDate de Rental ne peut pas se situer avant la registrationDate du User

-- La registrationDate d’un User doit être avant le creationDate d’un Rental d’un User

-- La registrationDate d’un User doit être avant le creationDate d’un Advertisement d’un User

-- Un User peut seulement faire un Rating pour un Rental pour lequel il est le locataire ou le propriétaire de l’Advertisement.

-- La date d’un Rating doit être après la creationDate d’un Rental

-- Un Rating est un smallint et peut seulement avoir une value de 1-5

-- Le User propriétaire d’un Advertisement peut seulement noter rentalRating dans le Rating

-- Le User locataire d’un Rental doit noter le rentalRating et le objectRating dans le Rating

-- Le streetNumber dans Address doit être strictement positif

-- Le price dans Advertisement ne peut pas être négatif

-- Le zip dans City ne peut pas être négatif et doit être 4 chiffres

-- Le phoneNumber dans User doit être dans un format valide ('+41%[0-9]{9}')

-- Le mail dans User doit être dans un format valide ('%@%.%')