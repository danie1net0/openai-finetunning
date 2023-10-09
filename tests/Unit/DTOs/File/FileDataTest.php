<?php

use App\DTOs\Files\FileData;

uses()->group('unit', 'dtos', 'files');

test('create data', function () {
    $fileDTO = new FileData(
       'file-1',
       'file',
       1564,
       1695691885,
       'data.jsonl',
       'fine-tune',
        'processed',
    );

    expect($fileDTO)->toBeInstanceOf(FileData::class)
        ->id->toBe('file-1')
        ->object->toBe('file')
        ->bytes->toBe(1564)
        ->createdAt->toBe(1695691885)
        ->fileName->toBe('data.jsonl')
        ->purpose->toBe('fine-tune')
        ->status->toBe('processed');
});

test('create data from array', function () {
    $fileDTO = FileData::fromArray([
        'id' => 'file-1',
        'object' => 'file',
        'bytes' => 1564,
        'created_at' => 1695691885,
        'filename' => 'data.jsonl',
        'purpose' => 'fine-tune',
        'status' => 'processed',
    ]);

    expect($fileDTO)->toBeInstanceOf(FileData::class)
        ->id->toBe('file-1')
        ->object->toBe('file')
        ->bytes->toBe(1564)
        ->createdAt->toBe(1695691885)
        ->fileName->toBe('data.jsonl')
        ->purpose->toBe('fine-tune')
        ->status->toBe('processed');
});

