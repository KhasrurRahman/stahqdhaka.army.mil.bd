<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeaderFooter extends Model
{
    protected $guarded = [];
    protected $dates = ['created_at','updated_at'];
}
