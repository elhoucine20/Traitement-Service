<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTraitmentRequest;
use App\Models\Traitement;
use Illuminate\Http\Request;

class TraitementController extends Controller
{
    //

    public function index(){
        $traitments = Traitement::paginate(2);
        return  $traitments;

        // pour search
        // $query = Traitement::query();
        // if($request->name){
        //     $query->where('name',$request->name);
        // }
        // return $query->get();
    }
    public function create(){}
    
    public function store(StoreTraitmentRequest $request){
        Traitement::create([
            "name"=>$request->name,
            "description"=>$request->description,
            "disease"=>$request->name,
            "dosage"=>$request->dosage,
        ]);
    }
    public function edit(){}

    public function update(Request $request ,$id){
        $traitment = Traitement::findOrFail($id);
        $traitment->update($request->all());
    }
    
    public function show($id){
        return Traitement::findOrFail($id);
    }


    public function destroy($id){
      Traitement::destroy($id);
      return response()->json(['message'=>'deleted avec succes']);
    }
}
