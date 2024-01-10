INSERT INTO City (zip, name, canton)
VALUES (1000, 'Lausanne', 'VD'),
       (1001, 'Lausanne', 'VD'),
       (1002, 'Lausanne', 'VD'),
       (1003, 'Lausanne', 'VD'),
       (1004, 'Lausanne', 'VD'),
       (1005, 'Lausanne', 'VD'),
       (1006, 'Lausanne', 'VD'),
       (1007, 'Lausanne', 'VD'),
       (1008, 'Prilly', 'VD'),
       (1009, 'Pully', 'VD'),
       (1010, 'Lausanne', 'VD'),
       (1011, 'Lausanne', 'VD'),
       (1012, 'Lausanne', 'VD'),
       (1013, 'Lausanne', 'VD'),
       (1014, 'Lausanne', 'VD'),
       (1015, 'Lausanne', 'VD'),
       (1016, 'Lausanne', 'VD'),
       (1018, 'Lausanne', 'VD'),
       (1019, 'Lausanne', 'VD'),
       (1020, 'Renens VD', 'VD'),
       (1022, 'Chavannes-près-Renens', 'VD'),
       (1023, 'Crissier', 'VD'),
       (1024, 'Ecublens VD', 'VD'),
       (1025, 'St-Sulpice VD', 'VD'),
       (1026, 'Denges', 'VD'),
       (1027, 'Lonay', 'VD'),
       (1028, 'Préverenges', 'VD'),
       (1029, 'Villars-Ste-Croix', 'VD'),
       (1030, 'Bussigny', 'VD'),
       (1031, 'Mex VD', 'VD'),
       (1032, 'Romanel-sur-Lausanne', 'VD'),
       (1033, 'Cheseaux-sur-Lausanne', 'VD'),
       (1034, 'Boussens', 'VD'),
       (1035, 'Bournens', 'VD'),
       (1036, 'Sullens', 'VD'),
       (1037, 'Etagnières', 'VD'),
       (1038, 'Bercher', 'VD'),
       (1040, 'Echallens', 'VD'),
       (1400, 'Yverdon-les-Bains', 'VD'),
       (5000, 'Aarau', 'AG'),
       (5001, 'Baden', 'AG'),
       (9000, 'Appenzell', 'AI'),
       (9001, 'Herisau', 'AI'),
       (4000, 'Liestal', 'BL'),
       (4001, 'Pratteln', 'BL'),
       (3000, 'Bern', 'BE'),
       (3001, 'Thun', 'BE'),
       (1700, 'Fribourg', 'FR'),
       (1701, 'Bulle', 'FR'),
       (1200, 'Geneva', 'GE'),
       (1201, 'Carouge', 'GE'),
       (8750, 'Glarus', 'GL'),
       (8751, 'Näfels', 'GL'),
       (7000, 'Chur', 'GR'),
       (7001, 'Davos', 'GR'),
       (2900, 'Delémont', 'JU'),
       (2901, 'Porrentruy', 'JU'),
       (6000, 'Lucerne', 'LU'),
       (6001, 'Emmen', 'LU'),
       (2000, 'Neuchâtel', 'NE'),
       (2001, 'La Chaux-de-Fonds', 'NE'),
       (6002, 'Stans', 'NW'),
       (6003, 'Ennetbürgen', 'NW'),
       (6004, 'Sarnen', 'OW'),
       (6005, 'Alpnach', 'OW'),
       (9002, 'St. Gallen', 'SG'), -- Correction ici
       (9003, 'Rorschach', 'SG'),  -- Correction ici
       (8200, 'Schaffhausen', 'SH'),
       (8201, 'Neuhausen', 'SH'),
       (4500, 'Solothurn', 'SO'),
       (4501, 'Olten', 'SO'),
       (6400, 'Schwyz', 'SZ'),
       (6401, 'Wollerau', 'SZ'),
       (8500, 'Frauenfeld', 'TG'),
       (8501, 'Kreuzlingen', 'TG'),
       (6900, 'Lugano', 'TI'),
       (6901, 'Bellinzona', 'TI'),
       (6006, 'Altdorf', 'UR'),
       (6007, 'Flüelen', 'UR'),
       (3900, 'Sion', 'VS'),
       (3901, 'Brig', 'VS'),
       (6300, 'Zug', 'ZG'),
       (6301, 'Baar', 'ZG'),
       (8000, 'Zurich', 'ZH'),
       (8001, 'Winterthur', 'ZH');

INSERT INTO Address (zipCity, street, streetNumber)
VALUES (1001, 'Rue de Bourg', 51),
       (1008, 'Chemin du Centre', 67),
       (1010, 'Rue de la Grotte', 2),
       (1020, 'Rue du Centre', 1),
       (1023, 'Avenue de la Source', 69),
       (1025, 'Chemin de la Piscine', 5),
       (1027, 'Chemin du Goudron', 2),
       (1029, 'Chemin de la Riaz', 2),
       (1030, 'Rue de la Gare', 6),
       (1040, 'Rue du Château', 8),
       (1400, 'Rue des Moulins', 5);

INSERT INTO Category (name, parentCategory)
VALUES ('Véhicules', NULL),
       ('Voitures', 'Véhicules'),
       ('Motos', 'Véhicules'),
       ('Vélos', 'Véhicules'),
       ('Informatique', NULL),
       ('Ordinateurs', 'Informatique'),
       ('Périphériques', 'Informatique'),
       ('Smartphones', 'Informatique'),
       ('Electroménager', NULL),
       ('Cuisine', 'Electroménager'),
       ('Maison', 'Electroménager'),
       ('Jardin', 'Electroménager'),
       ('Bricolage', NULL),
       ('Outils', 'Bricolage'),
       ('Matériaux', 'Bricolage'),
       ('Jardinage', 'Bricolage'),
       ('Loisirs', NULL),
       ('Jeux', 'Loisirs'),
       ('Sport', 'Loisirs'),
       ('Musique', 'Loisirs'),
       ('Livres', 'Loisirs'),
       ('Films', 'Loisirs'),
       ('Vêtements', NULL),
       ('Homme', 'Vêtements'),
       ('Femme', 'Vêtements'),
       ('Enfant', 'Vêtements'),
       ('Autres', NULL);

INSERT INTO Profile (idAddress, registrationdate, firstname, lastname, mail, password, phoneNumber, status)
VALUES (1, '2020-01-01 00:00:00', 'Michael', 'Dupont', 'michael@dupont.ch', '1234', '+41791234567', 'ACTIVE'),
       (2, '2020-01-01 00:00:00', 'Marie', 'Lemarie', 'marie@lemaire.ch', '1234', '+41792345678', 'ACTIVE'),
       (3, '2020-01-01 00:00:00', 'Pierre', 'Lapierre', 'pierre@lapierre.ch', '1234', '+41793456789', 'ACTIVE'),
       (4, '2020-01-01 00:00:00', 'Pascal', 'Depaquier', 'pascal@depaquier.ch', '1234', '+41794567890', 'ACTIVE'),
       (5, '2020-01-01 00:00:00', 'Jean', 'Lejean', 'jean@lejean.ch', '1234', '+41795678901', 'ACTIVE'),
       (6, '2020-01-01 00:00:00', 'Paul', 'Lepaul', 'paul@lepaul.ch', '1234', '+41796789012', 'ACTIVE'),
       (7, '2020-01-01 00:00:00', 'Alice', 'Lecoin', 'alice@lecoin.ch', '1234', '+41797890123', 'ACTIVE'),
       (8, '2020-01-01 00:00:00', 'Gertrude', 'Bidule', 'gertrude@bidule.ch', '1234', '+417978901234', 'ACTIVE');


INSERT INTO Advertisement (idAddress, idProfile, creationdate, nameCategory, title, description, price, priceInterval,
                           status)
VALUES (8, 1, '2020-01-01 00:00:00', 'Jardin', 'Tondeuse électrique',
        'Tondeuse électrique performante pour entretenir votre pelouse de manière efficace. Facile à utiliser et en excellent état. Louez-la dès maintenant et profitez d''une pelouse bien entretenue!',
        20, 'DAY', 'ACTIVE'),
       (2, 2, '2020-01-01 00:00:00', 'Voitures', 'Voiture de sport BMW',
        'Explorez la route avec style dans notre voiture de sport BMW haut de gamme. Puissante, élégante et prête à vous offrir une expérience de conduite inoubliable. Réservez dès aujourd''hui!',
        150, 'DAY', 'ACTIVE'),
       (4, 3, '2020-01-01 00:00:00', 'Ordinateurs', 'Ordinateur de gaming',
        'Plongez dans le monde du gaming avec notre ordinateur de gaming dernière génération. Des performances exceptionnelles pour une expérience de jeu immersive. Louez-le maintenant et dominez le jeu!',
        40, 'WEEK', 'ACTIVE'),
       (6, 4, '2020-01-01 00:00:00', 'Jardin', 'Taille-haie professionnel',
        'Taillez vos haies avec précision grâce à notre taille-haie professionnel. Léger, maniable et équipé de lames tranchantes, il vous aidera à sculpter vos espaces verts. Disponible à la location.',
        25, 'DAY', 'ACTIVE'),
       (1, 5, '2020-01-01 00:00:00', 'Outils', 'Perceuse à percussion',
        'Réalisez vos projets de bricolage avec facilité en louant notre perceuse à percussion Bosch. Performante et fiable, elle vous accompagnera dans tous vos travaux. Réservez dès maintenant!',
        30, 'WEEK', 'ACTIVE'),
       (3, 6, '2020-01-01 00:00:00', 'Vélos', 'Vélo de montagne tout-terrain',
        'Parcourez les sentiers avec notre vélo de montagne tout-terrain. Robuste, équipé de suspensions efficaces, il est parfait pour les amateurs d''aventure en plein air. Louez-le et partez à l''aventure!',
        15, 'DAY', 'ACTIVE'),
       (5, 7, '2020-01-01 00:00:00', 'Cuisine', 'Robot culinaire multifonction',
        'Simplifiez la préparation de vos repas avec notre robot culinaire multifonction. Polyvalent et facile à utiliser, il vous permettra de réaliser une variété de recettes avec peu d''effort. Disponible à la location!',
        35, 'MONTH', 'ACTIVE'),
       (7, 8, '2020-01-01 00:00:00', 'Jeux', 'Console de jeu PlayStation 5',
        'Plongez dans le monde du gaming nouvelle génération avec notre console de jeu PlayStation 5. Des graphismes époustouflants et une expérience de jeu immersive vous attendent. Louez-la et jouez sans limites!',
        50, 'WEEK', 'ACTIVE'),
       (8, 1, '2020-01-01 00:00:00', 'Homme', 'Costume élégant pour homme',
        'Soyez élégant lors de vos occasions spéciales avec notre costume haut de gamme. Parfaitement taillé, il vous assure une allure sophistiquée. Louez ce costume et soyez la star de l''événement!',
        40, 'DAY', 'ACTIVE'),
       (10, 2, '2020-01-01 00:00:00', 'Femme', 'Robe de soirée glamour',
        'Faites sensation lors de vos soirées avec notre robe de soirée glamour. Élégante, confortable et conçue pour vous mettre en valeur, elle sera parfaite pour toutes vos occasions spéciales. Louez-la et brillez!',
        45, 'DAY', 'ACTIVE'),
       (1, 3, '2020-01-01 00:00:00', 'Electroménager', 'Machine à café automatique',
        'Commencez votre journée avec une tasse de café parfaite grâce à notre machine à café automatique. Simple à utiliser et capable de préparer une variété de boissons, elle deviendra votre compagnon matinal. Louez-la dès maintenant!',
        25, 'WEEK', 'ACTIVE'),
       (2, 4, '2020-01-01 00:00:00', 'Cuisine', 'Appareil à fondue électrique',
        'Organisez des soirées conviviales avec notre appareil à fondue électrique. Facile à utiliser, il vous permettra de déguster de délicieuses fondues entre amis. Louez-le et vivez des moments gourmands!',
        20, 'DAY', 'ACTIVE'),
       (3, 5, '2020-01-01 00:00:00', 'Vêtements', 'Ensemble de ski complet',
        'Préparez-vous pour vos vacances à la montagne avec notre ensemble de ski complet. Chaud, confortable et stylé, il vous assurera une expérience de ski agréable. Louez l''ensemble et dévalez les pistes avec style!',
        30, 'WEEK', 'ACTIVE'),
       (4, 6, '2020-01-01 00:00:00', 'Sport', 'Planche de surf',
        'Ressentez l''adrénaline des vagues avec notre planche de surf haute performance. Idéale pour les amateurs de sensations fortes, elle vous garantit des moments inoubliables sur l''eau. Louez-la et partez à la conquête des vagues!',
        25, 'DAY', 'ACTIVE'),
       (5, 7, '2020-01-01 00:00:00', 'Electroménager', 'Robot aspirateur intelligent',
        'Laissez notre robot aspirateur intelligent prendre soin de votre maison. Programmable et efficace, il nettoiera vos sols sans effort. Louez-le et profitez d''un intérieur impeccable!',
        35, 'WEEK', 'ACTIVE'),
       (6, 8, '2020-01-01 00:00:00', 'Loisirs', 'Appareil photo professionnel',
        'Capturez des moments exceptionnels avec notre appareil photo professionnel. Doté de fonctionnalités avancées, il vous permettra de créer des souvenirs inoubliables. Louez-le et explorez le monde de la photographie!',
        40, 'WEEK', 'ACTIVE'),
       (7, 1, '2020-01-01 00:00:00', 'Informatique', 'Imprimante 3D',
        'Donnez vie à vos idées avec notre imprimante 3D. Polyvalente et facile à utiliser, elle vous permettra de concrétiser vos projets créatifs. Louez-la et explorez le monde de l''impression 3D!',
        30, 'DAY', 'ACTIVE'),
       (8, 2, '2020-01-01 00:00:00', 'Musique', 'Piano numérique',
        'Exprimez votre talent musical avec notre piano numérique. Toucher réaliste, sons de qualité, il vous offre une expérience de jeu exceptionnelle. Louez-le et jouez vos mélodies préférées!',
        50, 'WEEK', 'ACTIVE'),
       (10, 3, '2020-01-01 00:00:00', 'Maison', 'Aspirateur sans sac',
        'Maintenez votre intérieur propre avec notre aspirateur sans sac. Puissant et pratique, il vous permettra d''aspirer facilement toutes les surfaces. Louez-le et dites adieu à la poussière!',
        25, 'DAY', 'ACTIVE'),
       (2, 4, '2020-01-01 00:00:00', 'Homme', 'Montre de luxe',
        'Affirmez votre style avec notre montre de luxe. Élégante, précise et conçue avec des matériaux de qualité, elle complétera parfaitement vos tenues. Louez-la et portez une touche d''élégance à votre poignet!',
        35, 'WEEK', 'ACTIVE'),
       (3, 5, '2020-01-01 00:00:00', 'Femme', 'Sac à main design',
        'Accessoirisez vos tenues avec notre sac à main design. Chic, spacieux et conçu avec soin, il deviendra votre compagnon quotidien. Louez-le et soyez à la pointe de la mode!',
        20, 'DAY', 'ACTIVE'),
       (4, 6, '2020-01-01 00:00:00', 'Enfant', 'Trottinette électrique',
        'Offrez à votre enfant des heures de divertissement avec notre trottinette électrique. Facile à utiliser, sécurisée et amusante, elle sera le cadeau idéal. Louez-la et voyez votre enfant s''épanouir!',
        15, 'DAY', 'ACTIVE'),
       (5, 7, '2020-01-01 00:00:00', 'Loisirs', 'Enceinte Bluetooth portable',
        'Emportez votre musique partout avec notre enceinte Bluetooth portable. Compacte, puissante et dotée d''une excellente autonomie, elle vous accompagnera dans toutes vos aventures. Louez-la et vivez une expérience sonore exceptionnelle!',
        25, 'WEEK', 'ACTIVE'),
       (6, 8, '2020-01-01 00:00:00', 'Electroménager', 'Fer à repasser vapeur',
        'Obtenez des vêtements impeccables avec notre fer à repasser vapeur. Performant et facile à utiliser, il vous permettra de repasser vos vêtements rapidement et efficacement. Louez-le et gardez une allure soignée!',
        15, 'DAY', 'ACTIVE'),
       (7, 1, '2020-01-01 00:00:00', 'Bricolage', 'Scie circulaire professionnelle',
        'Réalisez des coupes précises avec notre scie circulaire professionnelle. Puissante, sûre et adaptée à une variété de matériaux, elle sera votre alliée pour tous vos projets de bricolage. Louez-la et découvrez la facilité de coupe!',
        30, 'WEEK', 'ACTIVE'),
       (8, 2, '2020-01-01 00:00:00', 'Jardinage', 'Débroussailleuse thermique',
        'Entretenez votre jardin avec notre débroussailleuse thermique. Puissante et ergonomique, elle vous permettra de maîtriser les espaces verts avec facilité. Louez-la et gardez votre jardin impeccable!',
        40, 'DAY', 'ACTIVE'),
       (10, 3, '2020-01-01 00:00:00', 'Vêtements', 'Veste en cuir vintage',
        'Ajoutez une touche de style rétro à votre garde-robe avec notre veste en cuir vintage. Intemporelle, élégante et conçue pour durer, elle sera votre pièce maîtresse. Louez-la et adoptez un look vintage!',
        35, 'WEEK', 'ACTIVE'),
       (2, 4, '2020-01-01 00:00:00', 'Voitures', 'Scooter électrique',
        'Parcourez la ville avec notre scooter électrique. Écologique, pratique et facile à conduire, il sera votre compagnon idéal pour tous vos déplacements. Louez-le et découvrez une nouvelle manière de vous déplacer!',
        25, 'DAY', 'ACTIVE'),
       (3, 5, '2020-01-01 00:00:00', 'Sport', 'Raquettes de tennis Wilson',
        'Affinez votre jeu de tennis avec nos raquettes de tennis Wilson. Légères, puissantes et adaptées à tous les niveaux, elles vous aideront à gagner sur le court. Louez-les et améliorez vos performances!',
        20, 'DAY', 'ACTIVE'),
       (4, 6, '2020-01-01 00:00:00', 'Musique', 'Guitare acoustique',
        'Découvrez le plaisir de jouer de la musique avec notre guitare acoustique. Son chaleureux, confort de jeu optimal, elle convient aussi bien aux débutants qu''aux guitaristes confirmés. Louez-la et laissez libre cours à votre créativité musicale!',
        30, 'WEEK', 'ACTIVE'),
       (9, 3, '2020-01-01 00:00:00', 'Loisirs', 'Tente de camping 4 personnes',
        'Partez à l''aventure avec notre tente de camping spacieuse pour 4 personnes. Facile à monter et résistante aux intempéries, elle sera votre compagnon idéal pour des nuits sous les étoiles. Louez-la dès maintenant!',
        15, 'DAY', 'ACTIVE'),
       (10, 4, '2020-01-01 00:00:00', 'Electroménager', 'Aspirateur sans sac',
        'Maintenez votre maison propre avec notre aspirateur sans sac. Puissant et facile à utiliser, il éliminera la poussière et les allergènes. Louez-le et profitez d''un environnement sain!',
        25, 'WEEK', 'ACTIVE'),
       (1, 5, '2020-01-01 00:00:00', 'Voitures', 'Véhicule utilitaire',
        'Transportez vos biens en toute simplicité avec notre véhicule utilitaire. Spacieux et pratique, il vous aidera lors de vos déménagements ou de vos achats volumineux. Louez-le dès maintenant!',
        40, 'DAY', 'ACTIVE'),
       (2, 6, '2020-01-01 00:00:00', 'Bricolage', 'Scie circulaire professionnelle',
        'Réalisez des coupes précises avec notre scie circulaire professionnelle. Idéale pour vos projets de menuiserie, elle vous garantit des résultats impeccables. Louez-la et donnez vie à vos idées!',
        30, 'DAY', 'ACTIVE'),
       (3, 7, '2020-01-01 00:00:00', 'Sport', 'Équipement de camping complet',
        'Préparez-vous pour une expérience de camping inoubliable avec notre équipement complet. Tente, sacs de couchage, réchaud et plus encore. Louez-le et vivez l''aventure au cœur de la nature!',
        50, 'WEEK', 'ACTIVE'),
       (4, 8, '2020-01-01 00:00:00', 'Jeux', 'Console Xbox Series X',
        'Plongez dans le monde du gaming avec la console Xbox Series X. Des performances de pointe, une qualité graphique exceptionnelle et une bibliothèque de jeux variée. Louez-la et jouez sans limites!',
        50, 'WEEK', 'ACTIVE'),
       (5, 1, '2020-01-01 00:00:00', 'Electroménager', 'Machine à laver haute capacité',
        'Simplifiez votre routine quotidienne avec notre machine à laver haute capacité. Idéale pour les familles nombreuses, elle garantit des vêtements propres en un rien de temps. Louez-la et facilitez-vous la vie!',
        35, 'WEEK', 'ACTIVE'),
       (6, 2, '2020-01-01 00:00:00', 'Vélos', 'Vélo électrique pliable',
        'Explorez la ville de manière écologique avec notre vélo électrique pliable. Compact, facile à transporter et équipé d''une assistance électrique, il vous offre une mobilité urbaine optimale. Louez-le et roulez en toute liberté!',
        25, 'DAY', 'ACTIVE'),
       (7, 3, '2020-01-01 00:00:00', 'Informatique', 'Moniteur incurvé 4K',
        'Améliorez votre expérience visuelle avec notre moniteur incurvé 4K. Des couleurs éclatantes, une résolution exceptionnelle, il est parfait pour le travail et les loisirs. Louez-le et plongez dans une qualité d''image exceptionnelle!',
        40, 'WEEK', 'ACTIVE'),
       (8, 4, '2020-01-01 00:00:00', 'Cuisine', 'Barbecue à gaz professionnel',
        'Organisez des barbecues mémorables avec notre barbecue à gaz professionnel. Performant, spacieux et facile à utiliser, il vous garantit des repas savoureux en plein air. Louez-le et régalez vos invités!',
        30, 'DAY', 'ACTIVE'),
       (9, 5, '2020-01-01 00:00:00', 'Outils', 'Perforateur SDS+',
        'Percez avec précision grâce à notre perforateur SDS+. Polyvalent, il convient pour le béton, la pierre et le métal. Louez-le pour vos projets de construction et de rénovation!',
        20, 'DAY', 'ACTIVE'),
       (10, 6, '2020-01-01 00:00:00', 'Loisirs', 'Tente de camping familiale',
        'Profitez de moments en famille avec notre tente de camping spacieuse. Conçue pour accueillir plusieurs personnes, elle offre confort et intimité lors de vos escapades en plein air. Louez-la et créez des souvenirs inoubliables!',
        30, 'WEEK', 'ACTIVE'),
       (1, 7, '2020-01-01 00:00:00', 'Electroménager', 'Robot de cuisine multifonction',
        'Soyez un chef étoilé chez vous avec notre robot de cuisine multifonction. Coupe, mélange, hache et pétrit, il simplifie la préparation des repas. Louez-le et libérez votre créativité culinaire!',
        35, 'MONTH', 'ACTIVE'),
       (2, 8, '2020-01-01 00:00:00', 'Informatique', 'Laptop ultrabook',
        'Travaillez en toute mobilité avec notre laptop ultrabook. Léger, puissant et doté d''une autonomie exceptionnelle, il vous accompagnera partout. Louez-le et boostez votre productivité!',
        40, 'WEEK', 'ACTIVE'),
       (3, 1, '2020-01-01 00:00:00', 'Vélos', 'VTT tout suspendu',
        'Explorez les sentiers avec notre VTT tout suspendu. Conçu pour les descentes rapides et les terrains accidentés, il vous offre des sensations fortes en pleine nature. Louez-le et partez à l''aventure!',
        25, 'DAY', 'ACTIVE'),
       (4, 2, '2020-01-01 00:00:00', 'Voitures', 'SUV spacieux',
        'Voyagez avec style et confort dans notre SUV spacieux. Idéal pour les longs trajets en famille, il offre une conduite agréable et de nombreuses fonctionnalités. Louez-le et roulez en toute sérénité!',
        80, 'DAY', 'ACTIVE'),
       (5, 3, '2020-01-01 00:00:00', 'Bricolage', 'Perceuse visseuse sans fil',
        'Réalisez vos projets de bricolage sans contraintes avec notre perceuse visseuse sans fil. Puissante, légère et facile à manœuvrer, elle sera votre alliée pour tous vos travaux. Louez-la et bricolez en toute liberté!',
        20, 'WEEK', 'ACTIVE'),
       (6, 4, '2020-01-01 00:00:00', 'Electroménager', 'Réfrigérateur américain',
        'Optimisez le stockage de vos aliments avec notre réfrigérateur américain. Spacieux, élégant et équipé de nombreuses fonctionnalités, il répond à tous vos besoins. Louez-le et gardez vos produits frais plus longtemps!',
        50, 'WEEK', 'ACTIVE'),
       (7, 5, '2020-01-01 00:00:00', 'Jeux', 'Table de ping-pong extérieure',
        'Organisez des tournois de ping-pong dans votre jardin avec notre table de ping-pong extérieure. Robuste, résistante aux intempéries, elle garantit des heures de divertissement en plein air. Louez-la et défiez vos amis!',
        30, 'DAY', 'ACTIVE'),
       (8, 6, '2020-01-01 00:00:00', 'Vêtements', 'Tenue de ski complète',
        'Préparez-vous pour vos vacances au ski avec notre tenue complète. Combinaison, gants, bonnet et plus encore. Louez-la et profitez de vos descentes sur les pistes en toute sécurité et style!',
        40, 'WEEK', 'ACTIVE');

/*
INSERT INTO Advertisement (idAddress, idProfile, nameCategory, title, description, price, priceInterval, status)
VALUES (1, 1, 'Outils', 'Perceuse', 'Perceuse Bosch', 30, 'WEEK', 'ACTIVE'),
       (2, 2, 'Voitures', 'Voiture Mercedes', 'Voiture de luxe', 100, 'DAY', 'ACTIVE'),
       (3, 3, 'Vélos', 'Vélo de course', 'Vélo de course', 20, 'DAY', 'ACTIVE'),
       (4, 4, 'Ordinateurs', 'Ordinateur portable', 'Ordinateur portable', 30, 'MONTH', 'ACTIVE'),
       (5, 5, 'Cuisine', 'Casserole', 'Casserole en inox', 25, 'WEEK', 'ACTIVE'),
       (6, 6, 'Jardin', 'Tondeuse', 'Tondeuse à gazon', 15, 'DAY', 'ACTIVE'),
       (7, 7, 'Jeux', 'Jeu de société', 'Jeu de société', 5, 'DAY', 'ACTIVE'),
       (1, 1, 'Sport', 'Raquette de tennis', 'Raquette de tennis', 5, 'DAY', 'ACTIVE'),
       (1, 1, 'Musique', 'Guitare', 'Guitare', 10, 'DAY', 'ACTIVE'),
       (1, 2, 'Livres', 'Livre de cuisine', 'Livre de cuisine', 5, 'DAY', 'ACTIVE'),
       (2, 2, 'Films', 'DVD', 'DVD', 5, 'DAY', 'ACTIVE'),
       (2, 4, 'Homme', 'Chemise', 'Chemise', 25, 'WEEK', 'ACTIVE'),
       (3, 5, 'Femme', 'Robe', 'Robe', 25, 'WEEK', 'ACTIVE'),
       (4, 6, 'Enfant', 'Jouet', 'Jouet', 5, 'DAY', 'ACTIVE'),
       (5, 7, 'Autres', 'Autre', 'Autre', 5, 'DAY', 'ACTIVE');*/

INSERT INTO Rental (idProfile, idAdvertisement, creationDate, startDate, endDate, paymentDate, comment, statusRental,
                    paymentMethod, price)
VALUES (1, 4, '2020-01-01 00:00:00', '2020-01-01 00:00:00', '2020-01-02 00:00:00', NULL, 'Comm1', 'RESERVATION_ASKED',
        'TWINT', 0),
       (2, 5, '2020-01-01 00:00:00', '2020-02-01 00:00:00', '2020-02-12 00:00:00', NULL, 'Comm2',
        'RESERVATION_CONFIRMED', 'CASH', 10),
       (3, 6, '2020-01-01 00:00:00', '2020-03-01 00:00:00', '2020-03-05 00:00:00', NULL, 'Comme3',
        'RESERVATION_CANCELED', 'TWINT', 12),
       (4, 7, '2020-01-01 00:00:00', '2020-04-01 00:00:00', '2020-04-02 00:00:00', '2020-04-01 00:00:00', 'Comm4',
        'LOCATION_ONGOING', 'CASH', 0),
       (5, 8, '2020-01-01 00:00:00', '2020-05-01 00:00:00', '2020-05-02 00:00:00', '2020-05-01 00:00:00', 'Comm5',
        'ITEM_RETURNED', 'TWINT', 14),
       (6, 9, '2020-01-01 00:00:00', '2020-06-01 00:00:00', '2020-06-02 00:00:00', NULL, 'Comm6', 'LOCATION_CANCELED',
        'CASH', 45),
       (7, 10, '2020-01-01 00:00:00', '2020-07-01 00:00:00', '2020-07-02 00:00:00', '2020-07-01 00:00:00', 'Comm7',
        'LOCATION_FINISHED',
        'TWINT', 6);


INSERT INTO Rating (idProfile, idRental, rentalRating, objectRating)
VALUES (1, 1, 4, 4),
       (2, 2, 5, 5),
       (3, 3, 3, 3),
       (4, 4, 2, 2),
       (5, 5, 1, 1),
       (6, 6, 4, 4),
       (1, 6, 5, NULL),
       (2, 7, 3, NULL);
