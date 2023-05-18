<?php

/**
 * This file contains the Opportunities Table View model used in creating Opportunity Table View objects.
 * 
 * @author 0xChristopher
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpportunitiesTableView extends Model
{
    use HasFactory;

    /**
     * Attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'name',
        'view_data'
    ];

    /**
     * Serialize incoming array as JSON
     * 
     * @var array
     */
    protected $casts = [
        'view_data' => 'array'
    ];

    /**
     * Attributes excluded from the model's JSON form
     * 
     * @var array
     */
    protected $hidden = [];
}