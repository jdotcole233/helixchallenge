<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\BaseController;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\UserProduct;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends BaseController
{
    public function index()
    {
        $products = Product::all();

        if (!$products)
        {
            return $this->errorResponseJSON('No Products found');
        }

        return $this->successResponseJSON('Products retrieved..', ProductResource::collection($products));
    }

    public function store (Request $request)
    {
        $inputRequest = $request->all();

        $validate = Validator::make($inputRequest, [
            'name' => 'required',
            'description' => 'max:255',
            'price' => 'required'
        ]);

        if ($validate->fails())
        {
            return $this->errorResponseJSON('Product creation failed..', $validate->errors());
        }

        $productCreated  = Product::create($inputRequest);
        $productResource = new ProductResource($productCreated);
        $succesMessage  = $productResource->name . ' add to list of products';

        return $this->successResponseJSON($succesMessage, $productResource);
    }

    public function show ($product_id)
    {
        $product = Product::find($product_id);
        if (!$product)
        {
            return $this->errorResponseJSON('Not product found..');
        }

        $productResource = new ProductResource($product);
        info("Product resource ". json_encode($productResource));
        return $this->successResponseJSON('Product found..', $productResource);
    }

    public function update (Request $request, Product $product)
    {
        info("pro ". json_encode($request->all()));
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'description' => 'max:100',
            'price' => 'required'
        ]);

        if ($validate->fails())
        {
            return $this->errorResponseJSON('Product creation failed..', $validate->errors());
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;

        $productResource = new ProductResource($product);
        return $this->successResponseJSON($request->name . ' updated successfully..', $productResource);
    }

    public function destroy (Product $product)
    {
        $product->delete();
        return $this->successResponseJSON('Product removed from DB', []);
    }
}
