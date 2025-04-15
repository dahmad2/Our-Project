<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'postcode',
        'postcode_ns',
        'lsoa11',
        'msoa11',
        'ward_code_ons',
        'ward_name_ons',
        'constituency_code_ons',
        'constituency_name_ons',
        'ccg',
        'ward_code_current',
        'ward_name_current',
        'constituency_code_current',
        'constituency_name_current',
        'latitude',
        'longitude',
        'date_of_termination',
    ];
}
