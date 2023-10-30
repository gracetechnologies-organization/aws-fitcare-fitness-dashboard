<div class="container-xxl flex-grow-1 container-p-y sub-category-bg">
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
    {{-- ************************************ Add Sub Category Model ************************************ --}}
    <div wire:ignore.self class="modal fade" id="addSubCategoryModal{{ $this->component_id }}" tabindex="-1"
        aria-labelledby="addSubCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubCategoryModalLabel">Add Sub Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetModal"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="category" class="form-label">Sub Category</label>
                                <input type="text" placeholder="Enter sub category name"
                                    wire:model.lazy="sub_category" class="form-control">
                                {{-- <input type="text" wire:model="parent_category_id"> --}}
                                <small class="text-danger">
                                    @error('sub_category')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="resetModal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary"
                            wire:click.prevent="submitForm('addSubCategory', 'addSubCategoryModal{{ $this->component_id }}')"
                            wire:loading.class="btn-dark" wire:loading.class.remove="btn-primary"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>Add</span>
                            <span wire:loading>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ************************************ Edit Sub Category Model ************************************ --}}
    <div wire:ignore.self class="modal fade" id="editSubCategoryModal{{ $this->component_id }}" tabindex="-1"
        aria-labelledby="editSubCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubCategoryModalLabel">Edit Sub Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetModal"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="category" class="form-label">Sub Category</label>
                                <input type="text" placeholder="Enter sub category name" value="{{ $sub_category }}"
                                    wire:model.lazy="sub_category" class="form-control">
                                <small class="text-danger">
                                    @error('sub_category')
                                        {{ $message }}
                                    @enderror
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                            wire:click="resetModal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-primary"
                            wire:click.prevent="submitForm('editSubCategory', 'editSubCategoryModal{{ $this->component_id }}')"
                            wire:loading.class="btn-dark" wire:loading.class.remove="btn-primary"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>Update</span>
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
    {{-- ************************************ Delete Sub Category Model ************************************ --}}
    <div wire:ignore.self class="modal fade" id="deleteSubCategoryModal{{ $this->component_id }}" tabindex="-1"
        aria-labelledby="deleteSubCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="deleteSubCategoryModalLabel">Delete Sub Category</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetModal"></button>
                </div>
                <form wire:submit.prevent="destroySubCategory('deleteSubCategoryModal{{ $this->component_id }}')">
                    <div class="modal-body">
                        <p class="fs-4 text-danger">
                            Are you sure you want to delete this data? <br>
                            You can't undo this action!!
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">
                            No
                        </button>
                        <button type="submit" class="btn btn-danger" wire:loading.class="btn-dark"
                            wire:loading.class.remove="btn-danger" wire:loading.attr="disabled">
                            <span wire:loading.remove>Delete</span>
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
        <div class="col-12 col-sm-6 col-md-10">
            <div class="input-group my-3">
                <input type="text" wire:model.debounce.500ms="search" class="form-control py-3"
                    placeholder="Search sub category here...">
                {{-- <button class="btn btn-primary" type="button"><i class='bx bx-search-alt'></i></button> --}}
            </div>
        </div>
        <div class="col-12 col-md-2">
            <button type="button" class="btn btn-dark my-3 py-3 w-100" data-bs-toggle="modal"
                data-bs-target="#addSubCategoryModal{{ $this->component_id }}" title="Add Sub Category">
                <i class='bx bx-plus-medical'></i>
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
                        <th class="col-md-9">Sub Category </th>
                        <th class="col-md-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($data as $single_index)
                        <tr>
                            <td> {{ $single_index->id }} </td>
                            <td>
                                <a
                                    href="{{ route('emp.exercises.active', ['cat_id' => $parent_category_id, 'sub_cat_id' => $single_index->id]) }}">
                                    {{ $single_index->name }}
                                </a>
                                <div>
                                    Total:
                                    <span class="ms-3">
                                        Exercises: {{ $this->totalExercisesOfSubCategory($single_index->id) }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#editSubCategoryModal{{ $this->component_id }}"
                                    wire:click="renderEditSubCategoryModal({{ $single_index->id }})" title="Edit">
                                    <i class='bx bxs-edit-alt'></i>
                                </button>
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteSubCategoryModal{{ $this->component_id }}"
                                    wire:click="renderDeleteSubCategoryModal({{ $single_index->id }})" title="Delete">
                                    <i class='bx bxs-trash'></i>
                                </button>
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
            {{ $data->links() }}
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
</div>
