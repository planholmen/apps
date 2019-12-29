<?php

namespace App\Http\Controllers;

use Exception;
use Google_Client;
use Google_Service_Drive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GoogleController extends Controller
{

    public function getClient()
    {

        $client = new Google_Client();
        $client->setApplicationName('Google Drive API Test');
        $client->setScopes(Google_Service_Drive::DRIVE_METADATA_READONLY);
        $client->setAuthConfig(Storage::path('google/credentials.json'));
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        if ($this->getAccessToken() != false) {
            $client->setAccessToken($this->getAccessToken());
        } else {
            // No token file exists and a new one will have to be created
            $this->updateAccessTokenWithAuthCode($client);
        }

        if ($client->isAccessTokenExpired()) {
            if ( ! $this->updateAccessTokenWithRefreshToken($client) == true ) {
                $this->updateAccessTokenWithAuthCode($client);
            }
        }

        return $client;

    }

    private function getAccessToken()
    {
        if (Storage::disk('local')->exists('google/token.json')) {
            return json_decode(Storage::get('google/token.json'), true);
        } else {
            return false;
        }
    }

    private function updateAccessTokenWithRefreshToken(Google_Client $client)
    {
        // Access token is expired
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            return true;
        } else {
            return false;
        }
    }

    private function updateAccessTokenWithAuthCode(Google_Client &$client)
    {

        $scopes = [
            'https://www.googleapis.com/auth/drive.file'
        ];

        $authCode = $this->getAuthCode($client, $scopes);

        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        // Check to see if there was an error.
        if (array_key_exists('error', $accessToken)) {
            throw new Exception(join(', ', $accessToken));
        }

        if ($client->getAccessToken() != null)
            Storage::put('google/token.json', json_encode($client->getAccessToken()));

    }

    private function getAuthCode(Google_Client &$client, array $scopes)
    {

        if (Storage::disk('local')->exists('google/auth_code.txt')) {

            return Storage::get('google/auth_code.txt');

        } else {

            $authUrl = $client->createAuthUrl($scopes);
            header("Location: " . $authUrl);
            exit();

        }

    }

    public function saveAuthCode(Request $request)
    {
        if ($request->code)
            Storage::put('google/auth_code.txt', $request->code);
    }

}
