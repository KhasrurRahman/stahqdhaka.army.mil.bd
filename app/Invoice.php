<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Application;
use App\VehicleType;
use App\StickerCategory;
use App\VehicleSticker;
use App\TemporaryPass;
class Invoice extends Model
{
    public function application()
    {
        return $this->belongsTo(Application::class);
    } 

    public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }

    public function stickerCategory()
    {
        return $this->belongsTo(StickerCategory::class);
    } 

    public function vehicleSticker()
    {
        return $this->belongsTo(VehicleSticker::class);
    } 
    
    public function temporaryPass()
    {
        return $this->belongsTo(TemporaryPass::class);
    }

}
