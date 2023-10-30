<?php

namespace App\Http\Livewire\Employee;

use App\Models\WorkoutFocusedArea;
use App\Models\FocusedArea;
use App\Models\Workout;
use App\Services\ArrayManipulationClass;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class ManageWorkouts extends Component
{
    use WithPagination, WithFileUploads;

    public
        $workout_id,
        $workout_thumbnail,
        $workout,
        $workout_focused_areas = [],
        $search = '';

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'workout_thumbnail' => 'required|image|max:50',
        'workout' => 'required|string|unique:workouts,name|regex:/^[A-Za-z\s]+$/',
        'workout_focused_areas' => 'required',
    ];

    protected $messages = [
        'workout.regex' => 'Name should contain letters only',
        'workout_focused_areas.required' => 'You must have to select atleast one focused area',
    ];

    public function updated($property_name)
    {
        $this->validateOnly($property_name);
    }

    public function resetModal()
    {
        $this->resetAllErrors();
        $this->workout_id = '';
        $this->workout_thumbnail = '';
        $this->workout = '';
        $this->workout_focused_areas = [];
    }

    public function resetAllErrors()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function renderEditModal($id)
    {
        $data = Workout::find($id);
        if ($data) {
            $this->workout_id = $data->id;
            $this->workout = $data->name;
            $this->dispatchBrowserEvent('show-modal', ['id' => 'editModal']);
        } else {
            session()->flash('error', config('messages.NO_RECORD'));
        }
    }

    public function renderDeleteModal($id)
    {
        $this->workout_id = $id;
    }

    public function add()
    {
        $this->workout_focused_areas = ArrayManipulationClass::removeFalseValues($this->workout_focused_areas);
        $this->validate();
        try {
            /* Perform some operation */
            $inserted_workout = Workout::insertInfo($this->workout, $this->workout_thumbnail);
            foreach ($this->workout_focused_areas as $singel_index) {
                $inserted_relations = WorkoutFocusedArea::insertInfo($inserted_workout->id, $singel_index);
            }
            /* Operation finished */
            $this->resetModal();
            $this->dispatchBrowserEvent('reset-file-fields');
            sleep(1);
            $this->dispatchBrowserEvent('close-modal', ['id' => 'addModal']);
            if ($inserted_relations) {
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
            $updated = Workout::updatedInfo($this->workout_id, $this->workout);
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
            $deleted = Workout::deleteInfo($this->workout_id);
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
        $data = Workout::getPaginatedInfo($this->search);
        $focused_areas = FocusedArea::getAll();
        return view('livewire.employee.manage-workouts', ['data' => $data, 'focused_areas' => $focused_areas]);
    }
}
