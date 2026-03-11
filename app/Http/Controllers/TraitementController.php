<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTraitmentRequest;
use App\Models\Traitement;
use Exception;
use Illuminate\Http\Request;

class TraitementController extends Controller
{
    //
    public function index(){
        $traitments = Traitement::paginate(2);
        return  $traitments;
    }
    public function create(){}
    
    public function store(StoreTraitmentRequest $request){
        Traitement::create([
            "description"=>$request->description,
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

public function search(Request $request){
    try{
        $query = Traitement::query();

        if($request->has('description')){
            $query->where('description','LIKE','%'.$request->description.'%');
        }

        $result = $query->paginate(2);

        return response()->json($result,200);

    }catch(\Exception $e){
        return response()->json(['message' => $e->getMessage()]);
    }
}
}
