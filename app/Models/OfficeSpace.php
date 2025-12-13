<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OfficeSpace extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'thumbnail',
        'is_open',
        'is_full_booked',
        'price',
        'duration',
        'address',
        'about',
        'slug',
        'city_id',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function benefits()
    {
        return $this->hasMany(OfficeSpaceBenefit::class);
    }

    public function photos()
    {
        return $this->hasMany(OfficeSpacePhoto::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
