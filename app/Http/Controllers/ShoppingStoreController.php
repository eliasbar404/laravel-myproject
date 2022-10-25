<?php

namespace App\Http\Controllers;

use App\Models\Shopping_store;
use App\Models\User;
use Illuminate\Http\Request;

class ShoppingStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return shopping_store::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // $user_type      ='shopping_store';

        $request->validate([
            'email'      => 'required',
            'password'   => 'required',
            'name'       => 'required',
            'phone'      => 'required',
            'phone2'     => 'required',
            'address'    => 'required',
            'address2'   => 'required',
            'description'=> 'required'
        ]);

        $user_id  = uniqid('user_');
        $user = new User();
        $user->user_id   = $user_id ;
        $user->password  = $request->password;
        $user->email     = $request->email;
        $user->user_type = 'shopping_store';
        $user->save();

        $shopping_store = new Shopping_store();
        $shopping_store->shopping_store_id  = $user_id;
        $shopping_store->user_id            = $user_id;
        $shopping_store->name               = $request->name;
        $shopping_store->phone              = $request->phone;
        $shopping_store->phone2             = $request->phone2;
        $shopping_store->address            = $request->address;
        $shopping_store->address2           = $request->address2;
        $shopping_store->description        = $request->description;
        $shopping_store->save();

        return response('the shopping store was added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\shopping_store  $shopping_store
     * @return \Illuminate\Http\Response
     */
    public function show($shopping_store_id)
    {
        $shopping_store_data = Shopping_store::select('shopping_store_id','name','phone','phone2','address','address2','description')
                                ->where('shopping_store_id',$shopping_store_id)
                                ->get();

        return $shopping_store_data;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\shopping_store  $shopping_store
     * @return \Illuminate\Http\Response
     */
    public function update($shopping_store_id,Request $request)
    {
        $request->validate([
            'email'       =>'required',
            'password'    =>'required',
            'name'        =>'required',
            'phone'       =>'required',
            'phone2'      =>'required',
            'address'     =>'required',
            'address2'    =>'required',
            'description' =>'required'

        ]);
        
        User::where('user_id',$shopping_store_id)
        ->update([  'email'   =>$request->email,
                    'password'=>$request->password
                ]);


        Shopping_store::where('shopping_store_id',$shopping_store_id)
        ->update([  'name'        =>$request->name,
                    'phone'       =>$request->phone,
                    'phone2'      =>$request->phone2,
                    'address'     =>$request->address,
                    'address2'    =>$request->address2,
                    'description' =>$request->description
                ]);

        return response('the update of shopping store was done !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\shopping_store  $shopping_store
     * @return \Illuminate\Http\Response
     */
    public function destroy($shopping_store_id)
    {
        Shopping_store::where('shopping_store_id',$shopping_store_id)->delete();
        User::where('user_id',$shopping_store_id)->delete();

        return response('the shopping sotore is deleted !');
    }
}
