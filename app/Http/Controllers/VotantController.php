<?php

namespace App\Http\Controllers;

use App\Http\Resources\VotantResource;
use App\Models\Votant;
use App\Models\Vote;
use Illuminate\Http\Request;

class VotantController extends Controller
{
    public function storeByPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:15',
            'vote_id' => 'required|exists:votes,id',
        ]);

        $vontant = Votant::create([
            'vote_id' => $request->vote_id,
            'identity' => $request->phone,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'country' => $request->header('X-Country'), // Assuming country is passed in header
        ]);

        return self::successJson(new VotantResource($vontant), 'Votant stored successfully');
    }

    public function storeByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'vote_uuid' => 'required|string',
        ]);

        /*@var Vote $vote */
        $vote =  Vote::byUuid($request->vote_uuid)->firstOrFail();

        $vontant = Votant::findByIdentity($vote->id, $request->email)->first();

        if ($vontant && $vontant->is_voted) {
            return self::errorJson('Vous avez déjà voté avec cet email.', 400);
        }

        $vontant = Votant::create([
            'vote_id' => $vote->id,
            'identity' => $request->email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'country' => $request->header('X-Country'),
        ]);

        return self::successJson(new VotantResource($vontant), 'Votant stored successfully');
    }
}
