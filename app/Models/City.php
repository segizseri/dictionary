<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'country_id',
    ];

    public function getCountry()
    {
        return $this->belongsTo(Country::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Lang::class, 'city_lang');
    }
}
