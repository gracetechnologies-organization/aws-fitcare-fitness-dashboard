<div class="container-xxl flex-grow-1 container-p-y">
    @if (session()->has('error'))
        <div class="bs-toast toast toast-placement-ex m-2 fade bg-danger top-0 end-0 show" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
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
        <div class="bs-toast toast toast-placement-ex m-2 fade bg-success top-0 end-0 show" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
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
    {{-- ************************************ Add Modal ************************************ --}}
    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Workout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetModal"></button>
                </div>
                <form>
                    <div class="modal-body">
                        @if ($focused_areas->isEmpty())
                            <p>Please! first create some focused areas.</p>
                        @else
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Thumbnail*</label>
                                    <input type="file" accept="image/png, image/jpeg, image/jpg" wire:model.lazy="workout_thumbnail" class="form-control">
                                    <small class="text-danger">
                                        @error('workout_thumbnail')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Name*</label>
                                    <input type="text" placeholder="Enter workout name" wire:model.lazy="workout" class="form-control">
                                    <small class="text-danger">
                                        @error('workout')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Gender*</label>
                                    <select wire:model.lazy="workout_gender" class="form-select">
                                        <option value="" selected>Select gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    <small class="text-danger">
                                        @error('workout_gender')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label">Focused Areas*</label>
                                    <div>
                                        @foreach ($focused_areas as $single_index => $value)
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input" wire:model.lazy="workout_focused_areas.{{ $single_index }}" id="focusedArea{{ $value->id }}" value="{{ $value->id }}">
                                                <label class="form-check-label" for="focusedArea{{ $value->id }}">{{ $value->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <small class="text-danger">
                                        @error('workout_focused_areas')
                                            {{ $message }}
                                        @enderror
                                    </small>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" wire:click="resetModal">
                            Close
                        </button>
                        @if (!$focused_areas->isEmpty())
                            <button type="submit" class="btn btn-primary" wire:click.prevent="submitForm('add')" wire:target="submitForm('add')" wire:loading.class="btn-dark" wire:loading.class.remove="btn-primary" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="submitForm('add')">Add</span>
                                <span wire:loading wire:target="submitForm('add')">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                </span>
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ************************************ Edit Modal ************************************ --}}
    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Workout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetModal"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <img src="{{ asset('uploads/images/workouts/' . $workout_thumbnail) }}" width="200px">
                                <label class="form-label">Thumbnail*</label>
                                <input type="file" accept="image/png, image/jpeg, image/jpg" wire:model.defer="workout_thumbnail" class="form-control">
                                <small class="text-danger">
                                    @error('workout_thumbnail')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Name*</label>
                                <input type="text" placeholder="Enter workout name" value="{{ $workout }}" wire:model.defer="workout" class="form-control">
                                <small class="text-danger">
                                    @error('workout')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Gender*</label>
                                <select wire:model.lazy="workout_gender" class="form-select">
                                    <option value="male" @if ($workout_gender == 'male') selected @endif>Male</option>
                                    <option value="female" @if ($workout_gender == 'female') selected @endif>Female</option>
                                </select>
                                <small class="text-danger">
                                    @error('workout_gender')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Focused Areas*</label>
                                <div>
                                    @foreach ($focused_areas as $single_index => $value)
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" wire:model.defer="workout_focused_areas" id="focusedArea{{ $value->id }}" 
                                            value="{{ $value->id }}">
                                            <label class="form-check-label" for="focusedArea{{ $value->id }}">{{ $value->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                <small class="text-danger">
                                    @error('workout_focused_areas')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" wire:click="resetModal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary" wire:click.prevent="submitForm('edit')" wire:target="submitForm('edit')" wire:loading.class="btn-dark" wire:loading.class.remove="btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="submitForm('edit')">Update</span>
                            <span wire:loading wire:target="submitForm('edit')">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ************************************ Delete Modal ************************************ --}}
    @include('components.delete-modal')

    <div class="row">
        <div class="col-12 col-sm-6 col-md-6">
            <h1 class="py-3 my-1">{{ config('app.name') }} Workout</h1>
        </div>
        <div class="col-12 col-sm-6 col-md-5">
            <div class="input-group my-3">
                <input type="text" wire:model.debounce.500ms="search" class="form-control py-3" placeholder="Search here...">
                {{-- <button class="btn btn-primary" type="button"><i class='bx bx-search-alt'></i></button> --}}
            </div>
        </div>
        <div class="col-12 col-md-1">
            <button type="button" class="btn btn-primary my-3 py-3 w-100" data-bs-toggle="modal" data-bs-target="#addModal" title="Add Level">
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
                        <td class="col-md-1">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input form-checkbox-custom" id="headingCheckBox">
                            </div>
                        </td>
                        <th class="col-md-1">ID</th>
                        <th class="col-md-8">Workout</th>
                        <th class="col-md-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($data as $single_index)
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input form-checkbox-custom" id="headingCheckBox">
                                </div>
                            </td>
                            <td>{{ $single_index->id }}</td>
                            <td>
                                {{-- <a href="{{ route('emp.exercises.active', ['cat_id' => 1]) }}">
                                    {{ $single_index->name }}
                                </a> --}}
                                <a href="#">
                                    {{ $single_index->name }}
                                </a>
                                <div>
                                    Total:
                                    <span class="ms-3">
                                        Exercises: 200
                                    </span>
                                    <span class="ms-3">
                                        Beginner: 100
                                    </span>
                                    <span class="ms-3">
                                        Intermediate: 90
                                    </span>
                                    <span class="ms-3">
                                        Expert: 10
                                    </span>
                                    <span class="ms-3">
                                        Focused Areas: 2
                                    </span>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-info" wire:click="renderEditModal({{ $single_index->id }})" wire:target="renderEditModal({{ $single_index->id }})" wire:loading.class="btn-dark" wire:loading.class.remove="btn-outline-info" wire:loading.attr="disabled" title="Edit">
                                    <span class="fa-solid fa-pencil" wire:loading.remove wire:target="renderEditModal({{ $single_index->id }})"></span>
                                    <span wire:loading wire:target="renderEditModal({{ $single_index->id }})">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    </span>
                                </button>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" wire:click="renderDeleteModal({{ $single_index->id }})" title="Delete">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </td>
                        </tr>

                        {{-- Increment $i to add different id in all child components --}}
                        {{-- @dd($single_index) --}}

                        <tr>
                            <td colspan="4" class="sub-category-bg">
                                <div class="accordion accordion-flush" id="accordionFlush{{ $single_index->id }}">
                                    <div class="accordion-item accordion-item-custom">
                                        <h2 class="accordion-header text-end" id="flush-heading{{ $single_index->id }}">
                                            <button class="accordion-button collapsed accordion-button-custom sub-category-bg text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#focusedAreas{{ $single_index->id }}" aria-expanded="false" aria-controls="focusedAreas{{ $single_index->id }}">
                                                Focused Areas
                                            </button>
                                        </h2>
                                        <div id="focusedAreas{{ $single_index->id }}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{ $single_index->id }}" data-bs-parent="#accordionFlush{{ $single_index->id }}">
                                            <div class="accordion-body sub-category-bg">
                                                <!-- Basic Bootstrap Table -->
                                                <div class="card">
                                                    <div class="table-responsive text-nowrap">
                                                        <table class="table table-hover">
                                                            <tbody class="table-border-bottom-0">
                                                                @foreach ($single_index->focused_areas as $single_relation)
                                                                    {{-- @dd($single_relation) --}}
                                                                    <tr>
                                                                        <td>
                                                                            {{-- <a href="{{ route('emp.exercises.active', ['cat_id' => 3, 'sub_cat_id' => 1]) }}">
                                                                                Legs
                                                                            </a> --}}
                                                                            <a href="#">
                                                                                {{ $single_relation->name }}
                                                                            </a>
                                                                            <div>
                                                                                Total:
                                                                                <span class="ms-3">
                                                                                    Exercises: 33
                                                                                </span>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <!--/ Basic Bootstrap Table -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr class="alert alert-warning alert-dismissible text-center rounded-bottom">
                            <td colspan="5" class="text-center">No Record Found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="row">
            {{-- {{ $data->links() }} --}}
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
</div>
