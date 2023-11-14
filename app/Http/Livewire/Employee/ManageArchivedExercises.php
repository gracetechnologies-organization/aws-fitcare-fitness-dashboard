<?php

namespace App\Http\Livewire\Employee;

use App\Models\Exercise;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;


class ManageArchivedExercises extends Component
{
    use WithPagination;

    public
        $ex_id,
        $search = '';

    protected $paginationTheme = 'bootstrap';

    public function resetModal()
    {
        $this->resetAllErrors();
    }

    public function resetAllErrors()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function renderExID($id)
    {
        $this->ex_id = $id;
    }

    public function destroy()
    {
        try {
            // dd($this->ex_id);
            /* Perform some operation */
            $deleted = Exercise::find($this->ex_id)->forceDelete();
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

    public function unArchive()
    {
        try {
            /* Perform some operation */
            $un_archived = Exercise::where('id', '=', $this->ex_id)
                ->update([
                    'is_active' => 1,
                    'deleted_at' => null
                ]);
            /* Operation finished */
            sleep(1);
            $this->dispatchBrowserEvent('close-modal', ['id' => 'unArchiveModal']);
            if ($un_archived) {
                session()->flash('success', config('messages.UN_ARCHIVED_SUCCESS'));
            } else {
                session()->flash('error', config('messages.UN_ARCHIVED_FAILED'));
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
        $data = Exercise::getAllTrashed($this->search);
        return view('livewire.employee.manage-archived-exercises', ['data' => $data]);
    }
}
