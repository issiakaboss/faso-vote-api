<?php

namespace App\Http\Controllers;

use App\Http\Resources\VotantResource;
use App\Models\Votant;
use App\Models\Vote;
use App\Services\OtpService;
use Illuminate\Http\Request;

class VotantController extends Controller
{
    public function storeByPhone(Request $request)
    {

        $request->validate([
            'phone' => 'required|string|max:25',
            'vote_uuid' => 'required|exists:votes,id',
            'contry_code' => 'required',
            'contry_iso_code' => 'nullable',
        ]);

        $vontant = $this->save($request);

        if ($vontant->is_voted) {
            return self::errorJson('Vous avez déjà voté avec ce numéro de téléphone.', 403);
        }
        // $response = OtpService::make()->send($request->phone);

        return self::successJson(new VotantResource($vontant), 'Votant stored successfully');
    }

    public function storeByEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'vote_uuid' => 'required|exists:votes,uuid',
        ]);

        $vontant = $this->save($request);

        if ($vontant->is_voted) {
            return self::errorJson('Vous avez déjà voté avec cet email.', 403);
        }

        return self::successJson(new VotantResource($vontant), 'Votant stored successfully');
    }

    private function save(Request $request): Votant
    {
        /* @var Vote $vote */
        $vote = Vote::byUuid($request->vote_uuid)->first();
        $vontant = Votant::findByIdentity($vote->id, $request->email)->first();

        if (! $vontant) {
            $vontant = Votant::create([
                'vote_id' => $vote->id,
                'identity' => $request->email ?? $request->phone,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'country' => $request->header('X-Country', $request->contry_iso_code),
            ]);
        }

        return $vontant;
    }
}
