<?php

namespace App\Http\Livewire\Employee;

use App\Models\Category;
use App\Models\Exercise;
use App\Models\SubCategory;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;

class ManageCategories extends Component
{
    use WithPagination;

    public
        $category_id,
        $category,
        $search = '',
        $categories_page,
        $child_checkboxes_checked = false;

    // protected $listeners = ['postAdded' => 'showAlert'];

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'category' => 'required|string|unique:categories,name|regex:/^[A-Za-z\s]+$/'
    ];

    protected $messages = [
        'category.required' => 'Mere bhai category must hai 😒',
        'category.unique' => 'Yar unique data daal bhangra na daal 😒',
        'category.regex' => 'Jigar sirf letters dalo 🙂'
    ];

    public function updated($property_name)
    {
        $this->validateOnly($property_name);
    }

    public function resetModal()
    {
        $this->resetAllErrors();
        $this->category_id = '';
        $this->category = '';
    }

    public function resetAllErrors()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function renderEditModal($id)
    {
        $data = Category::find($id);
        if ($data) {
            $this->category_id = $data->id;
            $this->category = $data->name;
        } else {
            return redirect()->to(route('emp.categories'))->with('error', 'Record Not Found.');
        }
    }

    public function renderDeleteModal($id)
    {
        $this->category_id = $id;
    }

    public function add()
    {
        $this->validate();
        try {
            /* Perform some operation */
            $inserted = Category::create([
                'name' => $this->category
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
            $updated = Category::where('id', '=', $this->category_id)
                ->update(['name' => $this->category]);
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
            $deleted = Category::find($this->category_id)->delete();
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

    public function totalExercisesOfCategory($cat_id)
    {
        return Exercise::totalExercisesOfCategory($cat_id);
    }

    public function totalExercisesOfCategoryLevel($cat_id, $level_id)
    {
        return Exercise::totalExercisesOfCategoryLevel($cat_id, $level_id);
    }

    public function totalSubCategoriesOfCategory($cat_id)
    {
        return SubCategory::totalSubCategoriesOfCategory($cat_id);
    }

    public function selectAllCheckboxes()
    {
        // $this->dispatchBrowserEvent('select-checkboxes', ['id' => 'childCheckbox']);
        // $this->child_checkboxes_checked = ($this->child_checkboxes_checked === true) ? false : true;
        // $this->selectedCheckboxes = true;
    }

    // public $selectedCheckboxes = [];
    // public function selectCheckbox($id)
    // {
    //     dd($this->selectedCheckboxes);
    //     // $this->dispatchBrowserEvent('select-checkbox', ['id' => 'childCheckbox']);
    //     // // Perform your logic based on the selected checkbox

    //     // // Access the selected checkbox value
    //     // $isChecked = ($this->selectedCheckboxes[$id]) ?? false;

    //     // if ($isChecked) {
    //     //     // Checkbox is selected
    //     // } else {
    //     //     // Checkbox is not selected
    //     // }
    // }

    public function selectSingleCheckbox()
    {
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if (empty($this->search)) {
            $data = Category::getCategories();
        } else {
            $data = Category::searchCategories($this->search);
            // To update the child components after search is initiated
            $this->categories_page++;
        }

        return view('livewire.employee.manage-categories', ['data' => $data]);
    }
}
