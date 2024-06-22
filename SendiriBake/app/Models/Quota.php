<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quota extends Model
{
    use HasFactory;
    protected $primaryKey = 'date';
    protected $fillable = ['date', 'quota'];
    protected $table = 'quota';
    public $timestamps=false;
    protected $casts = [
        'date' => 'date', // Assuming 'date' is of type DATE in your database
    ];
    
}
