<?php

namespace App\Http\Controllers;

use App\Models\Shopping_cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Shopping_cart::all();
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

        return response('The shopping cart is added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shopping_cart  $shopping_cart
     * @return \Illuminate\Http\Response
     */
    public function show($cart_id)
    {
        //
        // return Shopping_cart::where('cart_id',$cart_id)->get();
        return DB::table('shopping_carts')
        ->join('products','shopping_carts.product_id','=','products.product_id')
        ->select('products.price','shopping_carts.quantity','products.product_id','products.discount','shopping_cart_id')
        ->where('cart_id',$cart_id)->get();
        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shopping_cart  $shopping_cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$shopping_cart_id)
    {
        $request->validate([
            'quantity'   => 'required',
        ]);

        Shopping_cart::where('shopping_cart_id',$shopping_cart_id)
        ->update(['quantity' => $request->quantity]);

        return response('shopping cart update is done !');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shopping_cart  $shopping_cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($shopping_cart_id)
    {
        Shopping_cart::where('shopping_cart_id',$shopping_cart_id)
        ->delete();

        return response("the delete of shopping cart is done !");
    }
}
