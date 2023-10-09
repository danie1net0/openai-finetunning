<?php

use App\DTOs\Files\FileData;
use App\Services\OpenAi\OpenAiConnector;
use Illuminate\Support\Collection;
use OpenAI\Laravel\Facades\OpenAI;
use OpenAI\Responses\Files\{CreateResponse, DeleteResponse, ListResponse, RetrieveResponse};

uses()->group('feature', 'services', 'openai');

test('list files', function () {
    OpenAI::fake([
        ListResponse::fake([
            'data' => [
                [
                    'id' => 'file-1',
                    'object' => 'file',
                    'bytes' => 1564,
                    'created_at' => 1695691885,
                    'filename' => 'data.jsonl',
                    'purpose' => 'fine-tune',
                    'status' => 'processed',
                ],
            ],
        ]),
    ]);

    $files = (new OpenAiConnector())->files()->list();

    expect($files)
        ->toBeInstanceOf(Collection::class)
        ->and($files->first())
        ->toBeInstanceOf(FileData::class)
        ->id->toBe('file-1')
        ->object->toBe('file')
        ->bytes->toBe(1564)
        ->createdAt->toBe(1695691885)
        ->fileName->toBe('data.jsonl')
        ->purpose->toBe('fine-tune')
        ->status->toBe('processed');
});

test('delete file', function () {
    OpenAI::fake([
        DeleteResponse::fake([
            'id' => 'file-1',
            'object' => 'file',
            'deleted' => true,
        ]),
    ]);

    $deleted = (new OpenAiConnector())->files()->delete('file-1');

    expect($deleted)->toBeTrue();
});

test('retrieve file', function () {
    OpenAI::fake([
        RetrieveResponse::fake([
            'id' => 'file-1',
            'object' => 'file',
            'bytes' => 1564,
            'created_at' => 1695691885,
            'filename' => 'data.jsonl',
            'purpose' => 'fine-tune',
            'status' => 'succeeded',
        ]),
    ]);

    $file = (new OpenAiConnector())->files()->retrieve('file-1');

    expect($file)
        ->toBeInstanceOf(FileData::class)
        ->id->toBe('file-1')
        ->object->toBe('file')
        ->bytes->toBe(1564)
        ->createdAt->toBe(1695691885)
        ->fileName->toBe('data.jsonl')
        ->purpose->toBe('fine-tune')
        ->status->toBe('succeeded');
});

test('create file', function () {
    OpenAI::fake([
        CreateResponse::fake([
            'id' => 'file-1',
            'object' => 'file',
            'bytes' => 1564,
            'created_at' => 1695691885,
            'filename' => 'data.jsonl',
            'purpose' => 'fine-tune',
            'status' => 'succeeded',
        ]),
    ]);

    $file = (new OpenAiConnector())->files()->create('file-1');

    expect($file)
        ->toBeInstanceOf(FileData::class)
        ->id->toBe('file-1')
        ->object->toBe('file')
        ->bytes->toBe(1564)
        ->createdAt->toBe(1695691885)
        ->fileName->toBe('data.jsonl')
        ->purpose->toBe('fine-tune')
        ->status->toBe('succeeded');
});

test('download file', function () {
    OpenAI::fake(['file-1']);

    $file = (new OpenAiConnector())->files()->download('file-1');

    expect($file)->toBe('file-1');
});
