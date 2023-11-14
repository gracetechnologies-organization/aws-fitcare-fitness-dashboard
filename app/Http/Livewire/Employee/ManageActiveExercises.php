<?php

namespace App\Http\Livewire\Employee;

use App\Models\Workout;
use App\Models\Exercise;
use App\Models\ExerciseRelation;
use App\Models\Level;
use App\Models\Week;
use App\Services\ImageManipulationClass;
use App\Services\VideoManipulationClass;
use Carbon\Carbon;
use Exception;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Http\Request;

class ManageActiveExercises extends Component
{
    use WithPagination;
    use WithFileUploads;

    public
        $ex_id,
        $ex_name,
        $ex_description,
        $ex_duration,
        $ex_gender,
        $ex_thumbnail_url,
        $ex_thumbnail,
        $ex_video_url,
        $ex_video,
        $ex_workout_id,
        $ex_week_id,
        $ex_level_id,
        $ex_program_id,
        $ex_from_day,
        $ex_till_day,
        $meta_info = [],
        $search = '',
        $request_workout_id;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'ex_name' => 'required|string|unique:exercises,ex_name',
        'ex_description' => 'required|string',
        'ex_duration' => 'required|integer|numeric',
        'ex_gender' => 'required|regex:/^[A-Za-z\s]+$/',
        'ex_thumbnail' => 'required|image|max:100',
        'ex_video' => 'required|mimetypes:video/mp4|max:800',
        'meta_info.*.ex_workout_id' => 'required|integer|numeric',
        'meta_info.*.ex_level_id' => 'integer|numeric',
        'meta_info.*.ex_week_id' => 'integer|numeric',
        'meta_info.*.ex_from_day' => 'integer|numeric',
        'meta_info.*.ex_till_day' => 'integer|numeric',
    ];

    protected $messages = [
        /*
        |--------------------------------------------------------------------------
        | ex_name error messages
        |--------------------------------------------------------------------------
        */
        'ex_name.required' => 'Mere bhai exercise name must hai 😒',
        'ex_name.unique' => 'Yar unique data daal bhangra na daal 😒',
        'ex_name.alpha' => 'Jigar special characters accept nahi hon gy 🙂',
        /*
        |--------------------------------------------------------------------------
        | ex_description error messages
        |--------------------------------------------------------------------------
        */
        'ex_description.required' => 'Mere bhai description must hai 😒',
        /*
        |--------------------------------------------------------------------------
        | ex_duration error messages
        |--------------------------------------------------------------------------
        */
        'ex_duration.required' => 'Mere bhai duration must hai 😒',
        'ex_duration.integer' => 'khabrdar jo digits k siwa kuch dala 😡',
        /*
        |--------------------------------------------------------------------------
        | ex_thumbnail error messages
        |--------------------------------------------------------------------------
        */
        'ex_thumbnail.required' => 'Mere bhai thumbnail must hai 😒',
        'ex_thumbnail.image' => 'Yaar image daal dimag na kharab kr 😒',
        'ex_thumbnail.max' => 'Mai srif 100KB ki image upload krne dnga 🥳',
        /*
        |--------------------------------------------------------------------------
        | ex_video error messages
        |--------------------------------------------------------------------------
        */
        'ex_video.required' => 'Mere bhai video must hai 😒',
        'ex_video.mimetypes' => 'Bhai sahab video sirf .mp4 honi chahiye 😒',
        'ex_video.max' => 'Mai srif 800KB tk ki video upload krne dnga 🥳',
        /*
        |--------------------------------------------------------------------------
        | ex_workout_id error messages
        |--------------------------------------------------------------------------
        */
        'ex_workout_id.required' => 'Mere bhai workout must hai 😒',
        'ex_workout_id.integer' => 'khabrdar jo digits k siwa kuch dala 😡',
        /*
        |--------------------------------------------------------------------------
        | ex_level_id error messages
        |--------------------------------------------------------------------------
        */
        'ex_level_id.integer' => 'khabrdar jo digits k siwa kuch dala 😡',
        /*
        |--------------------------------------------------------------------------
        | ex_program_id error messages
        |--------------------------------------------------------------------------
        */
        'ex_program_id.integer' => 'khabrdar jo digits k siwa kuch dala 😡',
        /*
        |--------------------------------------------------------------------------
        | ex_days error messages
        |--------------------------------------------------------------------------
        */
        'ex_from_day.integer' => 'khabrdar jo digits k siwa kuch dala 😡',
        'ex_till_day.integer' => 'khabrdar jo digits k siwa kuch dala 😡',
        /*
        |--------------------------------------------------------------------------
        | meta_info error messages
        |--------------------------------------------------------------------------
        */
        'meta_info.*.ex_workout_id.required' => 'Mere bhai category must hai 😒',
        'meta_info.*.ex_level_id.integer' => 'khabrdar jo digits k siwa kuch dala 😡',
        'meta_info.*.ex_program_id.integer' => 'khabrdar jo digits k siwa kuch dala 😡',
        'meta_info.*.ex_from_day.integer' => 'khabrdar jo digits k siwa kuch dala 😡',
        'meta_info.*.ex_till_day.integer' => 'khabrdar jo digits k siwa kuch dala 😡',
    ];

    public function mount(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Assigning values to the '0' index of $meta_info array so that it can work 
        | Every time the page re-renders from the begining 
        |--------------------------------------------------------------------------
        */
        $this->meta_info = [
            [
                'rel_id' => '',
                'ex_workout_id' => '',
                'ex_level_id' => '',
                'ex_week_id' => '',
                'ex_from_day' => '',
                'ex_till_day' => ''
            ]
        ];
        $this->request_workout_id = $request->workout_id;
    }

    public function updated($property_name)
    {
        $this->validateOnly($property_name);
    }

    public function resetModal()
    {
        $this->resetAllErrors();
        $this->ex_id = '';
        $this->ex_name = '';
        $this->ex_description = '';
        $this->ex_duration = '';
        $this->ex_gender = '';
        $this->ex_thumbnail_url = '';
        $this->ex_thumbnail = '';
        $this->ex_video_url = '';
        $this->ex_video = '';
        $this->ex_workout_id = '';
        $this->ex_level_id = '';
        $this->ex_week_id = '';
        $this->ex_from_day = '';
        $this->ex_till_day = '';
        unset($this->meta_info);
        /*
        |--------------------------------------------------------------------------
        | Again assigning values to the '0' index of $meta_info array so that it  
        | Could not throw any error while opening the modal 
        |--------------------------------------------------------------------------
        */
        $this->meta_info = [
            [
                'rel_id' => '',
                'ex_workout_id' => '',
                'ex_level_id' => '',
                'ex_week_id' => '',
                'ex_from_day' => '',
                'ex_till_day' => ''
            ]
        ];
    }

    public function resetAllErrors()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function renderEditModal($id)
    {
        $this->resetModal();
        $exercise_data = Exercise::getInfoByID($id);
        $relations_data = Exercise::getRelationsInfoByID($id);
        if ($exercise_data && $relations_data) {
            $this->ex_id = $exercise_data->id;
            $this->ex_name = $exercise_data->ex_name;
            $this->ex_description = $exercise_data->ex_description;
            $this->ex_duration = $exercise_data->ex_duration;
            $this->ex_gender = $exercise_data->ex_gender;
            $this->ex_thumbnail_url = $exercise_data->ex_thumbnail_url;
            $this->ex_video_url = $exercise_data->ex_video_url;
            foreach ($relations_data as $singel_index => $value) {
                $this->meta_info[$singel_index] = [
                    'rel_id' => $value['rel_id'],
                    'ex_workout_id' => $value['workout_id'],
                    'ex_level_id' => $value['level_id'],
                    'ex_week_id' => $value['week_id'],
                    'ex_from_day' => $value['from_day'],
                    'ex_till_day' => $value['till_day'],
                ];
            }
            $this->dispatchBrowserEvent('show-modal', ['id' => 'editModal']);
        } else {
            return redirect()->to(route('emp.exercises.active'))->with('error', 'Record Not Found.');
        }
    }

    public function renderarchiveModal($id)
    {
        $this->ex_id = $id;
    }

    public function add()
    {
        $this->validate();
        try {
            /* Perform some operation */
            $inserted_exercise = Exercise::create([
                'ex_name' => $this->ex_name,
                'ex_description' => $this->ex_description,
                'ex_duration' => $this->ex_duration,
                'ex_gender' => $this->ex_gender,
                'ex_thumbnail_url' => ImageManipulationClass::getImgURL($this->ex_thumbnail, 'images/exercises'),
                'ex_video_url' => VideoManipulationClass::getVideoURL($this->ex_video, 'videos/exercises'),
            ]);
            foreach ($this->meta_info as $singel_index) {
                $inserted_relations = ExerciseRelation::create([
                    'ex_id' => $inserted_exercise->id,
                    'workout_id' => $singel_index['ex_workout_id'],
                    'level_id' => (!empty($singel_index['ex_level_id'])) ? $singel_index['ex_level_id'] : null,
                    'week_id' => (!empty($singel_index['ex_week_id'])) ? $singel_index['ex_week_id'] : null,
                    'from_day' => (!empty($singel_index['ex_from_day'])) ? $singel_index['ex_from_day'] : null,
                    'till_day' => (!empty($singel_index['ex_till_day'])) ? $singel_index['ex_till_day'] : null,
                ]);
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

    public function updateName()
    {
        $this->validateOnly('ex_name');
        try {
            /* Perform some operation */
            $updated = Exercise::where('id', '=', $this->ex_id)
                ->update(['ex_name' => $this->ex_name]);
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

    public function updateDescription()
    {
        $this->validateOnly('ex_description');
        try {
            /* Perform some operation */
            $updated = Exercise::where('id', '=', $this->ex_id)
                ->update(['ex_description' => $this->ex_description]);
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

    public function updateDuration()
    {
        $this->validateOnly('ex_duration');
        try {
            /* Perform some operation */
            $updated = Exercise::where('id', '=', $this->ex_id)
                ->update(['ex_duration' => $this->ex_duration]);
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

    public function updateGender()
    {
        $this->validateOnly('ex_gender');
        try {
            /* Perform some operation */
            $updated = Exercise::where('id', '=', $this->ex_id)
                ->update(['ex_gender' => $this->ex_gender]);
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

    public function updateImage()
    {
        $this->validateOnly('ex_thumbnail');
        try {
            /* Perform some operation */
            $updated = Exercise::where('id', '=', $this->ex_id)
                ->update(['ex_thumbnail_url' => $this->getImgURL()]);
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

    public function updateVideo()
    {
        $this->validateOnly('ex_video');
        try {
            /* Perform some operation */
            $updated = Exercise::where('id', '=', $this->ex_id)
                ->update(['ex_video_url' => $this->getVideoURL()]);
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

    public function updateSingleMetaInfo($index)
    {
        $this->validateOnly('meta_info');
        try {
            /* Perform some operation */
            $updated = ExerciseRelation::updateOrCreate(
                ['id' => (int) $this->meta_info[$index]['rel_id']],
                [
                    'ex_id' => $this->ex_id,
                    'workout_id' => $this->meta_info[$index]['ex_workout_id'],
                    'level_id' => (!empty($this->meta_info[$index]['ex_level_id'])) ? $this->meta_info[$index]['ex_level_id'] : null,
                    'week_id' => (!empty($this->meta_info[$index]['ex_week_id'])) ? $this->meta_info[$index]['ex_week_id'] : null,
                    'from_day' => (!empty($this->meta_info[$index]['ex_from_day'])) ? $this->meta_info[$index]['ex_from_day'] : null,
                    'till_day' => (!empty($this->meta_info[$index]['ex_till_day'])) ? $this->meta_info[$index]['ex_till_day'] : null
                ]
            );
            if (empty((int) $this->meta_info[$index]['rel_id']))
                $this->fillSpecificIndexOfMetaInfo($index, $updated->id);
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

    public function archive()
    {
        try {
            /* Perform some operation */
            $soft_deleted = Exercise::where('id', '=', $this->ex_id)
                ->update([
                    'is_active' => 0,
                    'deleted_at' => Carbon::now()
                ]);
            /* Operation finished */
            sleep(1);
            $this->dispatchBrowserEvent('close-modal', ['id' => 'archiveModal']);
            if ($soft_deleted) {
                session()->flash('success', config('messages.ARCHIVED_SUCCESS'));
            } else {
                session()->flash('error', config('messages.ARCHIVED_FAILED'));
            }
        } catch (Exception $error) {
            report($error);
            session()->flash('error', config('messages.INVALID_DATA'));
        }
    }

    public function delMetaInfoRowFromDb(int $rel_id = null, int $index)
    {
        try {
            /* Perform some operation */
            if ($rel_id != 0) $deleted = ExerciseRelation::find($rel_id)->delete();
            $this->delMetaInfoFormRow($index);
            /* Operation finished */
            sleep(1);
            if ($deleted) {
                session()->flash('success', config('messages.DELETION_SUCCESS'));
            } else {
                session()->flash('error', config('messages.DELETION_FAILED'));
            }
        } catch (Exception $error) {
            report($error);
            session()->flash('error', config('messages.EMPTY_ROW_DELETION'));
        }
    }

    // public function getImgURL()
    // {
    //     $this->ex_thumbnail_url = Carbon::now()->timestamp . "_" . $this->ex_thumbnail->getClientOriginalName();
    //     /*
    //     |--------------------------------------------------------------------------
    //     | Save the image to the default storage path "storage/app/public/images"
    //     |--------------------------------------------------------------------------
    //     */
    //     $this->ex_thumbnail->storeAs('public/images', $this->ex_thumbnail_url);
    //     return $this->ex_thumbnail_url;
    // }

    // public function getVideoURL()
    // {
    //     $this->ex_video_url = Carbon::now()->timestamp . "_" . $this->ex_video->getClientOriginalName();
    //     /*
    //     |--------------------------------------------------------------------------
    //     | Save the video to the default storage path "storage/app/public/videos"
    //     |--------------------------------------------------------------------------
    //     */
    //     $this->ex_video->storeAs('public/videos', $this->ex_video_url);
    //     return $this->ex_video_url;
    // }

    public function addMetaInfoRow()
    {
        /*
        |--------------------------------------------------------------------------
        | The following code will add a new index into the array  
        | It will also add an empty associative array on that newly created index 
        |--------------------------------------------------------------------------
        */
        $this->meta_info[] = [
            'rel_id' => '',
            'ex_workout_id' => '',
            'ex_level_id' => '',
            'ex_week_id' => '',
            'ex_from_day' => '',
            'ex_till_day' => ''
        ];
    }

    public function delMetaInfoFormRow($index)
    {
        unset($this->meta_info[$index]);
    }

    public function fillSpecificIndexOfMetaInfo(int $index, int $rel_id): void
    {
        $this->meta_info[$index] = [
            'rel_id' => $rel_id,
            'ex_id' => $this->ex_id,
            'ex_workout_id' => $this->meta_info[$index]['ex_workout_id'],
            'ex_week_id' => (!empty($this->meta_info[$index]['ex_week_id'])) ? $this->meta_info[$index]['ex_week_id'] : null,
            'ex_level_id' => (!empty($this->meta_info[$index]['ex_level_id'])) ? $this->meta_info[$index]['ex_level_id'] : null,
            'ex_program_id' => (!empty($this->meta_info[$index]['ex_program_id'])) ? $this->meta_info[$index]['ex_program_id'] : null,
            'ex_from_day' => (!empty($this->meta_info[$index]['ex_from_day'])) ? $this->meta_info[$index]['ex_from_day'] : null,
            'ex_till_day' => (!empty($this->meta_info[$index]['ex_till_day'])) ? $this->meta_info[$index]['ex_till_day'] : null
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if (!empty($this->request_sub_cat_id) && !empty($this->request_category_id))
            $data = Exercise::getExercisesOfSubCategory($this->request_category_id, $this->request_sub_cat_id, $this->search);
        elseif (!empty($this->request_category_id))
            $data = Exercise::getExercisesOfCategory($this->request_category_id, $this->search);
        elseif (!empty($this->request_program_id))
            $data = Exercise::getExercisesOfProgram($this->request_program_id, $this->search);
        else
            $data = Exercise::getAll($this->search);

        $workouts = Workout::getAll();
        $levels = Level::orderBy('name', 'asc')->get();
        $weeks = Week::orderBy('name', 'asc')->get();
        return view('livewire.employee.manage-active-exercises', [
            'data' => $data,
            'workouts' => $workouts,
            'levels' => $levels,
            'weeks' => $weeks
        ]);
    }
}
