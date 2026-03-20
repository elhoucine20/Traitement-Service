<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Traitement extends Model
{
    //
        protected $fillable = ['description', 'dossier_id'];

        public function medicaments()
        {
            return $this->belongsToMany(Medicament::class, 'medicament_traitement');
        }
}
