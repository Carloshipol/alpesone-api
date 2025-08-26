<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'external_id',
        'type',
        'brand',
        'model',
        'version',
        'year_model',
        'year_build',
        'optionals',
        'doors',
        'board',
        'chassi',
        'transmission',
        'km',
        'description',
        'created_api',
        'updated_api',
        'sold',
        'category',
        'url_car',
        'old_price',
        'price',
        'color',
        'fuel',
        'fotos',
    ];

    protected $casts = [
        'sold' => 'boolean',
        'optionals' => 'array',
        'fotos' => 'array',
    ];

}