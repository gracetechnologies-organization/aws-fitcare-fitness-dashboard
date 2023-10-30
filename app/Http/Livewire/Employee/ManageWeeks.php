<?php

namespace App\Http\Livewire\Employee;

use App\Models\Week;
use Livewire\Component;
use Livewire\WithPagination;
use Exception;

class ManageWeeks extends Component
{
    use WithPagination;

    public
        $week_id,
        $week,
        $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'week' => 'required|string|unique:weeks,name|regex:/^[A-Za-z0-9\s]+$/'
    ];

    protected $messages = [
        'week.regex' => 'Name should contain letters only'
    ];

    public function updated($property_name)
    {
        $this->validateOnly($property_name);
    }

    public function resetModal()
    {
        $this->resetAllErrors();
        $this->week_id = '';
        $this->week = '';
    }

    public function resetAllErrors()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function renderEditModal($id)
    {
        $data = Week::find($id);
        if ($data) {
            $this->week_id = $data->id;
            $this->week = $data->name;
            $this->dispatchBrowserEvent('show-modal', ['id' => 'editModal']);
        } else {
            session()->flash('error', config('messages.NO_RECORD'));
        }
    }

    public function renderDeleteModal($id)
    {
        $this->week_id = $id;
    }

    public function add()
    {
        $this->validate();
        try {
            /* Perform some operation */
            $inserted = Week::insertInfo($this->week);
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
            $updated = Week::updatedInfo($this->week_id, $this->week);
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
            $deleted = Week::deleteInfo($this->week_id);
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

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = Week::getPaginatedInfo($this->search);
        return view('livewire.employee.manage-weeks', ['data' => $data]);
    }
}

