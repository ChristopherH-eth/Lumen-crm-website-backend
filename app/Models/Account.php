<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    /**
     * Attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'account_name', 
        'website', 
        'type', 
        'description', 
        'parent_account', 
        'account_owner', 
        'phone',
        'billing_street', 
        'billing_city',
        'billing_state_province',
        'billing_zipcode',
        'billing_country',
        'shipping_street', 
        'shipping_city',
        'shipping_state_province',
        'shipping_zipcode',
        'shipping_country'
    ];

    /**
     * Attributes excluded from the model's JSON form
     * 
     * @var array
     */
    protected $hidden = [];
}