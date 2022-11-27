<?php

namespace App\Http\Controllers;

use App\Models\Shopping_store;
use App\Models\User;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ShoppingStoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shopping_store = DB::table('shopping_stores')
        ->join('users','shopping_stores.user_id','=','users.user_id')
        ->select('shopping_stores.shopping_store_id','users.email','users.password',
        'shopping_stores.name','shopping_stores.phone','shopping_stores.address',
        'shopping_stores.description','shopping_stores.logo')
        ->get();
        return $shopping_store;
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
            'email'       =>'required',
            'password'    =>'nullable',
            'name'        =>'required',
            'phone'       =>'required',
            'phone2'      =>'nullable',
            'address'     =>'required',
            'address2'    =>'nullable',
            'description' =>'required',
            'image1'      =>'nullable|image',
            'shopping_store_id'=>'nullable'
            ]);
        // Update 
        if($request->hasFile('image1')){
            User::where('user_id',$request->shopping_store_id)
            ->update([  'email'   =>$request->email,
                        'password'=>$request->password
                    ]);


            // Create file
            $filename = Str::random(32).".".$request->image1->getClientOriginalExtension();
            $request->image1->move('uploads/', $filename);


            Shopping_store::where('shopping_store_id',$request->shopping_store_id)
            ->update([  'name'        =>$request->name,
                        'phone'       =>$request->phone,
                        'phone2'      =>$request->phone2,
                        'address'     =>$request->address,
                        'address2'    =>$request->address2,
                        'description' =>$request->description,
                        'logo'        =>$filename
                    ]);

        return response('The update of shopping store information is Done !');
        }
        else{
        // Insert into User table
        // ----------------------
        $user_id  = uniqid('user_');
        $user = new User();
        $user->user_id   = $user_id ;
        $user->password  = uniqid('pass');
        $user->email     = $request->email;   
        $user->user_type = 'shopping_store';
        $user->save();
        // Insert into Shopping store table
        // -------------------------------
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

        return response('The add of shopping store  is Done !');
        }




    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\shopping_store  $shopping_store
     * @return \Illuminate\Http\Response
     */
    public function show($shopping_store_id)
    {
        $shopping_store_data = DB::table('shopping_stores')
        ->join('users', 'shopping_stores.user_id', '=', 'users.user_id')
        ->select('shopping_stores.shopping_store_id','users.email','users.password', 'shopping_stores.name','shopping_stores.phone','shopping_stores.phone2','shopping_stores.address','shopping_stores.address2','shopping_stores.description','shopping_stores.logo')
        ->where('shopping_stores.shopping_store_id','=',$shopping_store_id)
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
    public function update(Request $request,$shopping_store_id)
    {
        $request->validate([
            'email'       =>'required',
            'password'    =>'required',
            'name'        =>'required',
            'phone'       =>'required',
            'phone2'      =>'required',
            'address'     =>'required',
            'address2'    =>'required',
            'description' =>'required',
            'image1'      =>'nullable|image',
            ]);
        
        User::where('user_id',$shopping_store_id)
        ->update([  'email'   =>$request->email,
                    'password'=>$request->password
                ]);

        if($request->hasFile('image1')){
            $store_logo  = new Image();
            $logo_id     = uniqid('image_');
            $store_logo->image_id    = $logo_id;
            $store_logo->product_id  = $shopping_store_id;
            $store_logo->type        = 'store_logo';

            // Create file
            $filename = Str::random(32).".".$request->file('image1')->getClientOriginalExtension();
            $request->file('image1')->move('uploads/', $filename);

            $store_logo->image  = $filename;
            $store_logo->save();

            Shopping_store::where('shopping_store_id',$shopping_store_id)
            ->update([  'name'        =>$request->name,
                        'phone'       =>$request->phone,
                        'phone2'      =>$request->phone2,
                        'address'     =>$request->address,
                        'address2'    =>$request->address2,
                        'description' =>$request->description,
                        'logo'        =>$filename
                    ]);

        return response('The update of shopping store information is Done !');
        }
        // Shopping_store::where('shopping_store_id',$shopping_store_id)
        // ->update([  'name'        =>$request->name,
        //             'phone'       =>$request->phone,
        //             'phone2'      =>$request->phone2,
        //             'address'     =>$request->address,
        //             'address2'    =>$request->address2,
        //             'description' =>$request->description
        //         ]);

        // return response('The update of shopping store information is Done !');
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

        return response('The Shopping Store is Deleted !');
    }
}
