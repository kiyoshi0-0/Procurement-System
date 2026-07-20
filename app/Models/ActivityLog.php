<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    // Idagdag ang mga columns na papayagang ma-insert sa database
    protected $fillable = [
        'po_number',
        'activity',
        'details',
        'user_name'
    ];
}