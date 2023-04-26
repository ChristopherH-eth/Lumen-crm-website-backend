<?php

/**
 * This file contains the Contacts model used in creating Contact objects.
 * 
 * @author 0xChristopher
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * Attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'first_name', 
        'last_name',
        'salutation',
        'account_id',
        'title',
        'reports_to',
        'description',
        'user_id',
        'phone',
        'email',
        'email_opt_out',
        'street',
        'city',
        'state_province',
        'zipcode',
        'country'
    ];

    /**
     * Attributes excluded from the model's JSON form
     * 
     * @var array
     */
    protected $hidden = [];
}