<?php

namespace App\Models;

use App\Models\Base\BaseModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendor extends BaseModel
{
    use HasFactory;

    /** Relation */
    public function env()
    {
        return $this->hasMany(VendorEndpoint::class,'vendor_id')->active();
    }

    public function order_type()
    {
        return $this->hasMany(OrderCourierType::class,'vendor_id')->active();
    }

    public function vehicle_type()
    {
        return $this->hasMany(VehicleCourierType::class,'vendor_id')->active();
    }

    public function payment_type()
    {
        return $this->hasMany(PaymentCourierType::class,'vendor_id')->active();
    }
}
