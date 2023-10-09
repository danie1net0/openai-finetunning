<?php

namespace App\DTOs\Jobs;

class CreateJobData
{
    public function __construct(
        public string $file,
        public string $model,
        public int $epochs,
    ) {
    }
}
