<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Traitement extends Model
{
    //
        protected $fillable = ['description',];

        public function traitements()
        {
            return $this->belongsToMany(Traitement::class, 'medicament_traitement');
        }
}
