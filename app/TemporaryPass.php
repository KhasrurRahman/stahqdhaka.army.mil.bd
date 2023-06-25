<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Invoice;
class TemporaryPass extends Model
{
     public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
