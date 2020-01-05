<?php

namespace App\Http\Controllers;

use Google_Service_Drive;
use Google_Service_Drive_DriveFile;
use Illuminate\Http\Request;

class GoogleDriveController extends Controller
{
    private static $client;

    private static function setClient() {
        if ( ! GoogleDriveController::$client)
            GoogleDriveController::$client = (new GoogleController())->getClient();
    }

    /**
     * @param string $fileId
     * @return empty body if succesful
     */
    public static function deleteFile(string $fileId)
    {
        self::setClient();

        $service = new Google_Service_Drive(GoogleDriveController::$client);
        return $service->files->delete($fileId);
    }

    /**
     * @param string $fileId
     * @param Google_Service_Drive_DriveFile $options
     * @return Google_Service_Drive_DriveFile
     */
    public static function copyFile(string $fileId, Google_Service_Drive_DriveFile $options)
    {
        self::setClient();

        $service = new Google_Service_Drive(GoogleDriveController::$client);
        return $service->files->copy($fileId, $options);
    }

    /**
     * @param Google_Service_Drive_DriveFile $metadata
     * @param array $options
     * @return Google_Service_Drive_DriveFile
     */
    public static function createFile(Google_Service_Drive_DriveFile $metadata, array $options = [])
    {
        self::setClient();

        $service = new Google_Service_Drive(GoogleDriveController::$client);
        return $service->files->create($metadata, $options);
    }

}
