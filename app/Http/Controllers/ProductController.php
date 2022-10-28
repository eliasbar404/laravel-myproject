<?php
namespace App\Models;
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Image;
use App\Models\Review;
use App\Models\Shopping_store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


use Illuminate\Support\Collection\array_filter;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pro = Product::all();
        return $pro;
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
            'name'              => 'required',
            'description'       => 'required',
            'price'             => 'required',
            'discount'          => 'required',
            'shopping_store_id' => 'required',
            'category_id'       => 'required',
            'image1'            => 'required|image',
            'image2'            => 'nullable|image',
            'image3'            => 'nullable|image',
            'image4'            => 'nullable|image',
            'image5'            => 'nullable|image'
        ]);

        $product_id = uniqid('product_');
        $product = new Product();
        $product->product_id        = $product_id;
        $product->name              = $request->name;
        $product->description       = $request->description;
        $product->price             = $request->price;
        $product->discount          = $request->discount;
        $product->shopping_store_id = $request->shopping_store_id;
        $product->category_id       = $request->category_id;
        $product->save();


            $product_img  = new Image();
            $image_id     = uniqid('image_');
            $product_img->image_id    = $image_id;
            $product_img->product_id  = $product_id;
            $product_img->type        = 'main_product_image';
    
            $imageName = Str::random() . '.' . $request->image1->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('product/image', $request->image1, $imageName);

            $product_img->image  = $imageName;
            $product_img->save();

            if($request->has('image2')){
                $product_img  = new Image();
                $image_id     = uniqid('image_');
                $product_img->image_id    = $image_id;
                $product_img->product_id  = $product_id;
                $product_img->type        = 'product_image2';
        
                $imageName = Str::random() . '.' . $request->image2->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('product/image', $request->image2, $imageName);
    
                $product_img->image  = $imageName;
                $product_img->save();

            };

            if($request->has('image3')){
                $product_img  = new Image();
                $image_id     = uniqid('image_');
                $product_img->image_id    = $image_id;
                $product_img->product_id  = $product_id;
                $product_img->type        = 'product_image3';
        
                $imageName = Str::random() . '.' . $request->image3->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('product/image', $request->image3, $imageName);
    
                $product_img->image  = $imageName;
                $product_img->save();

            };

            if($request->has('image4')){
                $product_img  = new Image();
                $image_id     = uniqid('image_');
                $product_img->image_id    = $image_id;
                $product_img->product_id  = $product_id;
                $product_img->type        = 'product_image4';
        
                $imageName = Str::random() . '.' . $request->image4->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('product/image', $request->image4, $imageName);
    
                $product_img->image  = $imageName;
                $product_img->save();

            };

            if($request->has('image5')){
                $product_img  = new Image();
                $image_id     = uniqid('image_');
                $product_img->image_id    = $image_id;
                $product_img->product_id  = $product_id;
                $product_img->type        = 'product_image5';
        
                $imageName = Str::random() . '.' . $request->image5->getClientOriginalExtension();
                Storage::disk('public')->putFileAs('product/image', $request->image5, $imageName);
    
                $product_img->image  = $imageName;
                $product_img->save();

            };


        return response('the product insert is done !');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$product_id)
    {

        // select product by category
        if($request->has('category_id')){

            $products = DB::table('categories')
            ->join('products','categories.category_id','=','products.category_id')
            ->join('images','products.product_id','=','images.product_id')
            ->select('products.name','images.image')
            ->where('categories.category_id',$request->category_id )
            ->where('images.type','=','main_product_image')
            ->get();

            return $products;
        }

        if($request->has('name')){

            $products = DB::table('categories')
            ->join('products','categories.category_id','=','products.category_id')
            ->join('images','products.product_id','=','images.product_id')
            ->select('products.name','images.image')
            ->where('products.name','like',"%$request->name%")
            ->where('images.type','=','main_product_image')
            ->get();

            return $products;
        }

        $product_data = Product::select('product_id','shopping_store_id','name','description','price','discount')->where('product_id',$product_id)->get();
        $shopping_store_data = Shopping_store::select('name')->where('shopping_store_id',$product_data[0]->shopping_store_id)->get();
        $images  = Image::select('image')->where('product_id',$product_id)->get();
        
        // i still dont finish this
        $review = DB::table('reviews')
        ->join('customers','reviews.customer_id','=','customers.customer_id')
        ->select('reviews.review_id','reviews.description','reviews.rating','customers.name')
        ->where('reviews.product_id',$product_id)
        ->get();


        $all_data = [
            "product_data"  =>$product_data,
            "store_data"    =>$shopping_store_data,
            "images"        =>$images,
            "review"        =>$review,
        ];

        return $all_data;

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        // still not done
        $request->validate([
            'product_id'        => 'required',
            'name'              => 'required',
            'description'       => 'required',
            'price'             => 'required',
            'discount'          => 'required',
            'image1'            => 'required|image',
            'image2'            => 'nullable|image',
            'image3'            => 'nullable|image',
            'image4'            => 'nullable|image',
            'image5'            => 'nullable|image'
        ]);

        Product::where('product_id',$request->product_id)
        ->update(['name' => $request->name,'description'=> $request->description
                ,'price'=>$request->price,'discount'=>$request->discount
                ,'shopping_store_id'=>$request->shopping_store_id,
                ]);

        return response('product update is done !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {

        $images = Image::where('product_id',$product_id)->get();
        
        foreach($images as $img){
            if ($img->image) {
                $exist = Storage::disk('public')->exists("product/image/{$img->image}");
                if ($exist) {
                    Storage::disk('public')->delete("product/image/{$img->image}");
                }
            }
        };
        Image::where('product_id',$product_id)->delete();
        Product::where('product_id',$product_id)->delete();
        return response('deleting product was done !');


    }
}
