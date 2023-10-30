<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Profile extends Component
{
    public
        $old_password,
        $new_password,
        $data;

    protected $rules = [
        'data.name' => 'required|string|regex:/^[A-Za-z\s]+$/',
        'data.email' => 'required|email'
    ];

    public function mount()
    {
        $this->data = auth()->user();
    }

    public function resetProperties()
    {
        $this->resetAllErrors();
        $this->old_password = '';
        $this->new_password = '';
    }

    public function resetAllErrors()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function edit()
    {
        $this->validate();
        try {
            /* Perform some operation */
            $updated = $this->data->save();
            /* Operation finished */
            sleep(1);
            if ($updated) {
                session()->flash('success', config('messages.UPDATION_SUCCESS'));
            } else {
                session()->flash('error', config('messages.UPDATION_FAILED'));
            }
        } catch (Exception $error) {
            report($error);
            session()->flash('error', config('messages.INVALID_DATA'));
        }
    }

    public function resetPassword()
    {
        $this->validate([
            'old_password' => 'required|min:8',
            'new_password' => 'required|min:8'
        ]);
        try {
            /* Perform some operation */
            if (Hash::check($this->old_password, $this->data->password)) {
                $updated = User::where('id', '=', $this->data->id)->update(['password' => Hash::make($this->new_password)]);
            } else {
                $updated = 'PASSWORD_DONT_MATCH';
            }
            /* Operation finished */
            sleep(1);
            $this->resetProperties();
            if ($updated === 1) {
                session()->flash('success', config('messages.UPDATION_SUCCESS'));
            } elseif ($updated === 'PASSWORD_DONT_MATCH') {
                session()->flash('error', config('messages.PASSWORD_DONT_MATCH'));
            } else {
                session()->flash('error', config('messages.UPDATION_FAILED'));
            }
        } catch (Exception $error) {
            report($error);
            session()->flash('error', config('messages.INVALID_DATA'));
        }
    }

    public function render()
    {
        return view('livewire.admin.profile');
    }
}
