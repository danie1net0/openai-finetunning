<?php

use App\Rules\JsonLinesRule;

test('pass with a valid JSONL', function (): void {
    $lines = collect();

    for ($i = 0; $i < 10; $i++) {
        $lines[] = '{ "name":"John", "age":30, "city": "New York" }';
    }

    $validJsonl = $lines->implode("\n");

    (new JsonLinesRule())->validate('content', $validJsonl, fn (string $message) => $this->fail($message));

    expect(true)->toBeTrue();
});

test('fail with a invalid JSONL', function (): void {
    $lines = collect(['{ name: "Jane", age: 25, city: "Chicago" }']);

    for ($i = 0; $i < 9; $i++) {
        $lines[] = '{ "name":"John", "age":30, "city": "New York" }';
    }

    $invalidJsonl = $lines->implode("\n");

    try {
        (new JsonLinesRule())->validate('content', $invalidJsonl, fn (string $message) => $this->fail($message));
    } catch (Throwable $exception) {
        expect($exception->getMessage())->toBe('The file contains a invalid JSONL');
    }
});

test('fail with a file with less than 10 lines', function (): void {
    $lines = collect();

    for ($i = 0; $i < 9; $i++) {
        $lines[] = '{ "name":"John", "age":30, "city": "New York" }';
    }

    $invalidJsonl = $lines->implode("\n");

    try {
        (new JsonLinesRule())->validate('content', $invalidJsonl, fn (string $message) => $this->fail($message));
    } catch (Throwable $exception) {
        expect($exception->getMessage())->toBe('The file must have at least 10 lines');
    }
});
