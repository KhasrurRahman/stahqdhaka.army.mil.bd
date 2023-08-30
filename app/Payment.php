<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ApplicantResetPasswordNotification;
// use App\ApplicantDetail;
// use App\Application;
// use App\StickerCategory;
// use App\VehicleSticker;
use Illuminate\Database\Eloquent\Model;

class Payment extends Authenticatable
{
	 use Notifiable;
    protected $guard = 'payment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
        
    //     'name', 'user_name', 'email', 'phone', 'password', 'role',
    // ];

 	protected $hidden = [
 	    
        'password', 'remember_token',
    ];

	public function sendPasswordResetNotification($token)
    {
        $this->notify(new ApplicantResetPasswordNotification($token));

    }


    public function application(){
        return $this->belongsTo( Application::class);
    } 
     

}
