<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // 1. I-import ito
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory; // 2. Ilagay ito rito

    protected $guarded = [];
}