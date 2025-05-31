<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OtpService
{
    private array $payload;

    public function __construct(array $payload = [])
    {
        $this->payload = $payload;
    }

    public static function make(array $payload = []): self
    {
        return new self($payload);
    }

    public function send(string $identity): \Illuminate\Http\Client\Response
    {
        $url = $this->getUrl(str('sms/')->append(urlencode($identity)));

        return Http::withHeaders($this->getHeaders())->post($url);
    }

    public function verify(): \Illuminate\Http\Client\Response
    {
        $url = $this->getUrl('verify');

        return Http::withHeaders($this->getHeaders())->post($url, $this->payload);
    }

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
