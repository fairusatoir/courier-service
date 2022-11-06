<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorEndpoint extends Model
{
    use HasFactory;

    /** scope data */
    public function scopeActive($query)
    {
        return $query
            ->where('active', 1)
            ->where(function($query) {
                $query->whereDate("deleted_at",">",Carbon::today())
                    ->orWhereNull('deleted_at');
            });
    }
}
