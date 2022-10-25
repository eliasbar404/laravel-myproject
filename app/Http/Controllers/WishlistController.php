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
        $id  = uniqid('wishlist');
        $request->validate([
            'customer_id' =>'required',
            'product_id'  =>'required',
        ]);

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
        $customer =  DB::table('customers')
        ->join('wish_lists', 'customers.customer_id', '=', 'customers.customer_id')
        ->join('products','wish_list.product_id','=','products.product_id')
        ->select('users.user_id','products.product_id','products.name','products.price','prodocuts.discount')
        ->where('wish_lists.wishlist_id','=',$customer_id)
        ->get();
        
        return $customer;
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
