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
    {{-- ************************************ Add Token Model ************************************ --}}
    <div wire:ignore.self class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Generate Token</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetModal"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="token" class="form-label">Categories (Apps)</label>
                                <select wire:model.lazy="category_id" class="form-select">
                                    <option selected value=""> Select one app from the list </option>
                                    @forelse ($categories as $index => $single_category)
                                        <option value="{{ $single_category->id }}"
                                            @if ($index === 0) selected @endif>
                                            {{ $single_category->name }}
                                        </option>
                                    @empty
                                        <option value="" disabled>No Data</option>
                                    @endforelse
                                </select>
                                <small class="text-danger">
                                    @error('category_id')
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
                        <button type="submit" class="btn btn-primary" wire:click.prevent="submitForm('generate')"
                            wire:loading.class="btn-dark" wire:loading.class.remove="btn-primary"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>Generate</span>
                            <span wire:loading>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ************************************ Reset Token Model ************************************ --}}
    <div wire:ignore.self class="modal fade" id="resetTokenModal" tabindex="-1"
        aria-labelledby="editSubCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSubCategoryModalLabel">Reset Token</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetModal"></button>
                </div>
                <form wire:submit.prevent="resetToken()">
                    <div class="modal-body">
                        <p class="fs-4 text-danger">
                            Are you sure you want to reset the token for this app? <br>
                            All apps using the old token will not receive any further data <br>
                            You can't undo this action!!
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-success" data-bs-dismiss="modal">
                            No
                        </button>
                        <button type="submit" class="btn btn-danger" wire:loading.class="btn-dark"
                            wire:loading.class.remove="btn-danger" wire:loading.attr="disabled">
                            <span wire:loading.remove>Reset</span>
                            <span wire:loading>
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- ************************************ Delete Token Model ************************************ --}}
    <div wire:ignore.self class="modal fade" id="deleteTokenModal" tabindex="-1"
        aria-labelledby="deleteTokenModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="deleteTokenModalLabel">Delete Token</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetModal"></button>
                </div>
                <form wire:submit.prevent="destroy()">
                    <div class="modal-body">
                        <p class="fs-4 text-danger">
                            Are you sure you want to delete this token? <br>
                            All apps using this token will not receive any further data <br>
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
        <div class="col-12 col-sm-6 col-md-6">
            <h1 class="py-3 my-1">{{ config('app.name') }} Tokens</h1>
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
                data-bs-target="#addModal" title="Add token against an app">
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
                        <th class="col-1 col-sm-1 col-md-1 col-lg-1">ID</th>
                        <th class="col-2 col-sm-5 col-md-2 col-lg-4">Category (App)</th>
                        <th class="col-8 col-sm-4 col-md-7 col-lg-6">Token</th>
                        <th class="col-1 col-sm-1">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($data as $single_index)
                        <tr>
                            <td>
                                {{ $single_index->id }}
                            </td>
                            <td>
                                {{ $single_index->name }}
                            </td>
                            <td>
                                <div class="input-group w-75">
                                    <input type="text" class="form-control" value="{{ $single_index->token }}"
                                        disabled readonly>
                                    <button type="button" class="btn btn-secondary" id="{{ $single_index->id }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Copy to clipboard"
                                        wire:click="copyToClipboard('{{ $single_index->token }}', {{ $single_index->id }})">
                                        <i class="bx bx-clipboard"></i>
                                    </button>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
                                    data-bs-target="#resetTokenModal"
                                    wire:click="renderResetTokenModal({{ $single_index->id }})" title="Reset">
                                    <i class='bx bx-reset'></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteTokenModal"
                                    wire:click="renderDeleteModal({{ $single_index->id }})" title="Delete">
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
