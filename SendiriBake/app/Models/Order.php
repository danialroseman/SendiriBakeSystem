<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'placeorder';
    protected $primaryKey = 'Id'; 
    protected $fillable = ['orderdetails', 'totalprice', 'pickup', 'status','phoneNum', 'custName', 'receipt', 'payment_method' ]; // Include 'receipt' here
    public $timestamps=false;
}
