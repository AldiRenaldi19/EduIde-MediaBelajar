<?php

namespace App\Services;

class CloudinaryClient
{
    protected $client;

    public function __construct(\Cloudinary\Cloudinary $client)
    {
        $this->client = $client;
    }

    /**
     * Upload a file to Cloudinary using uploadApi()->upload
     * $options passed directly to the SDK
     */
    public function upload(string $pathOrFile, array $options = [])
    {
        return $this->client->uploadApi()->upload($pathOrFile, $options);
    }
}
