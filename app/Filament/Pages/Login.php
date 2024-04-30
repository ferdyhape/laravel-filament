<?php

namespace App\Filament\Pages;

use Illuminate\Contracts\Support\Htmlable;
use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    protected static string $layout = 'filament.layout';
    public function getHeading(): string
    {
        return __('Login Page');
    }

    public function getTitle(): string
    {
        return __('Login');
    }

    // public function hasLogo(): bool
    // {
    //     return false;
    // }
}
