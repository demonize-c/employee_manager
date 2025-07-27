<?php

namespace App\Traits;

trait Notifier
{
    public function notify(bool $success = true, string $message)
    {
        $this->dispatch('notify', success: $success, message: $message);
    }
}
