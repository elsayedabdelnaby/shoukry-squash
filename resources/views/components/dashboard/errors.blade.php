<div class="alert alert-custom alert-danger fade show" role="alert">
    <div class="alert-text">
        <ul>
            @foreach ($errors->all() as $error)
                <li class="font-weight-bold"><span class="error d-block font-weight-bold">{{ $error }}</span>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="alert-close">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true"><i class="ki ki-close"></i></span>
        </button>
    </div>
</div>
