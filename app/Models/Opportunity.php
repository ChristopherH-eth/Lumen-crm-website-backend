<?php

/**
 * This file contains the Opportunities model used in creating Opportunity objects.
 * 
 * @author 0xChristopher
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opportunity extends Model
{
    use HasFactory;

    /**
     * Attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'opportunity_name',
        'account_id',
        'type',
        'follow_up',
        'close_date',
        'stage',
        'probability',
        'amount',
        'lead_source',
        'next_step',
        'description',
        'user_id'
    ];

    /**
     * Attributes excluded from the model's JSON form
     * 
     * @var array
     */
    protected $hidden = [];

    /**
     * Relationship to a user object
     * 
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship to an account object
     * 
     * @return Account
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}