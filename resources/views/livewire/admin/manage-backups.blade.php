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
    <div class="row">
        <div class="col-12 col-sm-6 col-md-11">
            <h1 class="py-3 my-1">{{ config('app.name') }} Backups</h1>
        </div>
        <div class="col-12 col-md-1">
            <button type="submit" class="btn btn-primary my-3 py-3 w-100" wire:loading.class="btn-dark"
                wire:loading.class.remove="btn-primary" wire:loading.attr="disabled" wire:click="create"
                title="Create a backup">
                <span wire:loading.remove wire:target="create">
                    <i class='bx bx-hdd'></i>
                </span>
                <span wire:loading wire:target="create">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                </span>
            </button>
        </div>
    </div>
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th class="col-md-10">Available Backups</th>
                        <th class="col-md-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    @forelse ($data as $single_index => $value)
                        <tr>
                            <td>
                                {{ $value }}
                            </td>
                            <td>
                                <a href="{{ url('/backups') . '/' . $value }}" class="btn btn-info" title="Download">
                                    <i class='bx bx-cloud-download'></i>
                                </a>
                                <button type="button" class="btn btn-danger" wire:loading.class="btn-dark"
                                    wire:loading.class.remove="btn-danger" wire:loading.attr="disabled"
                                    wire:click="delete({{ $single_index }})" title="Delete">
                                    <span wire:loading.remove wire:target="delete">
                                        <i class='bx bxs-trash'></i>
                                    </span>
                                    <span wire:loading wire:target="delete">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                    </span>
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
            {{-- {{ $data->links() }} --}}
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
</div>