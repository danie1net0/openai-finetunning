<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Rule;
use Livewire\Form;

class JobForm extends Form
{
    #[Rule(['required', 'string'])]
    public string $file = '';

    #[Rule(['required', 'string'])]
    public string $model = '';

    #[Rule(['required', 'numeric', 'min:10'])]
    public int $epochs = 10;
}
