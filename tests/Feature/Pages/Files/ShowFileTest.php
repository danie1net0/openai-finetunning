<?php

use App\DTOs\Files\FileData;
use App\Exceptions\Services\OpenAi\FileNotFoundException;
use App\Services\OpenAi\{FilesResource, OpenAiConnector};
use Livewire\Volt\Volt;

use function Pest\Laravel\{get, partialMock};

it('should handle no file', function (): void {
    $mockedResource = partialMock(FilesResource::class);
    $mockedResource->shouldReceive('retrieve')->andThrow(FileNotFoundException::class);

    $mockedConnector = partialMock(OpenAiConnector::class);
    $mockedConnector->shouldReceive('files')->andReturn($mockedResource);

    get(route('files.show', ['id' => 'file-id']))->assertNotFound();
});

it('should show file', function (): void {
    $file = new FileData(
        'file-id-1',
        'file',
        1564,
        now()->subDay()->getTimestamp(),
        'file-name-1',
        'fine-tune',
        'uploaded'
    );

    $mockedResource = partialMock(FilesResource::class);
    $mockedResource->shouldReceive('retrieve')->andReturn($file);

    $mockedConnector = partialMock(OpenAiConnector::class);
    $mockedConnector->shouldReceive('files')->andReturn($mockedResource);

    get(route('files.show', ['id' => $file->id]))
        ->assertOk()
        ->assertSee([
            $file->object,
            now()->subDay()->format('Y-m-d H:i'),
            $file->fileName,
            $file->purpose,
            $file->status,
            "{$file->id}.jsonl",
            "1.53KB",
        ]);
});

it('should download file', function (): void {
    $file = new FileData(
        'file-id-1',
        'file',
        1564,
        now()->subDay()->getTimestamp(),
        'file-name-1',
        'fine-tune',
        'uploaded'
    );

    $mockedResource = partialMock(FilesResource::class);
    $mockedResource->shouldReceive('retrieve')->andReturn($file);
    $mockedResource->shouldReceive('download')->andReturn('file-content');

    $mockedConnector = partialMock(OpenAiConnector::class);
    $mockedConnector->shouldReceive('files')->andReturn($mockedResource);

    Volt::test('files.[id]', ['id' => $file->id])
        ->call('download')
        ->assertFileDownloaded($file->id . '.jsonl');
});
