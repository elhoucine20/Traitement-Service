<?php

namespace App\Services;

use App\Models\Traitement;
use Illuminate\Support\Facades\DB;

class TraitementService
{
    public function delete(int $id): void
    {
        DB::transaction(function () use ($id) {
            $traitement = Traitement::findOrFail($id);
            $traitement->medicaments()->detach();
            $traitement->delete();
        });
    }

    public function deleteByDossierId(string $dossierId): void
    {
        DB::transaction(function () use ($dossierId) {
            $traitements = Traitement::where('dossier_id', $dossierId)->get();
            foreach ($traitements as $traitement) {
                $traitement->medicaments()->detach();
                $traitement->delete();
            }
        });
    }
}
