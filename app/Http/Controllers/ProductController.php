<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;


class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Product $product): JsonResponse
    {
        return response()->json($product->paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $productRequest): JsonResponse
    {
        $product = Product::create([
            'name' => $productRequest->productAllowedInputs()['name'],
            'price' => $productRequest->productAllowedInputs()['price'],
        ]);

        return response()->json($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product): JsonResponse
    {
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $productRequest, Product $product): JsonResponse
    {
        $product->update([
            'name' => $productRequest->productAllowedInputs()['name'],
            'price' => $productRequest->productAllowedInputs()['price'],
        ]);

        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        $product->forceDelete();

        return response()->json([
            'status' => '200',
            'message' => 'product is deleted',
            ]);
    }
}
