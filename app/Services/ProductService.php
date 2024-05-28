<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductType;

class ProductService
{
    public function createProduct($data)
    {

        $product = Product::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'type_id' => $data['type_id'],
            'amount' => $data['amount'],
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?? null,
        ]);

        return $product;
    }

    public function getProducts($request)
    {
        //mỗi trang 10 item
        $term = $request->input('search');
        $sortBy = $request->input('sort_by', 'name');
        $sortDirection = $request->input('sort_direction', 'asc');
        $products = Product::search($term)
            ->sort($sortBy, $sortDirection)
            ->paginate(10);
        return $products;
    }

    public function updateProduct($id, $data)
    {
        $product = Product::find($id);
        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->amount = $data['amount'];
        $product->description = $data['description'];
        $product->image = $data['image'];
        $product->save();
        return $product;
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        $product->delete();
        return true;
    }

    public function getProduct($id)
    {
        $product = Product::find($id);
        return $product;
    }

    public function addProductTypes($data)
    {
        $product_types = ProductType::create([
            'name' => $data['name'],
        ]);

        return $product_types;
    }
    public function updateProductTypes($id, $data)
    {
        $product_types = ProductType::find($id);
        $product_types->name = $data['name'];
        $product_types->save();
        return $product_types;
    }
    public function deleteProductTypes($id)
    {
        $product_types = ProductType::find($id);
        $product_types->delete();
        return true;
    }
    public function getProductTypes($id)
    {
        $product_types = ProductType::find($id);
        return $product_types;
    }
    public function getAllProductTypes($request)
    {
        $term = $request->input('search');
        $sortBy = $request->input('sort_by', 'name');
        $sortDirection = $request->input('sort_direction', 'asc');
        $product_types = ProductType::search($term)
            ->sort($sortBy, $sortDirection)
            ->paginate(10);
        return $product_types;
    }
}
