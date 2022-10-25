<?php

namespace App\Http\Controllers;

use App\Models\Product;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = uniqid('product');

        $request->validate([
            'name'              => 'required',
            'description'       => 'required',
            'price'             => 'required',
            'discount'          => 'required',
            'shopping_store_id' => 'required',
            'category_id'       => 'required',
        ]);

        $product_id = uniqid('product_');
        $product = new Product();
        $product->product_id        = $product_id;
        $product->name              = $request->name;
        $product->description       = $request->description;
        $product->price             = $request->price;
        $product->discount          = $request->discount;
        $product->shopping_store_id = $request->shopping_store_id;
        $product->category_id       = $request->category_id;
        $product->save();

        return response('the product insert is done !');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $request->validate([
            'category_id' => 'nullable',
            'name'        => 'nullable',
        ]);

        $product =  Product::where('category_id',$request->category_id);
        return $product;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id'        => 'required',
            'name'              => 'required',
            'description'       => 'required',
            'price'             => 'required',
            'discount'          => 'required',
        ]);

        Product::where('product_id',$request->product_id)
        ->update(['name' => $request->name,'description'=> $request->description
                ,'price'=>$request->price,'discount'=>$request->discount
                ,'shopping_store_id'=>$request->shopping_store_id,
                ]);

        return response('product update is done !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {
        Product::where('product_id',$product_id)->delete();
        return response('deleting product was done !');
    }
}
