<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['message','is_read','user_id','created_by','created_at'];
    use HasFactory;
}
