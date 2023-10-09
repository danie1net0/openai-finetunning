<?php

namespace App\Services\OpenAi;

use App\DTOs\Files\FileData;
use Illuminate\Support\Collection;
use OpenAI\Laravel\Facades\OpenAI;

class FilesResource
{
    public function list(): Collection
    {
        $response = OpenAI::files()->list();

        return collect($response['data'])->map(fn (array $file) => FileData::fromArray($file));
    }

    public function delete(string $file): bool
    {
        $response = OpenAI::files()->delete($file);

        return $response['deleted'];
    }

    public function retrieve(string $file): FileData
    {
        $response = OpenAI::files()->retrieve($file);

        return FileData::fromArray($response->toArray());
    }

    public function create(mixed $file): FileData
    {
        $response = OpenAI::files()->upload([
            'purpose' => 'fine-tune',
            'file' => $file,
        ]);

        return FileData::fromArray($response->toArray());
    }

    public function download(string $file): string
    {
        return OpenAI::files()->download($file);
    }
}
