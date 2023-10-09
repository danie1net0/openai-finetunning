<?php

use App\Services\OpenAi\FilesResource;
use App\Services\OpenAi\OpenAiConnector;

uses()->group('feature', 'services', 'openai');

test('instance file resource', function () {
    $filesResource = (new OpenAiConnector())->files();

    expect($filesResource)->toBeInstanceOf(FilesResource::class);
});
