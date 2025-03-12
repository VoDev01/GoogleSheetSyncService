<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
        $response = Http::post(env('APP_URL') . '/api/v1/products/create', ['name' => $validated['name'], 'status' => $validated['status']]);
        if($response->ok())
            return redirect()->back();
        else
            return redirect()->back()->withException(throw new Exception($response->json('message')));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $response = Http::post(env('APP_URL') . '/api/v1/products/show', ['id' => $product->id]);
        if($response->ok())
            return redirect()->back();
        else
            return redirect()->back()->withException(throw new Exception($response->json('message')));
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
        $response = Http::post(env('APP_URL') . '/api/v1/products/update', ['name' => $validated['name'], 'status' => $validated['status']]);
        if($response->ok())
            return redirect()->back();
        else
            return redirect()->back()->withException(throw new Exception($response->json('message')));
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
    public function destroy(Request $request)
    {
        $response = Http::post(env('APP_URL') . '/api/v1/products/destroy', ['id' => $request->name]);
        if($response->ok())
            return redirect()->back();
        else
            return redirect()->back()->withException(throw new Exception($response->json('message')));
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
