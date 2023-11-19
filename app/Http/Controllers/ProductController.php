<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'commercial_name' => 'required',
            'scientific_name' => 'required',
            'manufacture_company' => 'required',
            'price' => 'required'
            // 'description'=> 'required'
        ]);


        return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Product::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $product = Product::find($id);
        if ($product !== null) {

            $product->update($request->all());
            return response([

                'massage' => 'updated',
                'product' => $product], 201);
        } else {
            return response([

                'message' => 'not found'], 401);
        }

        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $product = Product::find($id);
        if ($product !== null && $product->owner_email == auth()->user()->email) {

            $product->delete();

            return response([

                'message' => 'deleted'], 201);
        } else {
            return response([

                'message' => 'not found'], 401);
        }

    }

    public function search($name)

    {
        $result1 = Product::Where('commercial_name', 'like', '%' . $name . '%')
                        ->orwhere('scientific_name', 'like', '%' . $name . '%')
                        ->get();
        if ($result1) {
            return $result1;}

         else {
            return response([
                'message' => 'not found'], 404);
        }
    }
}


