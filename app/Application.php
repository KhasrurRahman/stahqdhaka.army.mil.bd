<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Applicant;
use App\DriverInfo;
use App\VehicleInfo;
use App\VehicleType;
use App\StickerCategory;
use App\VehicleSticker;
use App\Invoice;
use App\FollowUp;
use App\Document;
use App\TemporaryPass;
use App\ApplicationNotify;
class Application extends Model
{

    public function driverinfo()
    {
        return $this->hasOne(DriverInfo::class);
    }
    public function vehicleowner()
    {
        return $this->hasOne(VehicleOwner::class);
    }
    public function vehicleSticker()
    {
        return $this->hasOne(VehicleSticker::class);
    }
    public function vehicleinfo()
    {
        return $this->hasOne(VehicleInfo::class);
    }   
     public function document()
    {
        return $this->hasOne(Document::class);
    }
   
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
     public function vehicleType()
    {
        return $this->belongsTo(VehicleType::class);
    }
    public function stickerCategory(){
        return $this->belongsTo('App\StickerCategory' ,'sticker_category','value');
    }  
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
     public function followups()
    {
        return $this->hasMany(FollowUp::class);
    }
     public function temporaryPasses()
    {
        return $this->hasMany(TemporaryPass::class);
    } 
     public function applicationNotify()
    {
        return $this->hasOne(ApplicationNotify::class);
    }
    

}
