<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicament extends Model
{
    //
    protected $fillable = ['name',];


        public function medicaments()
        {
            return $this->belongsToMany(Medicament::class, 'medicament_traitement');
        }
}
