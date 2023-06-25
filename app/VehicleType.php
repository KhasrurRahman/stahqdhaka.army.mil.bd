<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\VehicleInfo;
use App\Invoice;
use App\Application;
class VehicleType extends Model
{
   
      public function vehicleinfo()
    {
        return $this->hasOne(VehicleInfo::class);
    }  
     public function invoices()
    {
        return $this->hasMany(Invoice::class);
    } 
     public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
