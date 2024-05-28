<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = $this->productService->getProducts($request);
        return response()->json(['message' => 'success', 'products' => $products], 201);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|float',
            'type_id' => 'required|integer',
            'amount' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $this->productService->createProduct($request->all());
        return response()->json(['message' => 'success'], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = $this->productService->getProduct($id);
        return response()->json(['message' => 'success', 'product' => $product], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $product = $this->productService->updateProduct($id, $request->all());
        return response()->json(['message' => 'success', 'product' => $product], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|float',
            'type_id' => 'required|integer',
            'amount' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $this->productService->updateProduct($id, $request->all());
        return response()->json(['message' => 'success'], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return response()->json(['message' => 'success'], 200);
    }

    public function addProductTypes(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|float',
            'type_id' => 'required|integer',
            'amount' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $productTypes = $this->productService->addProductTypes($request->all());
        return response()->json(['message' => 'success'], 201);
    }

    public function destroyProductTypes($id)
    {
        $productTypes = $this->productService->deleteProductTypes($id);
        return response()->json(['message' => 'success'], 201);
    }

    public function updateProductTypes($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|float',
            'type_id' => 'required|integer',
            'amount' => 'required|integer',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $productTypes = $this->productService->updateProductTypes($id, $request->all());
        return response()->json(['message' => 'success'], 201);
    }
    public function getProductTypes($id)
    {
        $productType = $this->productService->getProductTypes($id);
        return response()->json(['message' => 'success', 'productType' => $productType], 200);
    }
    public function getAllProductTypes(Request $request)
    {
        $productTypes = $this->productService->getAllProductTypes($request);
        return response()->json(['message' => 'success', 'productTypes' => $productTypes], 200);
    }
}
