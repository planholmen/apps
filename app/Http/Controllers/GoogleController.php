<?php

namespace App\Http\Controllers;

use Exception;
use Google_Client;
use Google_Service_Drive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GoogleController extends Controller
{

    private function createClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Drive API Test');
        $client->setScopes(Google_Service_Drive::DRIVE_METADATA_READONLY);

        // This will need to be manually uploaded to the server for now
        $client->setAuthConfig(Storage::path('google/credentials.json'));
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        return $client;
    }

    public function getClient()
    {

        $client = $this->createClient();

        if ($this->getAccessTokenFileContents() != false) {
            $client->setAccessToken($this->getAccessTokenFileContents());
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

    private function getAccessTokenFileContents()
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

    public function updateAccessTokenWithAuthCode(Google_Client &$client)
    {

        $authCode = $this->getAuthCode();

        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        // Check to see if there was an error.
        if (array_key_exists('error', $accessToken)) {
            throw new Exception(join(', ', $accessToken));
        }

        if ($client->getAccessToken() != null)
            Storage::put('google/token.json', json_encode($client->getAccessToken()));

    }

    private function getAuthCode()
    {

        if (Storage::disk('local')->exists('google/auth_code.txt')) {

            return Storage::get('google/auth_code.txt');

        }

    }

    private function getAuthUrl(Google_Client $client, $scope = [])
    {
        return $client->createAuthUrl($scope);
    }

    public function update()
    {
        $url = $this->getAuthUrl($this->createClient(), ['https://www.googleapis.com/auth/drive.file', 'https://www.googleapis.com/auth/spreadsheets']);

        return view('google.auth', compact('url'));
    }

    public function saveAuthCode(Request $request)
    {
        if ($request->auth_code)
            Storage::put('google/auth_code.txt', $request->auth_code);

        return redirect()->to('/');
    }

}
