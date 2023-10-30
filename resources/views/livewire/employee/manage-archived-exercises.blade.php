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
    {{-- ************************************ UnArchive Exercise Model ************************************ --}}
    <div wire:ignore.self class="modal fade" id="unArchiveModal" tabindex="-1" aria-labelledby="unArchiveModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="unArchiveModalLabel">Unarchive Exercise</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetModal"></button>
                </div>
                <form wire:submit.prevent="unArchive">
                    <div class="modal-body">
                        <p class="fs-4 text-success">
                            Are you sure you want to restore this data?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            No
                        </button>
                        <button type="submit" class="btn btn-success" wire:loading.class="btn-dark"
                            wire:loading.class.remove="btn-success" wire:loading.attr="disabled">
                            <span wire:loading.remove>Restore</span>
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
    {{-- ************************************ Delete Exercise Model ************************************ --}}
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="deleteModalLabel">Delete Exercise</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="resetModal"></button>
                </div>
                <form wire:submit.prevent="destroy">
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
        <div class="col-12 col-sm-6 col-md-6">
            <h1 class="py-3 my-1">{{ config('app.name') }} Archived Exercises</h1>
        </div>
        <div class="col-12 col-sm-6 col-md-6">
            <div class="input-group my-3">
                <input type="text" wire:model.debounce.500ms="search" class="form-control py-3"
                    placeholder="Search here...">
            </div>
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
                                <img src="{{ asset('storage/images/' . $single_index->ex_thumbnail_url) }}"
                                    width="120px">
                            </td>
                            <td>{{ $single_index->ex_name }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($single_index->ex_description, 40, '...') }}</td>
                            <td>{{ $single_index->ex_duration }}</td>
                            <td>
                                <a href="{{ asset('storage/videos/' . $single_index->ex_video_url) }}"
                                    target="_blank" title="Play Video"><i class='bx bx-play bx-lg text-dark'></i></a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                    data-bs-target="#unArchiveModal"
                                    wire:click="renderExID({{ $single_index->id }})" title="Restore">
                                    <i class='bx bxs-archive-out'></i>
                                </button>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal"
                                    wire:click="renderExID({{ $single_index->id }})" title="Delete">
                                    <i class='bx bxs-trash'></i>
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
