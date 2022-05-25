<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\UserProduct;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController as Controller;

class UserProductController extends Controller
{
    public function getUserProducts (Request $request)
    {
        $user = $request->user();

        $user_products =  UserProduct::join('products', 'user_products.product_id', 'products.id')
        ->select('user_products.id as user_product_id', 'user_id', 'product_id', 'name', 'description', 'price')
        ->where('user_id', $user->id)
        ->get();

        if ($user_products->isEmpty()) 
        {
            return $this->errorResponseJSON("Nothing found for ". $user->first_name);
        }

        return $this->successResponseJSON('Products List for '. $user->first_name, $user_products);
    }



    public function removeUserProduct(Request $request)
    {

        $user = $request->user();
        $user_product = UserProduct::where('id', $request->user_product_id)->where('user_id', $user->id);
        $user_product = $user_product->delete();

        if (!$user_product)
        {
            return $this->errorResponseJSON("No product found to remove..");
        }

        return $this->successResponseJSON("Product removed from " . $user->first_name . "'s list", []);
    }



    public function addProductToUserList (Request $request)
    {
       $user = $request->user();
       $input_request = $request->all();

       $validate = Validator::make($input_request, [
           'product_id' => 'required'
       ]);

       if ($validate->fails())
       {
           return $this->errorResponseJSON("Error adding product to ". $user->first_name . "'s list", $validate->errors());
       }

       $product = Product::find($input_request['product_id']);

       if (!$product)
       {
          return $this->errorResponseJSON("Product does not exist");
       }


       UserProduct::create([
            'user_id' => $user->id, 
            'product_id' => $input_request['product_id']
       ]);

       $product = Product::find($input_request['product_id']);
       return $this->successResponseJSON($product->name ." added", new ProductResource($product));
    }
}
