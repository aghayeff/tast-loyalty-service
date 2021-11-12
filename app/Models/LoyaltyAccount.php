<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class LoyaltyAccount extends Model
{
    protected $table = 'loyalty_account';

    protected $fillable = [
        'phone',
        'card',
        'email',
        'email_notification',
        'phone_notification',
        'active',
    ];

    public static array $types = [
        'phone', 'card', 'email'
    ];
}
