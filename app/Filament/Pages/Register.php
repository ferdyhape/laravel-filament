<?php

namespace App\Filament\Pages;

// use Filament\Pages\Page;
use Filament\Facades\Filament;

use Filament\Forms\Components\Select;
use Illuminate\Auth\Events\Registered;
use Filament\Forms\Components\Component;
use Filament\Notifications\Notification;

use Illuminate\Contracts\Support\Htmlable;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;

class Register extends BaseRegister
{
    public function register(): ?RegistrationResponse
    {
        $data = $this->form->getState();
        dd($data);
    }

    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getNameFormComponent(),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                        // $this->getRoleFormComponent(),
                        $this->getStaticRole()
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getStaticRole(): Component
    {
        return Select::make('role')
            ->options([
                'shareholder' => 'Shareholder',
                'owner' => 'Owner'
            ])
            ->default('buyer')
            ->required();
    }
}
