<?php

use App\Rules\JsonLinesRule;
use Illuminate\Http\Testing\File;

test('pass with a valid JSONL', function (): void {
    $lines = collect();

    for ($i = 0; $i < 10; $i++) {
        $lines[] = '{ "name":"John", "age":30, "city": "New York" }';
    }

    $lines->push('');

    $validFile = File::create('test.jsonl', $lines->implode("\n"));

    (new JsonLinesRule())->validate('content', $validFile, fn (string $message) => $this->fail($message));

    expect(true)->toBeTrue();
});

test('fail with a invalid JSON format', function (): void {
    $lines = collect(['{ name: "Jane", age: 25, city: "Chicago" }']);

    for ($i = 0; $i < 10; $i++) {
        $lines[] = '{ "name":"John", "age":30, "city": "New York" }';
    }

    $invalidFile = File::create('test.jsonl', $lines->implode("\n"));

    try {
        (new JsonLinesRule())->validate('content', $invalidFile, fn (string $message) => $this->fail($message));
    } catch (Throwable $exception) {
        expect($exception->getMessage())->toBe('The file contains a invalid JSONL');
    }
});

test('fail with a file with less than 10 lines', function (): void {
    $lines = collect();

    for ($i = 0; $i < 9; $i++) {
        $lines[] = '{ "name":"John", "age":30, "city": "New York" }';
    }

    $invalidFile = File::create('test.jsonl', $lines->implode("\n"));

    try {
        (new JsonLinesRule())->validate('content', $invalidFile, fn (string $message) => $this->fail($message));
    } catch (Throwable $exception) {
        expect($exception->getMessage())->toBe('The file must have at least 10 lines');
    }
});

test('fail with a file that has more than 1 empty line', function (): void {
    $lines = collect();

    for ($i = 0; $i < 9; $i++) {
        $lines[] = '{ "name":"John", "age":30, "city": "New York" }';
    }

    $lines->push('', '');

    $invalidFile = File::create('test.jsonl', $lines->implode("\n"));

    try {
        (new JsonLinesRule())->validate('content', $invalidFile, fn (string $message) => $this->fail($message));
    } catch (Throwable $exception) {
        expect($exception->getMessage())->toBe('The file contains more than one empty line');
    }
});
