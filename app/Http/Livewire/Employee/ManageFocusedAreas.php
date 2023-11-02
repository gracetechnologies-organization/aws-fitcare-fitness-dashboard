<?php

namespace App\Http\Livewire\Employee;

use App\Models\FocusedArea;
use App\Models\Level;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class ManageFocusedAreas extends Component
{
    use WithPagination;

    public 
    $focused_area_id, 
    $focused_area, 
    $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'focused_area' => 'required|string|unique:focused_areas,name|regex:/^[A-Za-z\s]+$/'
    ];

    protected $messages = [
        'focused_area.regex' => 'Name should contain letters only'
    ];

    public function updated($property_name)
    {
        $this->validateOnly($property_name);
    }

    public function resetModal()
    {
        $this->resetAllErrors();
        $this->focused_area_id = '';
        $this->focused_area = '';
    }

    public function resetAllErrors()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function renderEditModal($id)
    {
        $data = FocusedArea::find($id);
        if ($data) {
            $this->focused_area_id = $data->id;
            $this->focused_area = $data->name;
            $this->dispatchBrowserEvent('show-modal', ['id' => 'editModal']);
        } else {
            session()->flash('error', config('messages.NO_RECORD'));
        }
    }

    public function renderDeleteModal($id)
    {
        $this->focused_area_id = $id;
    }

    public function add()
    {
        $this->validate();
        try {
            /* Perform some operation */
            $inserted = FocusedArea::insertInfo($this->focused_area);
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
            $updated = FocusedArea::updateInfo($this->focused_area_id, $this->focused_area);
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
            $deleted = FocusedArea::deleteInfo($this->focused_area_id);
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
        $data = FocusedArea::getPaginatedInfo($this->search);
        return view('livewire.employee.manage-focused-areas', ['data' => $data]);
    }
}
