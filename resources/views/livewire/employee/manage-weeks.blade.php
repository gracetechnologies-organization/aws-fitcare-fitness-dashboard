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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Add Week</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetModal"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Week</label>
                                <input type="text" placeholder="Enter week name" wire:model.lazy="week"
                                    class="form-control">
                                <small class="text-danger">
                                    @error('week')
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
                        <button type="submit" class="btn btn-primary" wire:click.prevent="submitForm('add')" wire:loading.class="btn-dark"
                            wire:loading.class.remove="btn-primary" wire:loading.attr="disabled">
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
    {{-- ************************************ Edit Model ************************************ --}}
    <div wire:ignore.self class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Week</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetModal"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label class="form-label">Week</label>
                                <input type="text" placeholder="Enter week name" value="{{ $week }}"
                                    wire:model.lazy="week" class="form-control">
                                <small class="text-danger">
                                    @error('week')
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
                        <button type="submit" class="btn btn-primary" wire:click.prevent="submitForm('edit')" wire:loading.class="btn-dark"
                            wire:loading.class.remove="btn-primary" wire:loading.attr="disabled">
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
    {{-- ************************************ Delete Model ************************************ --}}
    @include('components.delete-modal')

    <div class="row">
        <div class="col-12 col-sm-6 col-md-6">
            <h1 class="py-3 my-1">{{ config('app.name') }} Weeks</h1>
        </div>
        <div class="col-12 col-sm-6 col-md-5">
            <div class="input-group my-3">
                <input type="text" wire:model.debounce.500ms="search" class="form-control py-3" placeholder="Search here...">
                {{-- <button class="btn btn-primary" type="button"><i class='bx bx-search-alt'></i></button> --}}
            </div>
        </div>
        <div class="col-12 col-md-1">
            <button type="button" class="btn btn-primary my-3 py-3 w-100" data-bs-toggle="modal"
                data-bs-target="#addModal" title="Add Week">
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
                        <th class="col-md-9">Week</th>
                        <th class="col-md-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($data as $single_index)
                        <tr>
                            <td> {{ $single_index->id }}</td>
                            <td>{{ $single_index->name }}</td>
                            <td>
                                <button type="button" class="btn btn-outline-info" wire:click="renderEditModal({{ $single_index->id }})" wire:target="renderEditModal({{ $single_index->id }})" wire:loading.class="btn-dark" wire:loading.class.remove="btn-outline-info" wire:loading.attr="disabled">
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
