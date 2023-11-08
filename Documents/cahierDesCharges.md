# Cahier de charges - Groupe 9
* Dominik Saul
* Glodi Domingos
* Hugo Germano

## Description
Nous allons créer un site web pour mettre en contact des utilisateurs voulant louer leurs objets et louer les objets d'autres utilisateurs. La page d'accueil se compose d'une liste des objets les plus proche de la localisation actuelle de l'utilisateur.   
Les objets peuvent etre des differents types comme voiture, vélo, moto, livres, dvd, bateaux, outils. Les locations sont graduites ou payantes. On peut payer via plusieurs méthodes de payments tel quel carte de crédit, Twint et etc....

## Spécification
l'application permet aux utilisateurs de
- créer et modifier les annonces pour ses objets
- chercher / filtrer les annonces des autres utilisateurs
- possibilité de voir les disponibilités des objets
- faire une demande de réservation
- le proprietaire d'un objet confirme la reservation et la location
- Le loueur et le propriétaire confirme la prise en main et le retour de l'objet
- Vérifier et changer les paramètres d'un compte utilisateur

## Données
- Users
  - Firstname
  - Lastname
  - Registration date
  - Mail
  - Password
  - Phone number
  - Street
  - StreetNumber
  - ZIP
  - City

- Annonces / Objects
  - Creation Date
  - Title / Name
  - Status 
  - Descriptions
  - ZIP
  - City
  - Informations Price

- Locations
  - Start date
  - End date
  - Creation Date
  - Payment Method (Cash, Twint)
  - Payment Date
  - Status 
    - Reservation requested
    - Reservation confirmed
    - Reservation canceled
    - Location ongoing
    - Item returned
    - Location canceled
    - Location finished

- Categories
  - Name

Eventuellement Table supp. pour adresses et villes

## Technologies / Langues
- Base de données : PostgreSQL
- Langage de programmation : PHP
- Serveur web : Nginx Server
- Technologie : Docker



# Modelisation
## Contraintes d'integrité
* 

## Questions ouvertes