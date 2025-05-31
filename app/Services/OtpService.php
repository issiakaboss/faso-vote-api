<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OtpService
{
    private array $data;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public static function make(array $data = []): self
    {
        return new self($data);
    }

    public function send(string $identity): \Illuminate\Http\Client\Response
    {

        // $url = "https://api.ikoddi.com/api/v1/groups/{$organizationId}/otp/{$otpAppId}/{$type}/{$identity}";

        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        //     'x-api-key' => config('services.ikoddi.api_key'),
        // ])->post($url);

        // if ($response->successful()) {
        //     return response()->json([
        //         'message' => 'OTP envoyé avec succès.',
        //         'data' => $response->json()
        //     ]);
        // } else {
        //     return response()->json([
        //         'message' => 'Échec de l’envoi de l’OTP.',
        //         'error' => $response->body()
        //     ], $response->status());
        // }

        $url = $this->getUrl(str('sms/')->append(urlencode($identity)));

        return Http::withHeaders($this->getHeaders())->post($url);
    }

    // Methode de verification d'OTP

    // public function OtpVerify(Request $request)
    // {
    //     $request->validate([
    //         'otp' => 'required|string',
    //         'identity' => 'required|string',
    //         'verificationKey' => 'required|string',
    //     ]);

    //     $organizationId = "10478339";
    //     $otpAppId = "cmbc1fs6j0ee3fx2vj1fyravr";

    //     $url = "https://api.ikoddi.com/api/v1/groups/{$organizationId}/otp/{$otpAppId}/verify";

    //     $payload = [
    //         'otp' => $request->otp,
    //         'identity' => $request->identity,
    //         'verificationKey' => $request->verificationKey,
    //     ];

    //     $response = Http::withHeaders([
    //         'Content-Type' => 'application/json',
    //         'x-api-key' => config('services.ikoddi.api_key'),
    //     ])->post($url, $payload);

    //     if ($response->successful()) {
    //         return response()->json([
    //             'message' => 'Vérification OTP réussie.',
    //             'data' => $response->json(),
    //         ]);
    //     } else {
    //         return response()->json([
    //             'error' => 'Échec de la vérification OTP.',
    //             'details' => $response->body(),
    //         ], $response->status());
    //     }
    // }

    private function getUrl(string $route): string
    {

        return str(config('services.ikoddi.api_url'))
            ->append('otp/')
            ->append(config('services.ikoddi.otp_app_id'))
            ->append('/')
            ->append($route)
            ->toString();
    }

    private function getHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'x-api-key' => config('services.ikoddi.api_key'),
        ];
    }
}
