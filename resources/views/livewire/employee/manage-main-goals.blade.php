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
                    <h5 class="modal-title" id="addModalLabel">Add Main Goal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetModal"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Thumbnail*</label>
                                <input type="file" accept="image/png, image/jpeg, image/jpg" wire:model.lazy="main_goal_thumbnail" class="form-control">
                                <small class="text-danger">
                                    @error('main_goal_thumbnail')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Name*</label>
                                <input type="text" placeholder="Enter mian goal name" wire:model.lazy="main_goal" class="form-control">
                                <small class="text-danger">
                                    @error('main_goal')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Gender*</label>
                                <select wire:model.lazy="main_goal_gender" class="form-select">
                                    <option value="" selected>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <small class="text-danger">
                                    @error('main_goal_gender')
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
                        <button type="submit" class="btn btn-primary" wire:click.prevent="submitForm('add')" wire:target="submitForm('add')" wire:loading.class="btn-dark" wire:loading.class.remove="btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="submitForm('add')">Add</span>
                            <span wire:loading wire:target="submitForm('add')">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>
                        </button>
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
                                <img src="{{ asset('uploads/images/main_goals/' . $main_goal_thumbnail) }}" width="200px">
                                <label class="form-label">Thumbnail*</label>
                                <input type="file" accept="image/png, image/jpeg, image/jpg" wire:model.defer="main_goal_thumbnail" class="form-control">
                                <small class="text-danger">
                                    @error('main_goal_thumbnail')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Name*</label>
                                <input type="text" placeholder="Enter main goal name" value="{{ $main_goal }}" wire:model.defer="main_goal" class="form-control">
                                <small class="text-danger">
                                    @error('main_goal')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Gender*</label>
                                <select wire:model.lazy="main_goal_gender" class="form-select">
                                    <option value="male" @if ($main_goal_gender == 'male') selected @endif>Male</option>
                                    <option value="female" @if ($main_goal_gender == 'female') selected @endif>Female</option>
                                </select>
                                <small class="text-danger">
                                    @error('main_goal_gender')
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
            <h1 class="py-3 my-1">Main Goals</h1>
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
                        <th class="col-md-1">ID</th>
                        <th class="col-md-3">Main Goals</th>
                        <th class="col-md-2">Genders</th>
                        <th class="col-md-4">Thumbnails</th>
                        <th class="col-md-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($data as $single_index)
                        <tr>
                            <td>{{ $single_index->id }}</td>
                            <td>{{ $single_index->name }}</td>
                            <td>{{ ucfirst($single_index->gender) }}</td>
                            <td>
                                <img src="{{ asset('uploads/images/main_goals/' . $single_index->thumbnail_url) }}" width="120px">
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
                                    data-bs-target="#editModal" wire:click="renderEditModal({{ $single_index->id }})" title="Edit">
                                    <i class='bx bxs-edit-alt'></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"
                                    wire:click="renderDeleteModal({{ $single_index->id }})" title="Delete">
                                    <i class='bx bxs-trash'></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr class="alert alert-warning alert-dismissible text-center rounded-bottom">
                            <td colspan="5" class="text-center">No Record Found</td>
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

