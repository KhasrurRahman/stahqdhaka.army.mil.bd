<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PasswordResetSMS extends Model
{
    protected $table = 'password_reset_sms';
    protected $fillable = [
        'applicant_id', 'verification_code', 'verification_code_expire_at',
        'link_expire_at'
    ];
}
