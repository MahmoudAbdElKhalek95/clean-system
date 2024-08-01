<button type="button" class="btn btn-sm btn-outline-primary bg-white me-1 waves-effect border-0" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">
    <i data-feather='zoom-in'></i>
    <span class="active-sorting text-primary">{{ __('initiatives.import') }}</span>
    <i data-feather='chevron-right'></i>
</button>
<div class="modal modal-slide-in fade" id="filterModal">
    <div class="modal-dialog sidebar-sm">
        <div class="add-new-record modal-content pt-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('initiatives.import') }}</h5>
            </div>
            <div class="modal-body flex-grow-1 text-start">
                    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
                        action="{{ route('client.import') }}">
                        @csrf
                        <div class="row">
                        <div class="mb-1 col-md-12  @error('type_id') is-invalid @enderror">
                            <label class="form-label" for="type_id">{{ __('client.type_id') }}</label>
                            <select name="type_id" id="type_id" class="form-control ajax_select2 extra_field" multiple
                                    data-ajax--url="{{ route('type.select') }}"
                                    data-ajax--cache="true"  required  >
                              
                            </select>
                        </div>
                      

                     
                        <div class="mb-1 col-md-12  @error('file') is-invalid @enderror">
                            <label class="form-label">{{ __('targets.file') }}</label>
                            <input class="form-control" name="file" type="file">
                            @error('file')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary ">{{ __('initiatives.actions.save') }}</button>
                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                                {{ __('initiatives.cancel') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

