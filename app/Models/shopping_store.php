<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shopping_store extends Model
{
    use HasFactory;

    protected $table = 'shopping_stores';
        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'shopping_store_id',
        'user_id',
        'name',
        'phone',
        'phone2',
        'address',
        'address2',
        'description',
        'logo',

    ];
}


