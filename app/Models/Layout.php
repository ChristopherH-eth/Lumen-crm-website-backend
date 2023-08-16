<?php

/**
 * This file contains the Layout model used in creating Layout objects.
 * 
 * @author 0xChristopher
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    use HasFactory;

    /**
     * Attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'name',
        'layout_data'
    ];

    /**
     * Serialize incoming array as JSON
     * 
     * @var array
     */
    protected $casts = [
        'layout_data' => 'array'
    ];

    /**
     * Attributes excluded from the model's JSON form
     * 
     * @var array
     */
    protected $hidden = [];
}