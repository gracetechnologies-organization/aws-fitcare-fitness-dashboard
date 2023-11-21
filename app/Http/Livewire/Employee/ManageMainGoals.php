<?php

namespace App\Http\Livewire\Employee;

use App\Models\MainGoal;
use Exception;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ManageMainGoals extends Component
{
    use WithPagination, WithFileUploads;

    public
    $main_goal_id,
    $main_goal,
    $main_goal_gender,
    $main_goal_thumbnail,
    $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'main_goal' => 'required|regex:/^[A-Za-z\s]+$/',
        'main_goal_gender' => 'required|regex:/^[A-Za-z\s]+$/',
        'main_goal_thumbnail' => 'required|image|max:50'
    ];

    protected $messages = [
        'main_goal.regex' => 'Name should contain letters only'
    ];

    public function updated($property_name)
    {
        $this->validateOnly($property_name);
    }

    public function resetModal()
    {
        $this->resetAllErrors();
        $this->main_goal_id = '';
        $this->main_goal = '';
        $this->main_goal_gender = '';
        $this->main_goal_thumbnail = '';
    }

    public function resetAllErrors()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function renderEditModal($id)
    {
        $data = MainGoal::find($id);
        if ($data) {
            $this->main_goal_id = $data->id;
            $this->main_goal = $data->name;
            $this->main_goal_gender = $data->gender;
            $this->main_goal_thumbnail = $data->thumbnail_url;
            $this->dispatchBrowserEvent('show-modal', ['id' => 'editModal']);
        } else {
            session()->flash('error', config('messages.NO_RECORD'));
        }
    }

    public function renderDeleteModal($id)
    {
        $this->main_goal_id = $id;
    }

    public function add()
    {
        $this->validate();
        try {
            /* Perform some operation */
            $inserted = MainGoal::insertInfo($this->main_goal, $this->main_goal_gender, $this->main_goal_thumbnail);
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
            $updated = MainGoal::updateInfo($this->main_goal_id, $this->main_goal, $this->main_goal_gender, $this->main_goal_thumbnail);
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
            $deleted = MainGoal::deleteInfo($this->main_goal_id);
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
        $this->{$form_name}();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = MainGoal::getPaginatedInfo($this->search);
        return view('livewire.employee.manage-main-goals', ['data' => $data]);
    }
}
