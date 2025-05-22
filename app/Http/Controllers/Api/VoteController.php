<?php

namespace App\Http\Controllers\Api;

use App\Facades\VoteStorage;
use App\Http\Controllers\Controller;
use App\Http\Resources\VoteResource;
use App\Models\Vote;
use App\Models\VoteGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/vote-groups",
     *     summary="Lister tous les groupes de vote",
     *     tags={"Groupes de vote"},
     *
     *     @OA\Response(
     *         response=200,
     *         description="Liste des groupes de vote",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(
     *
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="title", type="string", example="Élections 2025"),
     *                 @OA\Property(property="slug", type="string", example="elections-2025")
     *             )
     *         )
     *     )
     * )
     */
    public function getVotes()
    {
        return VoteResource::collection(Vote::all());
    }

    /**
     * @OA\Post(
     *     path="/api/vote-groups",
     *     summary="Créer un nouveau groupe de vote",
     *     tags={"Groupes de vote"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"title"},
     *
     *             @OA\Property(property="title", type="string", example="Élections Présidentielles 2025")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Groupe de vote créé",
     *
     *         @OA\JsonContent(
     *
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
            'description' => 'nullable|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logoPath = $request->file('logo') ? VoteStorage::put(VOTE_LOGO_PATH, $request->file('logo')) : null;

        $vote = Vote::create([
            'user_id' => $request->user()->id,
            'uuid' => (string) \Illuminate\Support\Str::uuid(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'start_date' => Carbon::parse($request->input('start_date')),
            'end_date' => Carbon::parse($request->input('end_date')),
            'logo' => $logoPath,
        ]);

        return response()->json([
            'message' => 'Vote created successfully',
            'data' => new VoteResource($vote),
        ])->setStatusCode(200);
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
