<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quota extends Model
{
    use HasFactory;
    protected $fillable = ['date', 'quota'];
    protected $table = 'quota';
    public $timestamps=false;
}
