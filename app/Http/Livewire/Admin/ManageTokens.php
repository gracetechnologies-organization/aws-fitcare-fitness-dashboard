<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class ManageTokens extends Component
{
    use WithPagination;
    public
        $category_id,
        $token_id,
        $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'category_id' => 'required|int'
    ];

    protected $messages = [
        /*
        |--------------------------------------------------------------------------
        | category_id error messages
        |--------------------------------------------------------------------------
        */
        'category_id.required' => 'Please select an app from the list'
    ];

    public function updated($property_name)
    {
        $this->validateOnly($property_name);
    }

    public function resetModal()
    {
        $this->resetAllErrors();
        $this->category_id = '';
        $this->token_id = '';
    }

    public function resetAllErrors()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function renderResetTokenModal($id)
    {
        $data = Category::find($id);
        if ($data) {
            $this->category_id = $data->id;
        } else {
            return redirect()->to(route('admin.tokens'))->with('error', 'Record Not Found.');
        }
    }

    public function renderDeleteModal($id)
    {
        $this->category_id = $id;
    }

    public function generate()
    {
        $this->validate();
        try {
            /* Perform some operation */
            $generated = Category::where('id', $this->category_id)
                ->whereNull('token')
                ->update([
                    'token' => Str::orderedUuid()
                ]);
            /* Operation finished */
            $this->resetModal();
            sleep(1);
            $this->dispatchBrowserEvent('close-modal', ['id' => 'addModal']);
            if ($generated) {
                session()->flash('success', config('messages.TOKEN_GENERATED_SUCCESS'));
            } else {
                session()->flash('error', config('messages.TOKEN_GENERATED_FAILED'));
            }
        } catch (Exception $error) {
            report($error);
            session()->flash('error', config('messages.INVALID_DATA'));
        }
    }

    public function resetToken()
    {
        try {
            /* Perform some operation */
            $reset = Category::where('id', $this->category_id)
                ->update([
                    'token' => Str::orderedUuid(),
                    'updated_at' => DB::raw('updated_at')
                ]);
            /* Operation finished */
            $this->resetModal();
            sleep(1);
            $this->dispatchBrowserEvent('close-modal', ['id' => 'resetTokenModal']);
            if ($reset) {
                session()->flash('success', config('messages.TOKEN_RESET_SUCCESS'));
            } else {
                session()->flash('error', config('messages.TOKEN_RESET_FAILED'));
            }
        } catch (Exception $error) {
            report($error);
            session()->flash('error', config('messages.INVALID_DATA'));
        }
    }

    public function destroy()
    {
        try {
            /* Perform some operation */
            $deleted = Category::where('id', $this->category_id)
            ->update([
                'token' => NULL
            ]);
            /* Operation finished */
            sleep(1);
            $this->dispatchBrowserEvent('close-modal', ['id' => 'deleteTokenModal']);
            if ($deleted) {
                session()->flash('success', config('messages.TOKEN_DESTROYED_SUCCESS'));
            } else {
                session()->flash('error', config('messages.TOKEN_DESTROYED_FAILED'));
            }
        } catch (Exception $error) {
            report($error);
            session()->flash('error', config('messages.INVALID_DATA'));
        }
    }
    /**
     * The sole purpose of this function is to resolve the double-click problem
     * Which occurs while using wire:model.lazy directive
     * Now this function will be called only when a button is clicked 
     * And after that it will remove the focus from the forms input fields & calls
     * The given form action manually
     * @author Muhammad Abdullah Mirza
     */
    public function submitForm($form_name)
    {
        $this->$form_name();
    }

    public function copyToClipboard($value, $id)
    {
        $this->dispatchBrowserEvent('copy-to-clipboard', ['token' => $value, 'id' => $id]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = Category::getTokens($this->search);
        $categories = Category::all();
        return view('livewire.admin.manage-tokens', ['data' => $data, 'categories' => $categories]);
    }
}
