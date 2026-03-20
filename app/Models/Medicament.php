<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicament extends Model
{
    //
    protected $fillable = ['name',];

    public function traitements()
    {
        return $this->belongsToMany(Traitement::class, 'medicament_traitement');
    }
}
