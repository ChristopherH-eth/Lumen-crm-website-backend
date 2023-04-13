<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    /**
     * Attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'salutation',
        'first_name',
        'last_name',
        'company',
        'title',
        'website',
        'description',
        'lead_status',
        'user_id',
        'phone',
        'email',
        'email_opt_out',
        'street',
        'city',
        'state_province',
        'zipcode',
        'country',
        'number_of_employees',
        'annual_revenue',
        'lead_source',
        'industry'
    ];

    /**
     * Attributes excluded from the model's JSON form
     * 
     * @var array
     */
    protected $hidden = [];
}