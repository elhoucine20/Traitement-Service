<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTraitmentRequest;
use App\Http\Resources\TraitementResource;
use App\Models\Traitement;
use App\Services\TraitementService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Traitements",
 *     description="API Endpoints for Traitements"
 * )
 */
class TraitementController extends Controller
{
    public function __construct(private TraitementService $service) {}

    /**
     * @OA\Get(
     *     path="/api/traitments",
     *     summary="Get all traitements",
     *     tags={"Traitements"},
     *     @OA\Response(
     *         response=200,
     *         description="List of traitements",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Traitement"))
     *     )
     * )
     */
    public function index() {
        $traitments = Traitement::all();
        return TraitementResource::collection($traitments);
    }

    /**
     * @OA\Post(
     *     path="/api/traitments",
     *     summary="Create a traitement",
     *     tags={"Traitements"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"description"},
     *             @OA\Property(property="description", type="string", example="Traitement pour maladie rare")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Traitement created",
     *         @OA\JsonContent(ref="#/components/schemas/Traitement")
     *     )
     * )
     */
    public function store(StoreTraitmentRequest $request) {
        $traitment = Traitement::create([
            "description" => $request->description,
        ]);
        return response()->json($traitment, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/traitments/{id}",
     *     summary="Get traitement by ID",
     *     tags={"Traitements"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Traitement found", @OA\JsonContent(ref="#/components/schemas/Traitement")),
     *     @OA\Response(response=404, description="Traitement not found")
     * )
     */
    public function show($id) {
        return Traitement::findOrFail($id);
    }
 

    /**
     * @OA\Put(
     *     path="/api/traitments/{id}",
     *     summary="Update a traitement",
     *     tags={"Traitements"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"description"},
     *             @OA\Property(property="description", type="string", example="Traitement mis à jour")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Traitement updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Traitement")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Traitement not found"
     *     )
     * )
     */
    public function update(StoreTraitmentRequest $request, $id)
    {
        $traitment = Traitement::findOrFail($id);
        $traitment->update(['description'=>$request->description]);
    
        return new TraitementResource($traitment);
    }


    /**
     * @OA\Delete(
     *     path="/api/traitments/{id}",
     *     summary="Delete traitement",
     *     tags={"Traitements"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Deleted successfully")
     * )
     */
    public function destroy($id) {
        $this->service->delete($id);
        return response()->json(['message' => 'Deleted successfully']);
    }

    /**
     * @OA\Get(
     *     path="/api/traitment/search",
     *     summary="Search traitement by description",
     *     tags={"Traitements"},
     *     @OA\Parameter(name="description", in="query", required=false, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Search results")
     * )
     */
    public function search(Request $request) {
        $query = Traitement::query();
        if($request->has('description')) {
            $query->where('description','LIKE','%'.$request->description.'%');
        }
        $result = $query->paginate(2);
        return response()->json($result,200);
    }
}