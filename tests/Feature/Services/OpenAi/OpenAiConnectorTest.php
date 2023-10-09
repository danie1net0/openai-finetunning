<?php

use App\Services\OpenAi\{FilesResource, JobsResource, OpenAiConnector};

uses()->group('feature', 'services', 'openai');

test('instance files resource', function (): void {
    $filesResource = (new OpenAiConnector())->files();

    expect($filesResource)->toBeInstanceOf(FilesResource::class);
});

test('instance jobs resource', function (): void {
    $filesResource = (new OpenAiConnector())->jobs();

    expect($filesResource)->toBeInstanceOf(JobsResource::class);
});
