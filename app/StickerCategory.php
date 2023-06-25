<?php

namespace App;
use App\Application;
use App\Sticker;
use Illuminate\Database\Eloquent\Model;

class StickerCategory extends Model
{
	public function applications()
	{
		// return $this->hasMany(Application::class);
		return $this->hasMany('App\Application', 'value', 'sticker_category');
	} 
	public function invoices()
	{
		return $this->hasMany(Sticker::class);
	}
}
