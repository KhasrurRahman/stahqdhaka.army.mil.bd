<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Application;
class ApplicationNotify extends Model
{
     public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
