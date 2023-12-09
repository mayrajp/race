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

*OBS : make sure you have created your database. Set  the db config in .env file*

`cp .env.example .env`

### Install dependencies

`composer install`

### Migrate the Databse

`php artisan migrate`

### Config test database

`php artisan migrate --database=mysql_test`

### Run tests

`php artisan test`
