<?php

namespace App\Http\Controllers;

use App\Http\Resources\VotantResource;
use App\Models\Votant;
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
}
