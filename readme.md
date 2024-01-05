# BDR - Project 'Prêt de chez toi'

## Description:

This project is a web application that allows users to create advertisements for objects and to rent objects from other
users. The application is developed in PHP. The database is a PostgreSQL database. The application is deployed in Docker
containers.

## Installation/Deployment Guide:

### Prerequisites:

To be able to execute and deploy the project, the following software is required to be installed:

- Docker installed
- Software to connect to the database (e.g. DBeaver / IntelliJ)

### Start the app:

1. Clone the repository
2. Open the terminal and navigate to the Code folder of the repository
3. Execute the following command to start the docker containers: `docker compose up -d`
4. Connect yourself to the database with the credentials provided in the Code/docker-compose.yml file
5. Execute the SQL script create.sql and insert.sql in the Code/src/sql_scripts folder to create the database tables and
   insert the template data
6. Open the browser and navigate to http://localhost/
```bash
`sudo chown -R www-data:www-data images` # change owership of the images folder to www-data
`find images -type d -exec chmod 775 {} ` # change all the directories to 775 (write for user & group www-data, read for others)
`find images -type f -exec chmod 664 {} ` # To change all the files to 664 (write for user & group www-data, read for others)
```
### Stop the app:

1. Open the terminal and navigate to the Code folder of the repository
2. Execute the following command to stop the docker containers: `docker compose down`
3. ( Execute the following command if you want to remove the docker containers: `docker compose rm`)

