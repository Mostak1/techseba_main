<?php

namespace App\Helper;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FacebookCapiHelper
{
    public static function sendEvent($eventName, $userData = [], $customData = [], $eventId = null)
    {
        $setting = cache()->get('setting');

        if (!$setting || empty($setting->pixel_access_token) || empty($setting->pixel_app_id) || $setting->pixel_status == 0) {
            return;
        }

        $pixelId = $setting->pixel_app_id;
        $accessToken = $setting->pixel_access_token;
        $testEventCode = $setting->pixel_test_code;

        // Default User Data
        $data = [
            'event_name' => $eventName,
            'event_time' => time(),
            'action_source' => 'website',
            'event_source_url' => request()->fullUrl(),
            'user_data' => array_merge([
                'client_ip_address' => request()->ip(),
                'client_user_agent' => request()->userAgent(),
                'fbp' => request()->cookie('_fbp'),
                'fbc' => request()->cookie('_fbc'),
            ], $userData),
        ];

        if ($customData) {
            $data['custom_data'] = $customData;
        }

        if ($eventId) {
            $data['event_id'] = $eventId;
        }

        $payload = [
            'data' => [$data],
        ];

        if (!empty($testEventCode)) {
            $payload['test_event_code'] = $testEventCode;
        }

        try {
            $url = "https://graph.facebook.com/v19.0/{$pixelId}/events?access_token={$accessToken}";
            $response = Http::post($url, $payload);

            if ($response->failed()) {
                Log::error('Facebook CAPI Error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::error('Facebook CAPI Exception: ' . $e->getMessage());
        }
    }
}
