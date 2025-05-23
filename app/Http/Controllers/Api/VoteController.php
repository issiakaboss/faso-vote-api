<?php

namespace App\Http\Controllers\Api;

use App\Facades\VoteStorage;
use App\Http\Controllers\Controller;
use App\Http\Resources\VoteResource;
use App\Models\Vote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VoteController extends Controller
{
    public const BASE_PATH = parent::BASE_PATH.'/votes';

    public const VOTE = 'Vote';

    public function getVotes()
    {
        return VoteResource::collection(Vote::forUser()->get());
    }

    public function show(Vote $vote): JsonResource
    {
        return VoteResource::collection($vote->with('candidates')->get());
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

        return self::successJson(new VoteResource($vote->refresh()), 'Vote created successfully');
    }

    public function update(Request $request, Vote $vote)
    {

        $request->validate(Vote::validationRules());

        return $vote;

        if ($request->file('logo')) {
            $vote->deleteLogo();
            $logoPath = VoteStorage::put(VOTE_LOGO_PATH, $request->file('logo'));
        } else {
            $logoPath = $vote->logo;
        }

        $vote->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'start_date' => Carbon::parse($request->input('start_date')),
            'end_date' => Carbon::parse($request->input('end_date')),
            'logo' => $logoPath,
        ]);

        return self::successJson(new VoteResource($vote), 'Vote updated successfully');
    }

    public function destroy(Vote $vote)
    {
        $vote->deleteLogo();

        $vote->delete();

        return self::successJson(new VoteResource($vote), 'Vote deleted successfully');
    }
}
