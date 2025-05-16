<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VoteGroup;
use Illuminate\Http\Request;

class VoteGroupController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/vote-groups",
     *     summary="Lister tous les groupes de vote",
     *     tags={"Groupes de vote"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des groupes de vote",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Élections 2025"),
     *                 @OA\Property(property="slug", type="string", example="elections-2025")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(VoteGroup::all());
    }
    /**
     * @OA\Post(
     *     path="/api/vote-groups",
     *     summary="Créer un nouveau groupe de vote",
     *     tags={"Groupes de vote"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title"},
     *             @OA\Property(property="title", type="string", example="Élections Présidentielles 2025")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Groupe de vote créé",
     *         @OA\JsonContent(
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Élections Présidentielles 2025"),
     *             @OA\Property(property="slug", type="string", example="elections-presidentielles-2025")
     *         )
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
        ]);

        $group = VoteGroup::create([
            'title' => $request->title,
            'slug' => $request->title,
        ]);

        return response()->json($group, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(VoteGroup $voteGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VoteGroup $voteGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VoteGroup $voteGroup)
    {
        //
    }
}
