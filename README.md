## Helix Sleep REST API Code Challenge

## Contents
* [Requirements](#requirements)
* [Endpoints](#endpoints)
* [Enpoint list](#endpoint-lists)
* [Create and seed database](#create-and-seed-database)
* [Make request to endpoints](#make-request-to-endpoints)
* [Run tests](#run-test)

## Requirements
* "php": "^7.3|^8.0",
* "laravel/sanctum": "^2.15",

## Set up
* Clone up from github
* You can run composer upate after cloning to install dependencies in the composer.json file
* Go to [Databases](#create-and-seed-database)


## Endpoints
- Add product  
- Update product
- Delete product
- Get product
- Get list of all products
- Attach product to requesting user
- Remove product from requesting user
- List products attached to requesting user

# Endpoint lists 
+--------+-----------+-----------------------------+------------------+
| Domain | Method    | URI                         | Name             |
+--------+-----------+-----------------------------+------------------+
|        | POST      | api/addProductToUserList    |                  | 
|        |           |                             |                  |
|        | GET|HEAD  | api/products                | products.index   |
|        |           |                             |                  |
|        | POST      | api/products                | products.store   |
|        |           |                             |                  |
|        | GET|HEAD  | api/products/{product}      | products.show    |
|        |           |                             |                  |
|        | PUT|PATCH | api/products/{product}      | products.update  |
|        |           |                             |                  |
|        | DELETE    | api/products/{product}      | products.destroy |
|        |           |                             |                  |
|        | POST      | api/removeproduct           |                  |
|        |           |                             |                  |
|        | GET|HEAD  | api/userproducts            |                  |
|        |           |                             |                  |
+--------+-----------+-----------------------------+------------------+

## Create and seed database

After the project has been cloned, You can create a database in MySQL and complete the DB configuration in your .env file.

- Migration files are located in database/migrations
- Seeders are located in migrations/seeders
- Factory files are located in database/factoris

The command below creates the database schema.
```
php artisan migrate
```
To enable you test the endpoints with applications such as postman use the following command to pre-populate the database.
```
php artisan db:seed
```
After this command, 2 users will be created in the database. The users and their generated tokens will be written to laravel.log file
```
find users and tokens in storage/logs/laravel.log
```


## Make request to endpoints

## Run tests
