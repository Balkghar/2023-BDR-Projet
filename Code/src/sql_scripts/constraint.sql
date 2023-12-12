-- Un User ne peut pas louer ses propres Advertisement

-- Le startDate d’un Rental doit être avant le endDate. Le paymentDate doit être après la creationDate.

-- Category ne peut pas être une sub-category de lui-même.

-- La creationDate de Rental ne peut pas se situer avant la creationDate de Advertisement

-- La creationDate de Rental ne peut pas se situer avant la registrationDate du User

-- La registrationDate d’un User doit être avant le creationDate d’un Rental d’un User

-- La registrationDate d’un User doit être avant le creationDate d’un Advertisement d’un User

-- Un User peut seulement faire un Rating pour un Rental pour lequel il est le locataire ou le propriétaire de l’Advertisement.

-- La date d’un Rating doit être après la creationDate d’un Rental

-- Le User propriétaire d’un Advertisement peut seulement noter rentalRating dans le Rating

-- Le User locataire d’un Rental doit noter le rentalRating et le objectRating dans le Rating

-- Le streetNumber dans Address doit être strictement positif

-- Le price dans Advertisement ne peut pas être négatif
