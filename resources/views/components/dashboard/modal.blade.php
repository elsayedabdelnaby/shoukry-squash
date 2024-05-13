<div class="modal fade" id="{{ $id }}" role="dialog" aria-labelledby="{{ $id.'Label' }}"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered {{ $size }}" role="document">
        <div class="modal-content">
            {{ $slot }}
        </div>
    </div>
</div>
