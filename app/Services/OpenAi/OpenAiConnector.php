<?php

namespace App\Services\OpenAi;

use OpenAI\Laravel\Facades\OpenAI;

class OpenAiConnector
{
    public function files(): FilesResource
    {
        return new FilesResource();
    }
}
