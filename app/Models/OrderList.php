<?php

namespace App\Models;

use App\Models\OrderList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderList extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','product_id','qty','total','order_code'];
}
