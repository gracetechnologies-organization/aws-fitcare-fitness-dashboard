<div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <br>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetModal"></button>
            </div>
            <form wire:submit.prevent="destroy">
                <div class="modal-body">
                    <div class="text-danger text-center display-4 py-5">
                        <i class="fa-solid fa-skull-crossbones fa-2xl"></i>
                    </div>
                    <p class="fs-4 text-danger text-center">
                        {!! config('messages.DELETE_WARNING') !!}
                    </p>
                </div>
                <div class="modal-footer">
                    <div class="col-12 btn-group" role="group" aria-label="Button group name">
                        <button type="submit" class="btn btn-danger" wire:target="destroy" wire:loading.attr="disabled" wire:loading.class.remove="btn-danger" wire:loading.class="btn-dark">
                            <span wire:loading.remove wire:target="destroy">Yes</span>
                            <span wire:loading wire:target="destroy">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                            No
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>