<?php

namespace App\Http\Livewire\Employee;

use App\Models\Exercise;
use App\Models\SubCategory;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class ManageSubCategories extends Component
{
    use WithPagination;

    public
        $sub_category_id,
        $sub_category,
        $search = '',
        $parent_category_id,
        $save_updated_id,
        $selectAll = false,
        $selected,
        $component_id;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'sub_category' => 'required|string|unique:sub_categories,name|regex:/^[A-Za-z\s]+$/'
    ];

    protected $messages = [
        'sub_category.required' => 'Oye sub category daal 😒',
        'sub_category.unique' => 'Yar unique data daal bhangra na daal 😒',
        'sub_category.regex' => 'Jigar sirf letters dalo 🙂'
    ];

    public function mount()
    {
        $this->component_id = $this->id;
    }

    public function updated($property_name)
    {
        $this->validateOnly($property_name);
    }

    public function resetModal()
    {
        $this->resetAllErrors();
        $this->sub_category_id = '';
        $this->sub_category = '';
    }

    public function resetAllErrors()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function renderEditSubCategoryModal($id)
    {
        $data = SubCategory::find($id);
        if ($data) {
            $this->sub_category_id = $data->id;
            $this->sub_category = $data->name;
        } else {
            return redirect()->to(route('emp.categories'))->with('error', 'Record Not Found.');
        }
    }

    public function renderDeleteSubCategoryModal($id)
    {
        $this->sub_category_id = $id;
    }

    public function addSubCategory($model_id)
    {
        $this->validate();
        try {
            /* Perform some operation */
            $inserted = SubCategory::create([
                'name' => $this->sub_category,
                'category_id' => $this->parent_category_id,
            ]);
            /* Operation finished */
            $this->resetModal();
            $this->resetPage();
            sleep(1);
            $this->dispatchBrowserEvent('close-modal', ['id' => $model_id]);
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

    public function editSubCategory($model_id)
    {
        $this->validate();
        try {
            /* Perform some operation */
            $updated = SubCategory::where('id', '=', $this->sub_category_id)
                ->update(['name' => $this->sub_category]);
            /* Operation finished */
            $this->resetModal();
            sleep(1);
            $this->dispatchBrowserEvent('close-modal', ['id' => $model_id]);
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

    public function destroySubCategory($model_id)
    {
        try {
            /* Perform some operation */
            $deleted = SubCategory::find($this->sub_category_id)->delete();
            /* Operation finished */
            sleep(1);
            $this->dispatchBrowserEvent('close-modal', ['id' => $model_id]);
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
    public function submitForm($method_name, $model_id = null)
    {
        ($model_id != null) ? $this->$method_name($model_id) : $this->$method_name();
    }

    public function totalExercisesOfSubCategory($sub_cat_id)
    {
        return Exercise::totalExercisesOfSubCategory($sub_cat_id);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $data = SubCategory::where('name', 'like', '%' . $this->search . '%')
            ->where('category_id', $this->parent_category_id)
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'sub_cat_page');

        return view('livewire.employee.manage-sub-categories', ['data' => $data]);
    }
}
