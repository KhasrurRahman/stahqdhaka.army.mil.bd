<?php

namespace App;
use App\ApplicantDetail;
use Illuminate\Database\Eloquent\Model;

class SpouseOrParentRank extends Model
{
    public function applicantDetail(){
    	return $this->hasmany( ApplicantDetail::class);
    } 
}
