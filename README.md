## Install (Установка через Docker)

Installing Docker- https://docs.docker.com/engine/install/ubuntu/<br />
Installing Docker Compose - https://docs.docker.com/compose/install/<br />


cp www/app/.env.example www/app/.env<br />

Open the .env file and edit it if necessary. <br />
DB_HOST=mysql - to use Docker database <br />
DB_PORT=3306 <br />
DB_DATABASE=user_wallet <br />
DB_USERNAME=root <br />
DB_PASSWORD=secret <br />

Execute the command<br />
 docker-compose up -d --build <br />
Or </br>
 docker-compose up --build <br />
 
 For composer commands <br />
 docker-compose run --rm composer .. <br />
 
 For npm commands<br />
 docker-compose run --rm npm  <br />
 
 For artisan commands <br />
 docker-compose run --rm artisan  <br />
 
 
 After creating the .env file and docker-compose up -d --build <br />
 Complete <br />
    docker-compose run --rm artisan migrate<br />
    docker-compose run --rm artisan db:seed<br />
    docker-compose run --rm artisan key:generate<br />

To connect to a database<br />
docker-compose exec mysql bash<br />
mysql -uroot -psecret<br />


# Api

Get http://localhost:8080/api/wallet - get all data from database

Post http://localhost:8080/api/wallet - create transaction and update balance

Get http://localhost:8080/api/wallet/balance?walletId=1 - get balance by walletId


# SQL a request that will return the amount received for the refund reason for the last 7 days.

SELECT SUM(value) AS sum FROM transactions where created_at >= date_sub(now(), interval 7 day) AND reason = 'refund';