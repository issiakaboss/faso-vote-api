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
            'vote_uuid' => 'required|exists:votes,uuid',
            'country_code' => 'required',
            'country_iso_code' => 'nullable',
        ]);

        $vontant = $this->save($request);

        if ($vontant->is_voted) {
            return self::errorJson('Vous avez déjà voté avec ce numéro de téléphone.', 403);
        }

        if (! $vontant->verification_key) {
            $response = OtpService::make()->send($request->phone);
            $vontant->update(['verification_key' => $response->json('otpToken')]);
        }

        return self::successJson(new VotantResource($vontant), 'Votant stored successfully');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|integer',
            'vote_id' => 'required|exists:votes,id',
            'identity' => 'required|string|max:25',
        ]);

        $vontant = Votant::findByIdentity($request->vote_id, $request->identity)->firstOrFail();

        if ($vontant->is_verified) {
            return self::errorJson('Ce numéro a ete déjà vérifié.', 403);
        }

        $response = OtpService::make([
            'otp' => $request->otp,
            'identity' => $vontant->identity,
            'verificationKey' => $vontant->verification_key,
        ])->verify();

        if ($response->failed()) {
            return self::errorJson('Le code OTP est invalide ou a expiré.', 403);
        }

        $vontant->verify();

        return self::successJson(new VotantResource($vontant));
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
        $identity = $request->phone ?? $request->email;
        $vontant = Votant::findByIdentity($vote->id, $identity)->first();

        if (! $vontant) {
            $vontant = Votant::create([
                'vote_id' => $vote->id,
                'identity' => $identity,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'country' => $request->header('X-Country'),
                'country_code' => $request->country_code ?? null,
                'country_iso_code' => $request->country_iso_code ?? null,
            ]);
        }

        return $vontant;
    }
}
