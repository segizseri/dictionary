<?php

namespace App\Models;

use App\Models\Lang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function languages()
    {
        return $this->belongsToMany(Lang::class, 'country_lang');
    }
}
