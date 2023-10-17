<?php

namespace App\Livewire\Forms;

use App\Rules\JsonLinesRule;
use Livewire\Attributes\Rule;
use Livewire\Form;

class FileForm extends Form
{
    #[Rule(['required', new JsonLinesRule()])]
    public $file;
}
