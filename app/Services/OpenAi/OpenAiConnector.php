<?php

namespace App\Services\OpenAi;

class OpenAiConnector
{
    public function files(): FilesResource
    {
        return new FilesResource();
    }

    public function jobs(): JobsResource
    {
        return new JobsResource();
    }
}
