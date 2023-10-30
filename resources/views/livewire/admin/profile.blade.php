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
    <h1 class="py-3 mb-4">Profile</h1>
    <div class="row">
        <div class="card mb-4">
            <h5 class="card-header">Update Details</h5>
            <!-- Account -->
            <div class="card-body">
                <form wire:submit.prevent="edit">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" placeholder="Enter your name" wire:model.defer="data.name"
                                class="form-control" />
                            <small class="text-danger">
                                @error('data.name')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" placeholder="Enter your email" wire:model.defer="data.email"
                                class="form-control" />
                            <small class="text-danger">
                                @error('data.email')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary" wire:loading.class="btn-dark"
                            wire:loading.class.remove="btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="edit">Update</span>
                            <span wire:loading wire:target="edit">
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
        <div class="card">
            <h5 class="card-header">Change Password</h5>
            <div class="card-body">
                <form wire:submit.prevent="resetPassword">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="old_password" class="form-label">Old Password</label>
                            <input type="password" placeholder="Enter old password" wire:model.defer="old_password" class="form-control" />
                            <small class="text-danger">
                                @error('old_password')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" placeholder="Enter new password" wire:model.defer="new_password" class="form-control" />
                            <small class="text-danger">
                                @error('new_password')
                                    {{ $message }}
                                @enderror
                            </small>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary" wire:loading.class="btn-dark"
                            wire:loading.class.remove="btn-primary" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="resetPassword">Update</span>
                            <span wire:loading wire:target="resetPassword">
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
