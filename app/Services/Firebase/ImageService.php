<?php

namespace App\Services\Firebase;

class ImageService
{
    public static function getUrlImageFirebase($file, $folder)
    {
        $expiresAt = new \DateTime('tomorrow');
        $imageReference = app('firebase.storage')->getBucket()->object($folder . $file);
        if ($imageReference->exists()) {
            return $imageReference->signedUrl($expiresAt);
        }
        return null;
    }
    public static function uploadImageClientToFirebase($image, $name, $folder)
    {
        $image_extension = $image->getClientOriginalExtension();
        $file_image = $name . '.' . $image_extension;
        $localfolder = public_path('firebase-temp-uploads') . '/';
        if ($image->move($localfolder, $file_image)) {
            $uploadedfile = fopen($localfolder . $file_image, 'r');
            app('firebase.storage')->getBucket()->upload($uploadedfile, ['name' => $folder . $file_image]);
            unlink($localfolder . $file_image);
            return $file_image;
        }
        return null;
    }
    public static function deleteImageFirebase($file, $folder)
    {
        $imageReference = app('firebase.storage')->getBucket()->object($folder . $file);
        return $imageReference->exists() && $imageReference->delete();
    }
}
