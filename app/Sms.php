<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    public function getSmsTextAttribute($value)
    {


        if(request()->app_number!=''){
            $veh=VehicleInfo::where('app_number',request()->app_number)->first();

            return str_replace('{reg}',  $veh->reg_number, $value);
        }else{



            return $value;
        }

    }
}
