<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if($request->has('shopping_store_id')){
            return Gallery::where('shopping_store_id',$request->shopping_store_id)->get();
        }
        else{
            return Gallery::all();
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
        $request->validate([
            'image'             => 'required|image',
            'shopping_store_id' => 'required',
        ]);

        $gallery_img  = new Gallery();
        $image_id     = uniqid('image_');
        $gallery_img->image_id    = $image_id;
        $gallery_img->shopping_store_id  = $request->shopping_store_id;

        $filename = Str::random(32).".".$request->image->getClientOriginalExtension();
        $request->image->move('uploads/', $filename);


        $gallery_img->image  = $filename;
        $gallery_img->save();
        return response('done!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show($shopping_store_id)
    {
        //

        return Gallery::where('shopping_store_id',$shopping_store_id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        //
    }
}
