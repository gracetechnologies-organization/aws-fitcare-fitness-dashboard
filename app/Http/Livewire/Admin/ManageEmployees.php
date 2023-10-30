<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class ManageEmployees extends Component
{
    use WithPagination;
    public
    $employee_id,
    $name,
    $email,
    $password,
    $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'name' => 'required|string|regex:/^[A-Za-z\s]+$/',
        'email' => 'required|email',
        'password' => 'required|min:8'
    ];

    public function updated($property_name)
    {
        $this->validateOnly($property_name);
    }

    public function resetModal()
    {
        $this->resetAllErrors();
        $this->employee_id = '';
        $this->name = '';
        $this->email = '';
        $this->password = '';
    }

    public function resetAllErrors()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function renderEditModal($id)
    {
        $data = User::find($id);
        if ($data) {
            $this->employee_id = $data->id;
            $this->name = $data->name;
            $this->email = $data->email;
        } else {
            return redirect()->to(route('admin.employees'))->with('error', 'Record Not Found.');
        }
    }

    public function renderDeleteModal($id)
    {
        $this->employee_id = $id;
    }

    public function add()
    {
        $this->validate();
        try {
            /* Perform some operation */
            $inserted = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => $this->password
            ]);
            /* Operation finished */
            $this->resetModal();
            sleep(1);
            $this->dispatchBrowserEvent('close-modal', ['id' => 'addModal']);
            if ($inserted) {
                session()->flash('success', config('messages.INSERTION_SUCCESS'));
            } else {
                session()->flash('error', config('messages.INSERTION_FAILED'));
            }
        } catch (Exception $error) {
            report($error);
            session()->flash('error', config('messages.INVALID_DATA'));
        }
    }

    public function edit()
    {
        $this->validate();
        try {
            /* Perform some operation */
            $updated = User::where('id', '=', $this->employee_id)
                ->update([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                ]);
            /* Operation finished */
            $this->resetModal();
            sleep(1);
            $this->dispatchBrowserEvent('close-modal', ['id' => 'editModal']);
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

    public function destroy()
    {
        try {
            /* Perform some operation */
            $deleted = User::delEmployee($this->employee_id);
            /* Operation finished */
            sleep(1);
            $this->dispatchBrowserEvent('close-modal', ['id' => 'deleteModal']);
            if ($deleted) {
                session()->flash('success', config('messages.DELETION_SUCCESS'));
            } else {
                session()->flash('error', config('messages.DELETION_FAILED'));
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

    public function changeStatus($id, $email_verified_at)
    {  
        try {
            /* Perform some operation */
            $status_cahnged = User::activeOrBlockEmployee($id, $email_verified_at);
            /* Operation finished */
            if ($status_cahnged) {
                $this->resetPage();
            } else {
                session()->flash('error', config('messages.STATUS_CHANGING_FAILED'));
            }
        } catch (Exception $error) {
            report($error);
            session()->flash('error', config('messages.INVALID_DATA'));
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = User::getEmployees($this->search);
        return view('livewire.admin.manage-employees', ['data' => $data]);
    }
}