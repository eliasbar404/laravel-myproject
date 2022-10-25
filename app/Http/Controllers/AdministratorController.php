<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdministratorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Administrator::select('user_id')->get();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id    = uniqid('user');
        $user_type  = 'admin';
        $request->validate([
                'email'    =>'required',
                'password' =>'required',
            ]);

        $user = new User();
        $user->user_id    = $user_id;
        $user->email      = $request->email;
        $user->password   = $request->password;
        $user->user_type  = $user_type;
        $user->save();
    
        $administrator = new Administrator();
        $administrator->administrator_id = $user_id;
        $administrator->user_id          = $user_id;
        $administrator->save();

        return response('the add of the admin is done !');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $administrator =  DB::table('administrators')
        ->join('users', 'administrators.user_id', '=', 'users.user_id')
        ->select('users.user_id','users.email','users.password')
        ->where('administrators.administrator_id','=',$user_id)
        ->get();
        
        return $administrator;
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function update($user_id , Request $request)
    {
        $request->validate([
            "email"    =>"required",
            "password" =>"required"
        ]);
        
        // update in user table
        User::where('user_id',$user_id)
        ->update(["email"=>$request->email,"password"=>$request->password]);

        return response('updating admin is done !');







    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Administrator  $administrator
     * @return \Illuminate\Http\Response
     */
    public function destroy(Administrator $administrator)
    {
        //
    }
}
