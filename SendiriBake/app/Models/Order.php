<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Specify the table name
    protected $table = 'placeorder';

    // Specify the primary key
    protected $primaryKey = 'Id'; // Ensure this matches your primary key column name

    // Specify the fillable fields
    protected $fillable = ['orderdetails', 'totalprice', 'pickup', 'status'];

    public $timestamps=false;
}
