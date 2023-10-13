<?php

namespace App\Enums\Support\Views;

enum ToastType: string
{
    case SUCCESS = 'success';
    case ERROR = 'error';
    case INFO = 'info';
    case WARNING = 'warning';
    case QUESTION = 'question';
}
