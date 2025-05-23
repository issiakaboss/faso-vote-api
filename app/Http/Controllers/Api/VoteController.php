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
    public const BASE_PATH = parent::BASE_PATH.'/votes';

    public const VOTE = 'Vote';

    public function getVotes()
    {
        return VoteResource::collection(Vote::all());
    }

    /**
     * Display the specified resource.
     */
    public function show(VoteGroup $voteGroup)
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate(Vote::validationRules());

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
        ]);
    }

    public function update(Request $request, Vote $vote)
    {

        $request->validate(Vote::validationRules());

        $logoPath = $request->file('logo') ? VoteStorage::put(VOTE_LOGO_PATH, $request->file('logo')) : null;

        $vote->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'start_date' => Carbon::parse($request->input('start_date')),
            'end_date' => Carbon::parse($request->input('end_date')),
            'logo' => $logoPath,
        ]);

        $vote->deleteLogo();

        return response()->json([
            'message' => 'Vote updated successfully',
            'data' => new VoteResource($vote),
        ]);
    }

    public function destroy(Vote $vote)
    {
        $vote->deleteLogo();

        $vote->delete();

        return response()->json([
            'message' => 'Vote deleted successfully',
            'data' => new VoteResource($vote),
        ]);
    }
}
