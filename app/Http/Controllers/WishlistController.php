<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'customer_id' =>'required',
            'product_id'  =>'required',
        ]);

        $id  = uniqid('wishlist_');
        $wishlist = new Wishlist();
        $wishlist->wishlist_id  = $id;
        $wishlist->customer_id  = $request->customer_id;
        $wishlist->product_id   = $request->product_id;
        $wishlist->save();

        return response('the product is added to your wishlist !');



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show($customer_id)
    {
        $wish_list =  DB::table('wish_lists')
        ->join('customers', 'customers.customer_id', '=', 'wish_lists.customer_id')
        ->join('products','wish_lists.product_id','=','products.product_id')
        ->select('products.product_id','products.name','products.price','products.discount')
        ->where('wish_lists.customer_id','=',$customer_id)
        ->get();
        
        return $wish_list;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy($wishlist_id)
    {
        Wishlist::where('wishlist_id',$wishlist_id)->delete();
        return response('Remove record from wish list was success !');
    }
}
