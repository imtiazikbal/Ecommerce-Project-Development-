<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory;
    protected $fillable = [' email','otp',];
    public function profile(){
        return $this->hasOne(CustomerProfile::class);
    }
}
