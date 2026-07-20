<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'requestor', 'dept', 'priority', 'justification', 'item_name', 
        'supplier', 'total_estimated', 'estimated_delivery', 'category', 
        'brand', 'qty', 'manager_comment', 'price', 'status' // Ensure status is here
    ];
}