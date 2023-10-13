<?php

namespace App\Support\Views;

trait Actions
{
    public function toast(): Toast
    {
        return new Toast($this);
    }
}
