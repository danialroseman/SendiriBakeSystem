<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'Id'; 
    protected $fillable = ['Pname', 'price', 'Pdesc', 'Pimage'];
    public $timestamps = false;
}
