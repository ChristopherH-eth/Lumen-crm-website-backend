<?php

/**
 * This file contains the Opportunities Action Bar model used in creating Opportunity Action Bar objects.
 * 
 * @author 0xChristopher
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpportunitiesActionBar extends Model
{
    use HasFactory;

    /**
     * Attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'name',
        'action_bar_data'
    ];

    /**
     * Serialize incoming array as JSON
     * 
     * @var array
     */
    protected $casts = [
        'action_bar_data' => 'array'
    ];

    /**
     * Attributes excluded from the model's JSON form
     * 
     * @var array
     */
    protected $hidden = [];
}