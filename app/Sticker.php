<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\VehicleSticker;
use App\StickerCategory;
class Sticker extends Model
{
   
    public function vehicleStickers()
    {
        return $this->hasmany(VehicleSticker::class);
    }


    public function stickerCategory()
    {
        return $this->belongsTo(StickerCategory::class);
    }

}
