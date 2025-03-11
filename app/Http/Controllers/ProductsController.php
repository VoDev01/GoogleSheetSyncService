<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(15);
        return view('products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
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
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product = Product::find($product->id);
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.update');
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
        $product->name = $validated['name'] ?? $product->name;
        $product->status = $validated['status'];
        $product->save();
        return redirect()->back();
    }
    public function delete()
    {
        return view('products.destroy');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  string $name
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $name)
    {
        Product::where('name', 'like', '%'.$name.'%')->get()->first()->destroy();
        return redirect()->back();
    }

    /**
     * Сгенерировать 1000 строк в таблицу
     * 
     * @return \Illuminate\Http\Response
     */
    public function generate()
    {
        Product::factory()->count(1000)->create();
        return redirect()->back();
    }
    /**
     * Очистить таблицу
     * 
     * @return \Illuminate\Http\Response
     */
    public function clear()
    {
        Product::truncate();
        return redirect()->back();
    }
}
