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
        //
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


        
        //insert user table
        $user->user_id   = $user_id;
        $user->email     = $request->email;
        $user->password  = $request->password;
        $user->user_type = 'customer';
        $user->save();

        //insert customer table
        $customer->customer_id   = $user_id;
        $customer->user_id       = $user_id;
        $customer->name          = $request->name;
        $customer->phone         = $request->phone;
        $customer->gender        = $request->gender;
        $customer->birth_date    = $request->birth_date;
        $customer->save();

        //create a cart for user
        $cart->cart_id     = $cart_id;
        $cart->customer_id = $user_id;
        $cart->save();

        return response('the operation has done');
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
        $customer =  DB::table('customers')
        ->join('users', 'customers.user_id', '=', 'users.user_id')
        ->select('users.user_id','users.email','users.password','customers.phone', 'customers.name')
        ->where('customers.customer_id','=',$user_id)
        ->get();
        
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
        
        //update in user table
        User::where('user_id',$user_id)
        ->update(['email' => $request->email,'password'=> $request->password]);

        //update in customer table
        Customer::where('customer_id',$user_id)
        ->update(['name' => $request->name,'phone'=> $request->phone]);

        return response('the update is done !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {
        Cart::where('customer_id',$user_id)->delete();
        Customer::where('customer_id',$user_id)->delete();
        User::where('user_id',$user_id)->delete();
        return response('the delete is done !');
    }
}
