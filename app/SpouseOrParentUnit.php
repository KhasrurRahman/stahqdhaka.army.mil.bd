<?php

namespace App;
use App\ApplicantDetail;
use Illuminate\Database\Eloquent\Model;

class SpouseOrParentUnit extends Model
{
      public function applicantDetail(){
    	return $this->hasmany( ApplicantDetail::class);
    } 
}
