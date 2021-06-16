<?php

namespace App\Http\Livewire\Auth;

use App\Events\NewSentSecretCodeViaTelegramEvent;
use App\Models\User;
use App\Traits\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginActionForm extends Component
{
    use AuthenticatesUsers;

    public $user;

    public $username;

    public $password;

    public $show_username_input;

    public $show_password_input;

    public $resend_hold_time;

    public function mount(): void
    {
        $this->show_username_input = true;
        $this->show_password_input = false;
        $this->resend_hold_time = null;
    }

    public function submit()
    {
        if ($this->show_username_input) {
            $this->validate(
                ['username' => 'required|string|exists:users,username'],
                ['username.exists' => 'These credential do not match our records.']
            );

            $this->user = User::where([
                'username' => $this->username
            ])->firstOrFail();

            $this->show_username_input = false;
            $this->show_password_input = true;
            $this->resend_hold_time = 1;

            event(new NewSentSecretCodeViaTelegramEvent($this->user));

            return;
        }

        $validatedData = $this->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $validatedData['remember'] = true;
        $request = Request();
        $request->replace($validatedData);

        if ($this->user->codeValid($request->password)) {
            Auth::login($this->user, $request->remember);

            $this->sendLoginResponse($request);
        }

        $this->sendFailedLoginResponse($request);
    }

    public function resend()
    {
        $this->resend_hold_time = 1;

        event(new NewSentSecretCodeViaTelegramEvent($this->user));
    }

    public function render()
    {
        return view('livewire.auth.login-action-form');
    }
}
