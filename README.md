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
* Clone the application from github
```
git clone https://github.com/jdotcole233/helixchallenge.git
```
* You can run ```composer update``` after cloning to install dependencies in the composer.json file
* create a copy  of ```.env.example``` using this cmd from the root directory of the application.
```
  cp .env.example .env
```
* The following command will generate an app key if it doesn't exist.
```
php artisan key:gen
```

* Go to [Databases](#create-and-seed-database)
* Ready to test the app.


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

|  METHOD | URI | NAME
|---------|-----|------------------------------
|  POST | api/addProductToUserList | 
|  GET  |  api/products |  products.index
|  POST | api/products |  products.store
|  GET | api/products/{product} | products.show
|  PUT | api/products/{product} | products.update
|  DELETE | api/products/{product} | products.destroy
|  POST | api/removeproduct | 
|  GET | api/userproducts | 

## Create and seed database

After the project has been cloned, You can create a database in MySQL and complete the DB configuration in your ```.env``` file.

- Migration files are located in ```database/migrations```
- Seeders are located in ```migrations/seeders```
- Factory files are located in ```database/factories```

The command below creates the database schema programtically using the migration files.
```
php artisan migrate
```
To enable you test the endpoints with http simulation applications such as ```postman``` use the following command to pre-populate the database.
```
php artisan db:seed
```

## find tokens here
After this command: 2 users, 20 products and 10 products attached to each user will be created in your database. The users and their generated tokens will be written to laravel.log file
```
find users and tokens in storage/logs/laravel.log
```


## Make request to endpoints

You can use any tool to simulate HTTP request to the server.

### HTTP request tools
- POSTMAN
- Insomnia
- Advanced


- Start the server from the parent directory of the application using 

```
php artisan serve
```

All request to the Endpoints must have the following headers

```
 Accept: application/json
 Authorization: Bearer $token
```
tokens can be found [here](#find-tokens-here) under [Create and seed database](#create-and-seed-database) section

Examples: You can also make a curl request to the server using

- GET request (example)
```
curl http://{HOST}:{PORT}/api/products -H "Accept: application/json" -H "Authorization: Bearer {TOKEN}"
```

- POST request (example)

```
curl -X POST http://{HOST}:{PORT}/api/products -H "Accept: application/json" -H "Authorization: Bearer {TOKEN}" -H "Content-type: application/json"  -d '{"name" : "Air Conditioner", "description" : "Fast freexing Air Conditioner", "price" : 234.00, "image" : "" }'
```



## Run tests

You can run the tests by running the command below in your terminal 
```
./vendor/bin/phpunit
```
This should be done from the root directory of the application.

