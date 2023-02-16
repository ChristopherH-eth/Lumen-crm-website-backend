<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cryptocurrency extends Model
{
    /**
     * Attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'id', 'circulating_supply', 'cmc_rank', 'date_added', 'last_updated', 'max_supply', 'name',
        'num_market_pairs', 'platform', 'quote', 'self_reported_circulating_supply', 
        'self_reported_market_cap', 'slug', 'symbol', 'tags', 'total_supply', 'tvl_ratio', 'logo'
    ];

    /**
     * Attributes excluded from the model's JSON form
     * 
     * @var array
     */
    protected $hidden = [];
}