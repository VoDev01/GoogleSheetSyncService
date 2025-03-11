<?php

namespace App\Http\Controllers\API\V1;

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
        $products = Product::paginate(15);
        return response(['products' => $products]);
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
        Product::create($validated);
        return response();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $product = Product::find($request->id);
        return response(['product' => $product]);
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
        $product = Product::where('id', $validated['id'])->get()->first();
        $product->name = $validated['name'];
        $product->status = $validated['status'];
        $product->save();
        return response();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  string $name
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Product::where('name', 'like', '%'.$request->name.'%')->get()->first()->destroy();
        return response();
    }
}