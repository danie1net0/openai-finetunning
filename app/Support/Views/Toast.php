<?php

namespace App\Support\Views;

use App\Enums\Support\Views\ToastType;
use Livewire\Component;

class Toast
{
    public function __construct(protected Component $component)
    {
    }

    public function notify(array $options): self
    {
        $this->component->dispatch('toast-notify', [
            'component_id' => $this->component->id(),
            'options' => $options,
        ]);

        return $this;
    }

    public function success(string $title, ?string $description = null): self
    {
        return $this->simpleNotification(ToastType::SUCCESS, $title, $description);
    }

    public function error(string $title, ?string $description = null): self
    {
        return $this->simpleNotification(ToastType::ERROR, $title, $description);
    }

    public function info(string $title, ?string $description = null): self
    {
        return $this->simpleNotification(ToastType::INFO, $title, $description);
    }

    public function warning(string $title, ?string $description = null): self
    {
        return $this->simpleNotification(ToastType::WARNING, $title, $description);
    }

    public function confirm(array $options): self
    {
        $options['type'] ??= ToastType::QUESTION->value;

        $this->notify($options);

        return $this;
    }

    public function simpleNotification(ToastType $type, string $title, ?string $description = null): self
    {
        $options = [
            'type' => $type->value,
            'title' => $title,
            'description' => $description,
        ];

        $this->notify($options);

        return $this;
    }
}
