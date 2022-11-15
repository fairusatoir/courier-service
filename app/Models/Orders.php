<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'user_id',
        'status',
        'client_order_id',
        'request_order',
    ];
}
