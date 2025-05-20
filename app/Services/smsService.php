<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class smsService
{
    protected $endpoint;
    protected $username;
    protected $password;
    protected $smsId;

    public function __construct()
    {
        $this->endpoint = env('COMMUNITY_ADS_API_URL');
        $this->username = env('COMMUNITY_ADS_USERNAME');
        $this->password = env('COMMUNITY_ADS_PASSWORD');
    }

    public function sendSms($phone_number, $message)
    {
        try {
            $data = [
                'UserName' => $this->username,
                'Password' => $this->password,
                'SMSText' => $message,
                'SMSLang' => 'e',
                'SMSSender' => 'Doctoria',
                'SMSReceiver' => $phone_number,
                "SMSID" => (string) Str::uuid(),
            ];
            // throw new BalaghatException($data,$this->endpoint);
            $response = Http::asForm()->post($this->endpoint, $data);
            // Log::debug('Response from API:', [$response->body()]);
            if ($response->successful()) {
                return ['success' => true, 'data' => $response->body()];
            } else {
                Log::error('Failed to send SMS: ' . $response->body());
                return ['success' => false, 'message' => 'Failed to send SMS', 'error' => $response->body()];
            }
        } catch (\Exception $e) {
            Log::error('Exception while sending SMS: ' . $e->getMessage());
            return ['success' => false, 'message' => "An error occurred while sending SMS: " . $e->getMessage()];
        }
    }
}
