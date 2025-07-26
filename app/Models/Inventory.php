<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    // Inventory Model
    use HasFactory;

    protected $fillable = [
        'item_name', 'quantity', 'type', 'location', 'buy_method', 'category', 'buy_date'
    ];
}
