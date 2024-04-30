<?php

namespace App\Filament\Pages;

use App\Models\User;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Pages\Auth\Login;

class Settings extends Page implements HasForms
{
    use InteractsWithForms;
    public ?array $data = [];
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static string $view = 'filament.pages.settings';

    public function mount()
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()->default(auth()->user()->name),
                TextInput::make('email')->required()->default(auth()->user()->email)->email(),
                TextInput::make('password')->required()->password(),
            ])->statePath('data');
    }

    public function getFormActions()
    {
        return [
            Action::make('Save')
                ->submit('save')
        ];
    }

    public function save()
    {
        try {
            $data = $this->form->getState();
            $user = User::find(auth()->user()->id);
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();
        } catch (\Exception $e) {
            $this->addError('name', 'Something went wrong');
        }

        Notification::make()->title('Settings saved successfully')->send();
    }
}
