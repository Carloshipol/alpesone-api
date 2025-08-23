<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalData extends Model {
    protected $fillable = [
        'codigo',
        'nome',
        'descricao'
    ];
}