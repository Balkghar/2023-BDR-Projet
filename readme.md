# BDR - Project 'Prêt de chez toi'

## Description

This project is a web application that allows users to create advertisements for objects and to rent objects from other
users. The application is developed in PHP. The database is a PostgreSQL database. The application is deployed in Docker
containers.

## Installation/Deployment Guide

### Prerequisites

To be able to execute and deploy the project, the following softwares are required:
For Linux:

- [Docker](https://docs.docker.com/engine/install/) installed

For Windows:

- [WSL2](https://learn.microsoft.com/fr-fr/windows/wsl/install) installed
- [Docker desktop](https://docs.docker.com/desktop/install/windows-install/) installed

### Start the app

1. Clone the repository (in WSL for windows user)
2. Open the terminal and navigate to the [Code](./Code/) folder of the repository
3. Execute the following command to start the docker containers: `docker compose up -d`
4. Execute those command if you want to populate the database:

    ```bash
    docker cp ./src/sql_scripts/insert.sql postgres:/docker-entrypoint-initdb.d/insert.sql
    docker exec postgres psql BDRProject projectuser -f /docker-entrypoint-initdb.d/insert.sql
    ```

   The first one will copy the insert file to the container postgres and the second one will execute the script

5. Open the browser and navigate to [localhost](http://localhost/)

### Stop the app

1. Open the terminal and navigate to the Code folder of the repository
2. Execute the following command to stop the docker containers: `docker compose down`
3. Execute the following command if you want to remove the docker containers: `docker compose rm`
