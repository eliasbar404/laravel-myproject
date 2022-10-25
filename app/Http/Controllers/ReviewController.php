<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
        $review_id = uniqid('review');
        $request->validate([
            'product_id'   => 'required',
            'customer_id'  => 'required',
            'description'  => 'required',
            'rating'       => 'required',
        ]);

        $review = new Review();
        $review->review_id     = $review_id;
        $review->product_id    = $request->product_id;
        $review->customer_id   = $request->customer_id;
        $review->description   = $request->description;
        $review->rating        = $request->rating;
        $review->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $request->validate([
            'product_id'  => 'required'
        ]);

        $review = DB::table('reviews')->join('customers' ,'reviews.customer_id','=','customer.customer_id')
                ->select('')->get();

        return $review;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        //
    }
}
