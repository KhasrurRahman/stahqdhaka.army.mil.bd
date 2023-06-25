<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Application;
use App\VehicleInfo;
use App\Sticker;
use App\Invoice;
use App\Applicant;
class VehicleSticker extends Model
{

    public function vehicleinfo()
    {
        return $this->belongsTo(VehicleInfo::class);
    }
    public function application()
    {
        return $this->belongsTo(Application::class);
    }  
      public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    } 
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
