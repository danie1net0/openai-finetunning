<?php

namespace App\Enums\Services\OpenAi;

enum TrainingModel: string
{
    case GPT = 'gpt-3.5-turbo-0613';
    case BABBAGE = 'babbage-002';
    case DAVINCI = 'davinci-002';
}
