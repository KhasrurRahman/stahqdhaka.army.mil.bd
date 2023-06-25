<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\VehicleSticker;
use App\Application;
use App\VehicleType;
class VehicleInfo extends Model
{
    
    public function application()
    {
        return $this->belongsTo(Application::class);
    }
    public function vehicleStickers()
    {
        return $this->hasMany(VehicleSticker::class);
    }
      public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

}
