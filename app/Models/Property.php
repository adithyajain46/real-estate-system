<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'type', 'status',
        'price', 'location', 'area_sqft',
        'bedrooms', 'bathrooms', 'image', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'like', "%$search%")
                     ->orWhere('location', 'like', "%$search%");
    }

    public function getFormattedPriceAttribute()
    {
        return '₹ ' . number_format($this->price, 2);
    }
}
