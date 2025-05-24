<?php

namespace App\Http\Controllers;

use App\Facades\VoteStorage;
use App\Http\Resources\CandidateResource;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(Candidate::validationRules());

        $photo = $request->file('photo') ? VoteStorage::put(CANDIDATE_PHOTO_PATH, $request->file('photo')) : null;

        $candidate = Candidate::create([
            'vote_id' => $request->vote_id,
            'name' => $request->name,
            'description' => $request->description,
            'profession' => $request->profession,
            'university' => $request->university,
            'photo' => $photo,
        ]);

        return self::successJson(new CandidateResource($candidate), 'Candidate created successfully');
    }

    public function update(Request $request, Candidate $candidate)
    {
        $request->validate(Candidate::validationRules());

        if ($request->file('photo')) {
            $candidate->deletePhoto();
            $photoPath = VoteStorage::put(CANDIDATE_PHOTO_PATH, $request->file('photo'));
        } else {
            $photoPath = $candidate->photo;
        }

        $candidate->update([
            'name' => $request->name,
            'description' => $request->description,
            'profession' => $request->profession,
            'university' => $request->university,
            'photo' => $photoPath,
        ]);

        return self::successJson(new CandidateResource($candidate), 'Candidate updated successfully');
    }

    public function show(Candidate $candidate)
    {
        return self::successJson(new CandidateResource($candidate));
    }

    public function edit(Candidate $candidate)
    {
        $candidate->photo = $candidate->photoUrl();

        return new JsonResource($candidate);
    }

    public function destroy(Candidate $candidate)
    {
        $candidate->deletePhoto();
        $candidate->delete();

        return self::successJson(new CandidateResource($candidate), 'Candidate deleted successfully');
    }
}
