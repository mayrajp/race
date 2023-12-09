# RACE - API

## Info

This is a simple application to create car races.

### How to use this app?

Create a speedway, a driver and a car associated with the created driver. Then you can create a race.

### Rules

- It is only possible to create a race if the track is not under maintenance or deactivated
- To enter the race, the driver must have a car with a track type compatible with the track on which he will race

## Installation


### Clone repository

`https://github.com/mayrajp/race.git`

### Enter directory

`cd race`

### Configure .env with your environment configuration

`cp .env.example .env`

### Make this config on .env

```dosini
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root

DB_CONNECTION_TEST=mysql
DB_HOST_TEST=db
DB_PORT_TEST=3306
DB_DATABASE_TEST=my_test_database
DB_USERNAME_TEST=root
DB_PASSWORD_TEST=root

```

### Build container

`sudo docker compose build`

### Up the container

`sudo docker compose up -d`

### Enter inside container

`sudo docker compose exec php sh`

### Install dependencies

`composer install`

### Generate key

`php artisan key:generate`

### Migrate the Databse

`php artisan migrate`

### Run project

`php artisan serve`

## Test app

### Config test database

`php artisan migrate --database=mysql_test`

### Run tests

`php artisan test`
