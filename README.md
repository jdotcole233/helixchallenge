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
+--------+-----------+-----------------------------+------------------+---------------------------------------------------------------------+------------------------------------------+
| Domain | Method    | URI                         | Name             | Action                                                              | Middleware                               |
+--------+-----------+-----------------------------+------------------+---------------------------------------------------------------------+------------------------------------------+
|        | POST      | api/addProductToUserList    |                  | App\Http\Controllers\API\UserProductController@addProductToUserList | api                                      |
|        |           |                             |                  |                                                                     | App\Http\Middleware\Authenticate:sanctum |
|        | GET|HEAD  | api/products                | products.index   | App\Http\Controllers\API\ProductController@index                    | api                                      |
|        |           |                             |                  |                                                                     | App\Http\Middleware\Authenticate:sanctum |
|        | POST      | api/products                | products.store   | App\Http\Controllers\API\ProductController@store                    | api                                      |
|        |           |                             |                  |                                                                     | App\Http\Middleware\Authenticate:sanctum |
|        | GET|HEAD  | api/products/{product}      | products.show    | App\Http\Controllers\API\ProductController@show                     | api                                      |
|        |           |                             |                  |                                                                     | App\Http\Middleware\Authenticate:sanctum |
|        | PUT|PATCH | api/products/{product}      | products.update  | App\Http\Controllers\API\ProductController@update                   | api                                      |
|        |           |                             |                  |                                                                     | App\Http\Middleware\Authenticate:sanctum |
|        | DELETE    | api/products/{product}      | products.destroy | App\Http\Controllers\API\ProductController@destroy                  | api                                      |
|        |           |                             |                  |                                                                     | App\Http\Middleware\Authenticate:sanctum |
|        | POST      | api/removeproduct           |                  | App\Http\Controllers\API\UserProductController@removeUserProduct    | api                                      |
|        |           |                             |                  |                                                                     | App\Http\Middleware\Authenticate:sanctum |
|        | GET|HEAD  | api/userproducts            |                  | App\Http\Controllers\API\UserProductController@getUserProducts      | api                                      |
|        |           |                             |                  |                                                                     | App\Http\Middleware\Authenticate:sanctum |
+--------+-----------+-----------------------------+------------------+---------------------------------------------------------------------+------------------------------------------+

## Create and seed database

  After the project has been cloned, You can create a database in MySQL and complete the DB configuration in your .env file.

- Migration files are located in database/migrations
- Use the migrate to create schemas in your linked DB.
- Use the db:seed command to pre-populate the DB.

## Make request to endpoints

## Run tests

