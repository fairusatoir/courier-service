<?php

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
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
