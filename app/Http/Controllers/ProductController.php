<?php
namespace App\Models;
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Image;
use App\Models\Review;
use App\Models\Shopping_store;
use App\Models\Shopping_cart;
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
    public function index(Request $request)
    {

        if($request->has('discount')){
            $products = DB::table('categories')
            ->join('products','categories.category_id','=','products.category_id')
            ->join('images','products.product_id','=','images.product_id')
            ->select('products.product_id','products.name','products.price','products.discount','images.image')
            ->where('products.discount','>=',$request->discount)
            ->where('images.type','=','main_product_image')
            ->get();
            
            return $products;
        }
        else if($request->has('store_id')){
            $pro = DB::table('products')
            ->join('images','products.product_id','=','images.product_id')
            ->select('products.product_id','products.name','products.price','products.discount','images.image')
            ->where('products.shopping_store_id',$request->store_id)
            ->where('images.type','main_product_image')
            ->get();
            // $products = [];
            // foreach($products as $p){
            //     $rating = DB::table('products')
            //     ->join('reviews','products.product_id','=','reviews.product_id')
            //     ->where('products.product_id',$p->product_id)
            //     ->avg('rating');

    
            //     $arr = array("rating"=>floatval($rating),"name"=>$p->name,"product_id"=>$p->product_id,
            //                 "price"=>$p->price,"discount"=>$p->discount,"image"=>$p->image);
                
            //     array_push($product,$arr);
                
            // }




            return $pro;
        }
        else if($request->has('category_id') && $request->has('name')){

            $products = DB::table('categories')
            ->join('products','categories.category_id','=','products.category_id')
            ->join('images','products.product_id','=','images.product_id')
            ->select('products.product_id','products.name','products.price','products.discount','images.image')
            ->where('categories.category_id',$request->category_id )
            ->where('products.name','=',$request->name)
            ->where('images.type','=','main_product_image')
            ->get();
            
            $product = [];
            foreach($products as $p){
                $rating = DB::table('products')
                ->join('reviews','products.product_id','=','reviews.product_id')
                ->where('products.product_id',$p->product_id)
                ->avg('rating');
    
                $shopping_store = DB::table('products')
                ->join('shopping_stores','products.shopping_store_id','=','shopping_stores.shopping_store_id')
                // ->select('shopping_stores.name')
                ->where('products.product_id',$p->product_id)
                ->get('shopping_stores.name');
    
                $arr = array("rating"=>floatval($rating),"name"=>$p->name,"product_id"=>$p->product_id,
                            "price"=>$p->price,"discount"=>$p->discount,"image"=>$p->image,
                            "shopping_store"=>$shopping_store[0]->name);
                
                array_push($product,$arr);
                
            }
    
            return $product;
            
            }
        else if($request->has('category_id')){
            $products = DB::table('categories')
            ->join('products','categories.category_id','=','products.category_id')
            ->join('images','products.product_id','=','images.product_id')
            ->select('products.product_id','products.name','products.price','products.discount','images.image')
            ->where('categories.category_id',$request->category_id )
            ->where('images.type','=','main_product_image')
            ->get();
            // return $products;
            $product = [];
            foreach($products as $p){
                $rating = DB::table('products')
                ->join('reviews','products.product_id','=','reviews.product_id')
                ->where('products.product_id',$p->product_id)
                ->avg('rating');
    
                $shopping_store = DB::table('products')
                ->join('shopping_stores','products.shopping_store_id','=','shopping_stores.shopping_store_id')
                // ->select('shopping_stores.name')
                ->where('products.product_id',$p->product_id)
                ->get('shopping_stores.name');
    
                $arr = array("rating"=>floatval($rating),"name"=>$p->name,"product_id"=>$p->product_id,
                            "price"=>$p->price,"discount"=>$p->discount,"image"=>$p->image,
                            "shopping_store"=>$shopping_store[0]->name);
                
                array_push($product,$arr);
                
            }
    
            return $product;










            }
        if($request->has('name')){

                $products = DB::table('categories')
                ->join('products','categories.category_id','=','products.category_id')
                ->join('images','products.product_id','=','images.product_id')
                ->select('products.product_id','products.name','products.price','products.discount','images.image')
                ->where('products.name','like',"%$request->name%")
                ->where('images.type','=','main_product_image')
                ->get();
                
                $product = [];
                foreach($products as $p){
                    $rating = DB::table('products')
                    ->join('reviews','products.product_id','=','reviews.product_id')
                    ->where('products.product_id',$p->product_id)
                    ->avg('rating');
        
                    $shopping_store = DB::table('products')
                    ->join('shopping_stores','products.shopping_store_id','=','shopping_stores.shopping_store_id')
                    // ->select('shopping_stores.name')
                    ->where('products.product_id',$p->product_id)
                    ->get('shopping_stores.name');
        
                    $arr = array("rating"=>floatval($rating),"name"=>$p->name,"product_id"=>$p->product_id,
                                "price"=>$p->price,"discount"=>$p->discount,"image"=>$p->image,
                                "shopping_store"=>$shopping_store[0]->name);
                    
                    array_push($product,$arr);
                    
                }
        
                return $product;
                
                }
        
        $pro = DB::table('products')
        ->join('images','products.product_id','=','images.product_id')
        ->select('products.product_id','products.name','products.price','products.discount','images.image')
        ->where('images.type','main_product_image')
        ->get();


        $product = [];
        foreach($pro as $p){
            $rating = DB::table('products')
            ->join('reviews','products.product_id','=','reviews.product_id')
            ->where('products.product_id',$p->product_id)
            ->avg('rating');

            $shopping_store = DB::table('products')
            ->join('shopping_stores','products.shopping_store_id','=','shopping_stores.shopping_store_id')
            // ->select('shopping_stores.name')
            ->where('products.product_id',$p->product_id)
            ->get('shopping_stores.name');

            $arr = array("rating"=>floatval($rating),"name"=>$p->name,"product_id"=>$p->product_id,
                        "price"=>$p->price,"discount"=>$p->discount,"image"=>$p->image,
                        "shopping_store"=>$shopping_store[0]->name);
            
            array_push($product,$arr);
            
        }

        return $product;
        
    
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

            $filename = Str::random(32).".".$request->file('image1')->getClientOriginalExtension();
            $request->file('image1')->move('uploads/', $filename);


            $product_img->image  = $filename;
            $product_img->save();

            if($request->has('image2')){
                $product_img  = new Image();
                $image_id     = uniqid('image_');
                $product_img->image_id    = $image_id;
                $product_img->product_id  = $product_id;
                $product_img->type        = 'product_image2';
        
                $filename = Str::random(32).".".$request->file('image2')->getClientOriginalExtension();
                $request->file('image2')->move('uploads/', $filename);
    
                $product_img->image  = $filename;
                $product_img->save();

            };

            if($request->has('image3')){
                $product_img  = new Image();
                $image_id     = uniqid('image_');
                $product_img->image_id    = $image_id;
                $product_img->product_id  = $product_id;
                $product_img->type        = 'product_image3';
        
                $filename = Str::random(32).".".$request->file('image3')->getClientOriginalExtension();
                $request->file('image3')->move('uploads/', $filename);
    
                $product_img->image  = $filename;
                $product_img->save();

            };

            if($request->has('image4')){
                $product_img  = new Image();
                $image_id     = uniqid('image_');
                $product_img->image_id    = $image_id;
                $product_img->product_id  = $product_id;
                $product_img->type        = 'product_image4';
        
                $filename = Str::random(32).".".$request->file('image4')->getClientOriginalExtension();
                $request->file('image4')->move('uploads/', $filename);
    
                $product_img->image  = $filename;
                $product_img->save();

            };

            if($request->has('image5')){
                $product_img  = new Image();
                $image_id     = uniqid('image_');
                $product_img->image_id    = $image_id;
                $product_img->product_id  = $product_id;
                $product_img->type        = 'product_image5';
        
                $filename = Str::random(32).".".$request->file('image5')->getClientOriginalExtension();
                $request->file('image5')->move('uploads/', $filename);
    
                $product_img->image  = $filename;
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
        $rating = DB::table('products')
        ->join('reviews','products.product_id','=','reviews.product_id')
        ->where('products.product_id',$product_id)
        ->avg('rating');
        
        // i still dont finish this
        $review = DB::table('reviews')
        ->join('customers','reviews.customer_id','=','customers.customer_id')
        ->select('reviews.review_id','reviews.description','reviews.rating','customers.name','reviews.created_at')
        ->where('reviews.product_id',$product_id)
        ->get();


        $all_data = [
            "product_data"  =>$product_data,
            "rating"        =>floatval($rating),
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

        // $images = Image::where('product_id',$product_id)->get();
        
        // foreach($images as $img){
        //     if ($img->image) {
        //         $exist = Storage::disk('public')->exists("product/image/{$img->image}");
        //         if ($exist) {
        //             Storage::disk('public')->delete("product/image/{$img->image}");
        //         }
        //     }
        // };
        Shopping_cart::where('product_id',$product_id)->delete();
        Review::where('product_id',$product_id)->delete();
        Image::where('product_id',$product_id)->delete();
        Product::where('product_id',$product_id)->delete();
        return response('deleting product was done !');


    }
}
