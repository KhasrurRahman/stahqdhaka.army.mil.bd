<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $guarded = [];
    public function files()
    {
        return $this->hasMany(NoticeFile::class);
    }
}
