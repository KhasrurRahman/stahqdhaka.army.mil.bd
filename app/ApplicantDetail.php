<?php

namespace App;
use App\Applicant;
use App\Rank;
use App\SpouseParentsUnit;
use Illuminate\Database\Eloquent\Model;

class ApplicantDetail extends Model
{
    public function applicant(){
    	return $this->belongsTo(Applicant::class);
    }   
    public function rank(){
    	return $this->belongsTo(Rank::class);
    }  
    public function spouseOrParentRank(){ 
    	return $this->belongsTo('App\Rank' ,'spouseOrParent_Rank_id');
    }  
    public function spouseParentUnit(){
    	return $this->belongsTo('App\SpouseParentsUnit' ,'spouse_parents_units_id');
    }
}
