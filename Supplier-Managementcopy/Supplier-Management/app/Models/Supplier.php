<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = 
    ['name',
     'address', 
     'category', 
     'contact_person', 
     'phone', 'email', 
     'payment_terms', 
     'delivery_schedule', 
     'rating'];

    // In app/Models/Supplier.php

// Note: Ensure the function name matches the attribute name you call in the view (without the 'get' and 'Attribute')
    public function getCategoryIconColorAttribute()
    {
        return match($this->category) {
            'Components'   => 'bg-green-100 text-green-800',
            'Graphics'     => 'bg-blue-100 text-blue-800',
            'Power Supply' => 'bg-yellow-100 text-yellow-800',
            'Storage'      => 'bg-amber-100 text-amber-800',
            'Cooling'      => 'bg-cyan-100 text-cyan-800',
            default        => 'bg-slate-100 text-slate-800',
        };
    }

    public function getCategoryColorAttribute()
    {
        return match($this->category) {
            'Components'   => 'bg-green-100 text-green-800',
            'Graphics'     => 'bg-blue-100 text-blue-800',
            'Power Supply' => 'bg-yellow-100 text-yellow-800',
            'Storage'      => 'bg-amber-100 text-amber-800',
            'Cooling'      => 'bg-cyan-100 text-cyan-800',
            default        => 'bg-slate-100 text-slate-800',
        };
    }

    public function getCategoryIconAttribute()
    {
        return match($this->category) {
            'Components'   => 'fa-microchip',
            'Graphics'     => 'fa-display',
            'Power Supply' => 'fa-bolt',
            'Storage'      => 'fa-hard-drive',
            'Cooling'      => 'fa-snowflake',
            default        => 'fa-box',
        };
    }

    // In app/Models/Supplier.php
    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}