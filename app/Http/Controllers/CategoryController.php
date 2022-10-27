<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::select('category_id','name','description')->get();
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
            'name'        => 'required',
            'description' => 'required',
        ]);
        $category_id = uniqid('category_');
        $category = new Category();
        $category->category_id  =  $category_id;
        $category->name         =  $request->name;
        $category->description  =  $request->description;
        $category->save();

        return response('The add of Category is Done !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($category_id)
    {
        $category = Category::select('category_id','name','description')->where('category_id',$category_id)->get();
        return $category;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$category_id)
    {
        $request->validate([
            'name'        =>  'required',
            'description' =>  'required'
        ]);

        Category::where('category_id',$category_id)
        ->update(['name'      =>$request->name,
                'description' =>$request->description
                ]);

        return response('Category updated is done !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($category_id)
    {
        Category::where('category_id','=',$category_id)->delete();
        return response('Delete category is done !');
    }
}
