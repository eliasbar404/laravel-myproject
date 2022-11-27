<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Cart;
// use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Customer::all();
        $customers =  DB::table('users')
            ->join('customers', 'users.user_id', '=', 'customers.user_id')
            ->select('users.user_id','users.email','customers.phone', 'customers.name')
            ->where('users.user_type','=','customer')
            ->get();

        return $customers;
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
            'name'           =>'required',
            'email'          =>'required',
            'password'       =>'required',
            'gender'         =>'required',
            'phone'          =>'required',
            'birth_date'     =>'required',
        ]);
        
        $user_id      = uniqid('user_');
        $cart_id      = uniqid('cart_');

        $user       = new User();
        $customer   = new Customer();
        $cart       = new Cart();

        //insert Into User table
        // --------------------
        $user->user_id   = $user_id;
        $user->email     = $request->email;
        $user->password  = $request->password;
        $user->user_type = 'customer';
        $user->save();
        //insert Into customer table
        // -------------------------
        $customer->customer_id   = $user_id;
        $customer->user_id       = $user_id;
        $customer->name          = $request->name;
        $customer->phone         = $request->phone;
        $customer->gender        = $request->gender;
        $customer->birth_date    = $request->birth_date;
        $customer->save();
        //create a cart for user/customer
        // ---------------------
        $cart->cart_id     = $cart_id;
        $cart->customer_id = $user_id;
        $cart->save();
        
        return response('The creation of a Customer has done !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        //
        $customer =  DB::table('users')
        ->join('customers', 'users.user_id', '=', 'customers.user_id')
        ->join('carts','customers.user_id','=','carts.customer_id')
        ->select('users.user_id','users.email','users.password','customers.phone', 'customers.name','carts.cart_id')
        ->where('customers.customer_id','=',$user_id)
        ->get();

        // $shopping_carts = DB::table('customers')
        // ->join('carts','customers.customer_id','=','carts.customer_id')
        // ->join('shopping_carts','carts.cart_id','=','shopping_carts.cart_id')
        // ->join('products','shopping_carts.product_id','=','products.product_id')
        // ->join('images','products.product_id','=','images.product_id')
        // // ->join('products','images.product_id','=','products.product_id')
        // ->select('shopping_carts.shopping_cart_id','shopping_carts.product_id','products.name','products.price','shopping_carts.quantity','images.image','products.discount')
        // ->where('customers.customer_id',$user_id)
        // ->get();

        // $wish_list = DB::table('customers')
        // ->join('wish_lists','customers.customer_id','=','wish_lists.customer_id')
        // ->join('products','wish_lists.product_id','=','products.product_id')
        // // ->join('shopping_stores','shopping_stores.product_id','=','products.product_id')
        // ->join('images','products.product_id','=','images.product_id')
        // ->select('products.product_id','products.name','products.price','images.image','products.discount')
        // ->where('customers.customer_id',$user_id)
        // ->get();
        
        return $customer;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update($user_id,Request $request)
    {   
        $request->validate([
            'name'           =>'required',
            'email'          =>'required',
            'password'       =>'required',
            'phone'          =>'required',
        ]);
        
        // Update in user table
        // -------------------
        User::where('user_id',$user_id)
        ->update(['email' => $request->email,'password'=> $request->password]);

        // Update in customer table
        // -----------------------
        Customer::where('customer_id',$user_id)
        ->update(['name' => $request->name,'phone'=> $request->phone]);

        return response('The update of Customer is  done !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        // Delete Cart
        Cart::where('customer_id',$user_id)->delete();
        // Delete in Customer table
        Customer::where('customer_id',$user_id)->delete();
        // Delete in user table
        User::where('user_id',$user_id)->delete();


        return response('The delete of Customer is  done !');
    }
}
