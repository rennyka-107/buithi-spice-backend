<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeForgotPassword extends Model
{
    use HasFactory;
    protected $table = 'codes_forgot_password';
    protected $fillable = ['user_id', 'code', 'expired', 'email'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
