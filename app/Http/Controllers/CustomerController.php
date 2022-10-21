<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
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
        return DB::table('users')
            ->join('customers', 'users.user_id', '=', 'customers.user_id')
            ->select('users.user_id','users.email','customers.phone', 'customers.name')
            ->get();


    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $id  = uniqid('user');

        $request->validate([
            'name'           =>'required',
            'email'          =>'required',
            'password'       =>'required',
            'gender'         =>'required',
            'phone'          =>'required',
            'birth_date'     =>'required',
        ]);

        $user       = new User();
        $customer   = new Customer();
    
        
        $user->user_id   = $id;
        $user->email     = $request->email;
        $user->password  = $request->password;
        $user->user_type = 'customer';
        $user->save();

        
        $customer->customer_id   = $id;
        $customer->user_id       = $id;
        $customer->name          = $request->name;
        $customer->phone         = $request->phone;
        $customer->gender        = $request->gender;
        $customer->birth_date    = $request->birth_date;
        $customer->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($customer)
    {
        //
        return Customer::select('*')->where('customer_id',$customer)->get();
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
