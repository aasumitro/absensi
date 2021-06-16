<?php

namespace App\Http\Livewire\Auth;

use App\Events\SentSecretCodeEvent;
use App\Models\User;
use App\Traits\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class LoginActionForm extends Component
{
    use AuthenticatesUsers;

    public $user;

    public $username, $password;

    public function render()
    {
        return view('livewire.auth.login-action-form');
    }

    public function resend()
    {
        $this->dispatchBrowserEvent('recountingTime', ['next_time' => 3]);

        event(new SentSecretCodeEvent($this->user));
    }

    /**
     * @throws ValidationException
     */
    public function submit(): void
    {
        if ($this->user) {
            $this->attemptLogin();
            return;
        }

       $this->validateLogin();
    }

    /**
     * @throws ValidationException
     */
    private function validateLogin()
    {
        $this->validate(
            ['username' => 'required|string|exists:users,username'],
            ['username.exists' => 'These credential do not match our records.']
        );

        $this->user = User::where([
            'username' => $this->username
        ])->firstOrFail();

        if (!$this->user->telegram_id && !$this->user->email) {
            throw ValidationException::withMessages([
                'username' => "Can't sent secret code, Email or Telegram ID not found!",
            ]);
        }

        event(new SentSecretCodeEvent($this->user));

        $this->dispatchBrowserEvent('recountingTime', ['next_time' => 1]);
    }

    /**
     * @throws ValidationException
     */
    private function attemptLogin()
    {
        $validatedData = $this->validate(['username' => 'required', 'password' => 'required']);
        $validatedData['remember'] = true;

        $request = Request();
        $request->request->add($validatedData);

        if ($this->user->isCodeValid($request->password)) {
            Auth::login($this->user, $request->remember);

            $this->user->destroySecretCode();

            return  $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }
}
