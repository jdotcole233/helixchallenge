<?php

namespace Tests\Feature;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\User;
use App\Models\UserProduct;
use Database\Seeders\UserSeeder;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Illuminate\Support\Str;

class ProductTest extends TestCase
{

    public string $api_endpoint = '/api/products';


    public function test_that_it_can_list_products ()
    {
        Product::query()->delete();
        Product::factory(2)->create();
        $products = Product::select('id', 'name', 'description', 'price', 'image')->get()->toArray();
        $this->makeTestRequest('GET', $this->api_endpoint, [], $products, 'Products retrieved..');
    }

    public function test_that_it_can_add_products_successfully ()
    {
        $payload = [
            'name' => 'iPhone',
            'description' => '13 prox Max with storage capacity of 64GB',
            'price' => 22.5,
            'image' => null
        ];
        $this->makeTestRequest('POST', $this->api_endpoint, $payload, $payload, $payload['name'] . ' add to list of products');
    }

    public function test_that_it_can_find_product ()
    {
        $item = [
            'name' => 'iPad',
            'description' => 'Pro Mini with storage capacity of 512GB',
            'price' => 650.99,
            'image' => null
        ];
        
        Product::query()->delete();
        $product = Product::create($item)->first();
        $this->makeTestRequest('GET', $this->api_endpoint. DIRECTORY_SEPARATOR. $product->id, [], $item, "Product found..");
    }

    public function test_that_it_can_update_product ()
    {
        $product = Product::create([
            'name' => 'iPhine',
            'description' => '12 prxo Max with storage capacity of 64GB',
            'price' => 22.5,
            'image' => null
        ]);

        $payload = [
            'name' => 'iPhone',
            'description' => '12 prox Max with storage capacity of 128GB',
            'price' => 999.45,
            'image' => null
        ];

        $this->makeTestRequest('PUT', $this->api_endpoint.'/'.$product->id, $payload, $payload, $payload['name'] . ' updated successfully..');
    }

    public function test_that_product_can_be_deleted ()
    {        
        $product = Product::create([
            'name' => 'Test Product',
            'description' => 'Test product description',
            'price' => 22.5,
            'image' => null
        ]);
        $this->makeTestRequest('DELETE', $this->api_endpoint.'/'.$product->id, [], [], 'Product removed from DB');
    }



    public function test_that_it_can_list_all_products_for_requesting_user ()
    {

        User::query()->delete();
        Product::query()->delete();

        $products = Product::factory(5)->create();
        $user = User::factory(2)->create()->first();

        $products->each(function ($product) use ($user) {
            UserProduct::create([
                'user_id' => $user->id,
                'product_id' => $product->id
             ]);
        });

        $token = $user->createToken('HelixChallengeToken')->plainTextToken;
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '. $token 
        ];

        $user_products = UserProduct::join('products', 'user_products.product_id', 'products.id')
        ->get('name','description', 'price', 'image')
        ->toArray();
    

        $this->json('GET', 'api/userproducts', [], $headers)
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => $user_products,
            'message' => 'Products List for '. $user->first_name
        ]);

    }

    public function test_that_it_can_attach_product_to_user ()
    {
        User::query()->delete();
        Product::query()->delete();

        $products = Product::factory(5)->create()->last()->toArray();

        $user = User::factory(2)->create()->first();
        $token = $user->createToken('HelixChallengeToken')->plainTextToken;
        
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '. $token
        ];

        $this->json('POST', '/api/addProductToUserList', ['product_id' => $products['id']], $headers)
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => [
                'id' => $products['id'],
                'name' => $products['name'],
                'description' => $products['description'],
                'price' => $products['price'],
                'image' => $products['image']
            ],
            'message' => $products['name'] ." added"
        ]);
    }

    public function test_that_product_can_be_dettached_from_user ()
    {
        User::query()->delete();
        Product::query()->delete();

        $products = Product::factory(5)->create()->last()->toArray();

        $user = User::factory(2)->create()->first();
        $token = $user->createToken('HelixChallengeToken')->plainTextToken;
        
        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '. $token
        ];

       $user_product = UserProduct::create([
            'user_id' => $user->id,
            'product_id' => $products['id'],
        ]);

        $this->json('POST', '/api/removeproduct', ['user_product_id' => $user_product->id], $headers)
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => [],
            'message' => "Product removed from " . $user->first_name . "'s list"
        ]);
    }

    private function makeTestRequest ($method, $endpoint, $payload, $data, $message = "")
    {
        $user = User::factory(2)->create()->first();
        $token = $user->createToken('HelixSleepChallenge')->plainTextToken;
        $headers = ['Accept' => 'application/json', 'Authorization' => 'Bearer '. $token];

        $this->json($method, $endpoint, $payload, $headers)
        ->assertStatus(200)
        ->assertJson([
            'success' => true,
            'data' => $data,
            'message' => $message
        ]);
    }
}
