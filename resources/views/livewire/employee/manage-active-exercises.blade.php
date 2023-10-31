<div class="container-xxl flex-grow-1 container-p-y">
    @if (session()->has('error'))
        <div class="bs-toast toast toast-placement-ex m-2 fade bg-danger top-0 end-0 show" role="alert"
            aria-live="assertive" aria-atomic="true" data-delay="2000">
            <div class="toast-header">
                <i class="bx bx-bell me-2"></i>
                <div class="me-auto fw-semibold">Error</div>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session()->get('error') }}
            </div>
        </div>
    @endif
    @if (session()->has('success'))
        <div class="bs-toast toast toast-placement-ex m-2 fade bg-success top-0 end-0 show" role="alert"
            aria-live="assertive" aria-atomic="true" data-delay="2000">
            <div class="toast-header">
                <i class="bx bx-bell me-2"></i>
                <div class="me-auto fw-semibold">Success</div>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                {{ session()->get('success') }}
            </div>
        </div>
    @endif
    {{-- ************************************ Add Model ************************************ --}}
    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Exercise</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetModal"></button>
                </div>
                <form wire:submit.prevent="add" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="ex_name" class="form-label">Exercise Title*</label>
                                <input type="text" placeholder="Enter exercise name" wire:model.lazy="ex_name"
                                    class="form-control">
                                <small class="text-danger">
                                    @error('ex_name')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="ex_description" class="form-label">Description*</label>
                                <textarea placeholder="Enter description here..." rows="3" wire:model.lazy="ex_description" class="form-control"></textarea>
                                <small class="text-danger">
                                    @error('ex_description')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="ex_duration" class="form-label">Duration*</label>
                                <input type="number" placeholder="Enter duration" wire:model.lazy="ex_duration"
                                    class="form-control">
                                <small class="text-danger">
                                    @error('ex_duration')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Gender*</label>
                                    <select wire:model.lazy="ex_gender" class="form-select">
                                        <option selected value="">Select Gender*</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                <small class="text-danger">
                                    @error('ex_gender')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6 mb-3">
                                <label class="form-label">Thumbnail*</label>
                                <input type="file"
                                    accept="image/png, image/jpeg, image/jpg"
                                    wire:model.lazy="ex_thumbnail" class="form-control">
                                <small class="text-danger">
                                    @error('ex_thumbnail')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6 mb-3">
                                <label for="ex_video" class="form-label">Video*</label>
                                <input type="file" accept="video/*" wire:model.lazy="ex_video" class="form-control">
                                <small class="text-danger">
                                    @error('ex_video')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        {{-- Meta Info Section --}}
                        <div class="row">
                            <label class="form-label">Workouts</label>
                            @foreach ($meta_info as $single_index => $value)
                                <div class="input-group mb-3">
                                    <div class="col-12 col-lg-3">
                                        <select wire:model.lazy="meta_info.{{ $single_index }}.ex_workout_id" class="form-select py-3">
                                            <option selected value="">Select Workout*</option>
                                            @forelse ($workouts as $single_workout)
                                                <option value="{{ $single_workout->id }}">
                                                    {{ $single_workout->name }}
                                                </option>
                                            @empty
                                                <option value="" disabled>No Data</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <select wire:model.lazy="meta_info.{{ $single_index }}.ex_level_id" class="form-select py-3">
                                            <option selected value="">Select Level*</option>
                                            @forelse($levels as $single_level)
                                                <option value="{{ $single_level->id }}">
                                                    {{ $single_level->name }}
                                                </option>
                                            @empty
                                                <option value="" disabled>No Data</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-12 col-lg-2">
                                        <select wire:model.lazy="meta_info.{{ $single_index }}.ex_week_id" class="form-select py-3">
                                            <option selected value="">Select Week*</option>
                                            @forelse($weeks as $single_week)
                                                <option value="{{ $single_week->id }}">
                                                    {{ $single_week->name }}
                                                </option>
                                            @empty
                                                <option value="" disabled>No Data</option>
                                            @endforelse
                                        </select>
                                    </div>
                                    <div class="col-12 col-lg-2">
                                        <select wire:model.lazy="meta_info.{{ $single_index }}.ex_from_day"
                                            class="form-select py-3">
                                            <option selected value="">From Day*</option>
                                            @for ($from_day = 1; $from_day <= 24; $from_day++)
                                                <option value="{{ $from_day }}">{{ $from_day }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-12 col-lg-2">
                                        <select wire:model.lazy="meta_info.{{ $single_index }}.ex_till_day"
                                            class="form-select py-3">
                                            <option selected value="">Till Day*</option>
                                            @for ($from_day = 1; $from_day <= 24; $from_day++)
                                                <option value="{{ $from_day }}">{{ $from_day }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="row col-md-12 my-2 input-group">
                                        @if ($single_index === 0)
                                            <button type="button" wire:click="addMetaInfoRow"
                                                class="btn btn-secondary py-3 col-12" title="Add new row">
                                                <i class="fa-solid fa-circle-plus fa-2xl"></i>
                                            </button>
                                        @endif
                                        @if ($single_index != 0)
                                            <button type="button" wire:click="delMetaInfoFormRow({{ $single_index }})"
                                                class="btn btn-outline-danger py-3 col-12" title="Subtract this row">
                                                <i class="fa-solid fa-circle-minus fa-2xl"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            <small class="text-danger">
                                @error('meta_info.*.ex_workout_id')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="resetModal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary" wire:loading.class="btn-dark"
                            wire:loading.class.remove="btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove>Add</span>
                            <span wire:loading>
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ************************************ Edit Exercise Model ************************************ --}}
    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Exercise</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetModal"></button>
                </div>
                <form wire:submit.prevent>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-0">
                                <label for="ex_name" class="form-label">Exercise Title*</label>
                                <div class="input-group mb-3">
                                    <input type="text" placeholder="Enter exercise name"
                                        wire:model.defer="ex_name" class="form-control">
                                    <button type="submit" class="btn btn-primary" wire:loading.class="btn-dark"
                                        wire:loading.class.remove="btn-primary" wire:loading.attr="disabled"
                                        wire:click="updateName">
                                        <span wire:loading.remove wire:target="ex_name">Update Title</span>
                                        <span wire:loading wire:target="ex_name">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                        </span>
                                    </button>
                                </div>
                                <small class="text-danger">
                                    @error('ex_name')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="ex_description" class="form-label">Description*</label>
                                <textarea placeholder="Enter description here..." rows="3" wire:model.defer="ex_description"
                                    class="form-control"></textarea>
                                <button type="submit" class="btn btn-primary mt-1 col-12"
                                    wire:loading.class="btn-dark" wire:loading.class.remove="btn-primary"
                                    wire:loading.attr="disabled" wire:click="updateDescription">
                                    <span wire:loading.remove wire:target="ex_description">Update Description</span>
                                    <span wire:loading wire:target="ex_description">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                    </span>
                                </button>
                                <small class="text-danger">
                                    @error('ex_description')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="ex_duration" class="form-label">Duration*</label>
                                <div class="input-group mb-3">
                                    <input type="number" placeholder="Enter duration" wire:model.defer="ex_duration"
                                        class="form-control">
                                    <button type="submit" class="btn btn-primary" wire:loading.class="btn-dark"
                                        wire:loading.class.remove="btn-primary" wire:loading.attr="disabled"
                                        wire:click="updateDuration">
                                        <span wire:loading.remove wire:target="ex_duration">Update Duration</span>
                                        <span wire:loading wire:target="ex_duration">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                        </span>
                                    </button>
                                </div>
                                <small class="text-danger">
                                    @error('ex_duration')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Gender*</label>
                                    <div class="input-group mb-3">
                                        <select wire:model.lazy="ex_gender" class="form-select">
                                            <option selected value="">Select Gender*</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                        <button type="submit" class="btn btn-primary" wire:loading.class="btn-dark"
                                            wire:loading.class.remove="btn-primary" wire:loading.attr="disabled"
                                            wire:click="updateGender">
                                            <span wire:loading.remove wire:target="ex_gender">Update Duration</span>
                                            <span wire:loading wire:target="ex_gender">
                                                <span class="spinner-border spinner-border-sm" role="status"
                                                    aria-hidden="true"></span>
                                            </span>
                                        </button>
                                    </div>
                                <small class="text-danger">
                                    @error('ex_gender')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6 mb-3">
                                <label for="ex_thumbnail" class="form-label">Thumbnail*</label>
                                <div class="exercise-thumbnail-col">
                                    <img src="{{ asset('uploads/images/exercises/' . $ex_thumbnail_url) }}" class="exercise-thumbnail">
                                </div>
                                <div class="input-group mb-3">
                                    <input type="file"
                                        accept="image/png, image/jpeg, image/jpg"
                                        wire:model.defer="ex_thumbnail" class="form-control">
                                    <button type="submit" class="btn btn-primary" wire:loading.class="btn-dark"
                                        wire:loading.class.remove="btn-primary" wire:loading.attr="disabled"
                                        wire:click="updateImage">
                                        <span wire:loading.remove wire:target="ex_thumbnail">Update Image</span>
                                        <span wire:loading wire:target="ex_thumbnail">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                        </span>
                                    </button>
                                </div>
                                <small class="text-danger">
                                    @error('ex_thumbnail')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                            <div class="col-12 col-md-12 col-lg-6 mb-3">
                                <label for="ex_video" class="form-label">Video*</label>
                                <div class="exercise-video-col">
                                    <video src="{{ asset('uploads/videos/exercises/' . $ex_video_url) }}" controls class="exercise-video"></video>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="file" accept="video/*" wire:model.defer="ex_video"
                                        class="form-control">
                                    <button type="submit" class="btn btn-primary" wire:loading.class="btn-dark"
                                        wire:loading.class.remove="btn-primary" wire:loading.attr="disabled"
                                        wire:click="updateVideo">
                                        <span wire:loading.remove wire:target="ex_video">Update Video</span>
                                        <span wire:loading wire:target="ex_video">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                        </span>
                                    </button>
                                </div>
                                <small class="text-danger">
                                    @error('ex_video')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <label for="ex_category_id" class="form-label">Meta Info</label>
                            @foreach ($meta_info as $single_index => $value)
                                <div class="input-group mb-3">
                                    <select wire:model.defer="meta_info.{{ $single_index }}.ex_category_id"
                                        class="form-select">
                                        <option selected value="">Category*</option>
                                        @forelse ($workouts as $single_workout)
                                            <option value="{{ $single_workout->id }}">
                                                {{ $single_workout->name }}
                                            </option>
                                        @empty
                                            <option value="" disabled>No Data</option>
                                        @endforelse
                                    </select>
                                    <select wire:model.defer="meta_info.{{ $single_index }}.ex_level_id"
                                        class="form-select">
                                        <option selected value="">Level</option>
                                        @forelse($levels as $single_level)
                                            <option value="{{ $single_level->id }}">
                                                {{ $single_level->name }}
                                            </option>
                                        @empty
                                            <option value="" disabled>No Data</option>
                                        @endforelse
                                    </select>
                                    <select wire:model.defer="meta_info.{{ $single_index }}.ex_from_day"
                                        class="form-select">
                                        <option selected value="">From day</option>
                                        @for ($from_day = 1; $from_day <= 24; $from_day++)
                                            <option value="{{ $from_day }}">{{ $from_day }}</option>
                                        @endfor
                                    </select>
                                    <select wire:model.defer="meta_info.{{ $single_index }}.ex_till_day"
                                        class="form-select">
                                        <option selected value="">Till day</option>
                                        @for ($from_day = 1; $from_day <= 24; $from_day++)
                                            <option value="{{ $from_day }}">{{ $from_day }}</option>
                                        @endfor
                                    </select>
                                    @if ($single_index != 0)
                                        <button type="button"
                                            wire:click="delMetaInfoRowFromDb({{ empty($meta_info[$single_index]['rel_id']) ? 0 : $meta_info[$single_index]['rel_id'] }}, {{ $single_index }})"
                                            class="btn btn-danger" title="Delete this row">
                                            <i class='bx bx-trash display-5'></i>
                                        </button>
                                    @endif
                                    <button type="button" wire:click="addMetaInfoRow" class="btn btn-secondary"
                                        title="Add new row">
                                        <i class='bx bxs-plus-circle display-5'></i>
                                    </button>
                                    <button type="submit" class="btn btn-primary" wire:loading.class="btn-dark"
                                        wire:loading.class.remove="btn-primary" wire:loading.attr="disabled"
                                        wire:click="updateSingleMetaInfo({{ $single_index }})">
                                        <span wire:loading.remove wire:target="meta_info">Update Meta</span>
                                        <span wire:loading wire:target="meta_info">
                                            <span class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                        </span>
                                    </button>
                                </div>
                            @endforeach
                            <small class="text-danger">
                                @error('meta_info.*.ex_category_id')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="resetModal">
                            Close
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ************************************ Archive Exercise Model ************************************ --}}
    <div wire:ignore.self class="modal fade" id="archiveModal" tabindex="-1" aria-labelledby="archiveModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="archiveModalLabel">Archive Exercise</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetModal"></button>
                </div>
                <form wire:submit.prevent="archive">
                    <div class="modal-body">
                        <p class="fs-4 text-muted">
                            Are you sure you want to archive this data?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">
                            No
                        </button>
                        <button type="submit" class="btn btn-secondary" wire:loading.class="btn-dark"
                            wire:loading.class.remove="btn-secondary" wire:loading.attr="disabled">
                            <span wire:loading.remove>Archive</span>
                            <span wire:loading>
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-6">
            <h1 class="py-3 my-1">{{ config('app.name') }} Active Exercises</h1>
        </div>
        <div class="col-12 col-sm-6 col-md-5">
            <div class="input-group my-3">
                <input type="text" wire:model.debounce.500ms="search" class="form-control py-3"
                    placeholder="Search here...">
                {{-- <button class="btn btn-primary" type="button"><i class='bx bx-search-alt'></i></button> --}}
            </div>
        </div>
        <div class="col-12 col-md-1">
            <button type="button" class="btn btn-primary my-3 py-3 w-100" data-bs-toggle="modal"
                data-bs-target="#addModal" wire:click="resetModal" title="Add Exercise">
                <i class="fa-solid fa-plus fa-2xl"></i>
            </button>
        </div>
    </div>
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="col-md-1">ID</th>
                        <th class="col-md-3">Thumbnail</th>
                        <th class="col-md-2">Exercise</th>
                        <th class="col-md-2">Description</th>
                        <th class="col-md-1">Duration</th>
                        <th class="col-md-1">Video</th>
                        <th class="col-md-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($data as $single_index)
                        <tr>
                            <td>{{ $single_index->id }}</td>
                            <td>
                                <img src="{{ asset('uploads/images/exercises/' . $single_index->ex_thumbnail_url) }}" width="120px">
                            </td>
                            <td>{{ $single_index->ex_name }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($single_index->ex_description, 40, '...') }}</td>
                            <td>{{ $single_index->ex_duration }}</td>
                            <td>
                                <a href="{{ asset('uploads/videos/exercises/' . $single_index->ex_video_url) }}"
                                    target="_blank" title="Play Video">
                                    <i class='bx bx-play bx-lg text-dark'></i>
                                </a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-info" wire:click="renderEditModal({{ $single_index->id }})" wire:target="renderEditModal({{ $single_index->id }})" wire:loading.class="btn-dark" wire:loading.class.remove="btn-outline-info" wire:loading.attr="disabled" title="Edit">
                                    <span class="fa-solid fa-pencil" wire:loading.remove wire:target="renderEditModal({{ $single_index->id }})"></span>
                                    <span wire:loading wire:target="renderEditModal({{ $single_index->id }})">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                data-bs-target="#archiveModal"
                                wire:click="renderarchiveModal({{ $single_index->id }})" title="Archive">
                                <i class="fa-solid fa-box-archive"></i>
                            </button>
                            </td>
                        </tr>
                    @empty
                        <tr class="alert alert-warning alert-dismissible text-center rounded-bottom">
                            <td colspan="8" class="text-center">No Record Found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="row">
            {{ $data->links() }}
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
</div>
