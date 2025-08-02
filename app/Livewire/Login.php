<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Login')] 
class Login extends Component
{

    public string $username;

    public string $password;

    public string $remember;

    protected function rules()
    {
        return [
            'username' => [
                'required',
            ],
            'password' => [ 
                'required'
            ],
            'remember' => [
                'boolean'
            ]
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Please enter the email or username.',
            'password.required' => 'Please enter the password.',
        ];
    }

    public function login() {

        $this->validate();
        $credentials = [ 
            'email'    => $this->username,
            'password' => $this->password
        ];
        
        if( !Auth::attempt( $credentials, $this->remember ) ) {
            return session()->flash('status','Invalid email or password. Please try again.');
        }

        return $this->redirectRoute('dashboard');
    }


    public function render()
    {
        return view('livewire.login')->extends('layouts.guest');
    }
}
