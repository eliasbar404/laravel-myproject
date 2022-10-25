<?php

namespace App\Http\Controllers;

use App\Models\Shopping_cart;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'cart_id'    =>'required',
            'product_id' =>'required',
            'quantity'   =>'required',
        ]);

        $shopping_cart_id = uniqid('shopping_cart_');

        $shopping_cart = new Shopping_cart();
        $shopping_cart->shopping_cart_id = $shopping_cart_id;
        $shopping_cart->cart_id          = $request->cart_id;
        $shopping_cart->product_id       = $request->product_id;
        $shopping_cart->quantity         = $request->quantity;
        $shopping_cart->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shopping_cart  $shopping_cart
     * @return \Illuminate\Http\Response
     */
    public function show(Shopping_cart $shopping_cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shopping_cart  $shopping_cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Shopping_cart $shopping_cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shopping_cart  $shopping_cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shopping_cart $shopping_cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shopping_cart  $shopping_cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shopping_cart $shopping_cart)
    {
        //
    }
}
