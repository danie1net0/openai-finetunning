<?php

use App\DTOs\Files\FileData;
use App\Services\OpenAi\FilesResource;
use App\Services\OpenAi\OpenAiConnector;
use Illuminate\Support\Collection;
use function Pest\Laravel\get;
use function Pest\Laravel\partialMock;

it('should handle no files', function () {
    ($this->mockFiles)(collect());

    get(route('files.index'))
        ->assertOk()
        ->assertSee('No files found.');
});

it('should list files', function () {
    $files = collect([
        new FileData(
            'file-id-1',
            'file',
            1564,
            now()->subDay()->getTimestamp(),
            'file-name-1',
            'fine-tune',
            'uploaded'
        ),
        new FileData(
            'file-id-2',
            'file',
            3162,
            now()->subDays(2)->getTimestamp(),
            'file-name-2',
            'fine-tune',
            'uploaded'
        ),
    ]);

    ($this->mockFiles)($files);

    get(route('files.index'))
        ->assertOk()
        ->assertSee([
            'file-id-1',
            'file',
            '1.53KB',
            now()->subDay()->format('Y-m-d H:i'),
            'file-name-1',
            'fine-tune',
            'uploaded'
        ])
        ->assertSee([
            'file-id-1',
            'file',
            '3.09KB',
            now()->subDays(2)->format('Y-m-d H:i'),
            'file-name-1',
            'fine-tune',
            'uploaded'
        ]);
});

beforeEach(function () {
    $this->mockFiles = function (Collection $files) {
        $mockedResource = partialMock(FilesResource::class);
        $mockedResource->shouldReceive('list')->andReturn($files);

        $mockedConnector = partialMock(OpenAiConnector::class);
        $mockedConnector->shouldReceive('files')->andReturn($mockedResource);
    };
});
