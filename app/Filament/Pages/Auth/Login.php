<?php

namespace App\Filament\Pages\Auth;

/**
 * for custom login page
 */

use Filament\Forms\Components\TextInput;
use Filament\Support\Components\Component;

class Login extends \Filament\Pages\Auth\Login
{
    /**
     * method overriding
     *
     * @return array
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getPhoneNoFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getRememberFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    /**
     * method overriding
     */

    protected function getPhoneNoFormComponent(): Component
    {
        return TextInput::make('phone')
            ->label('phone')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    /**
     * method overriding
     */

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'phone' => $data['phone'],
            'password' => $data['password'],
        ];
    }
}
