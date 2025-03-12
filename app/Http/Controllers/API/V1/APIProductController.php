<?php

namespace App\Http\Controllers\API\V1;

use Exception;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class APIProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
            $products = Product::paginate(15);
        }
        catch (Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 500);
        }
        return response()->json(['products' => $products]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        try
        {
            Product::create(array_combine(array_keys($validated), array_values($validated)));
        }
        catch (Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 500);
        }
        return response()->json();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try
        {
            $product = Product::find($request->id);
        }
        catch (Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 500);
        }
        return response()->json(['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request)
    {
        $validated = $request->validated();
        try
        {
            $product = Product::where('id', $validated['id'])->get()->first();
            $product->name = $validated['name'] ?? $product->name;
            $product->status = $validated['status'] ?? $product->status;
            $product->save();
        }
        catch (Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 500);
        }
        return response()->json();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  string $name
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try
        {
            Product::where('name', 'like', '%' . $request->name . '%')->get()->first()->delete();
        }
        catch (Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 500);
        }
        return response()->json();
    }
}