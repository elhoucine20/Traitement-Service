<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Traitement extends Model
{
    //
        protected $fillable = [
        'name',
        'description',
        'disease',
        'dosage'
        ];
}
