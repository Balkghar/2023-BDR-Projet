# BDR Project

Prerequisites: docker installed

Start:
Go to Code repository in the terminal and start the containers with the following command:

`docker compose up -d`

Connect:
Connect to the web-application with the following link:
http://localhost/


Stop:
Stop the container with the followin command:

`docker compose down`


### old
Command to create SSL certificate:
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout Code/nginx/ssl/server.key -out Code/nginx/ssl/server.crt