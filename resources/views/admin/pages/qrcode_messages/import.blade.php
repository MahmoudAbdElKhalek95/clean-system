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
                        action="{{ route('qrcode_messages.import') }}">
                        @csrf
                        <div class="row">
                        <div class="mb-1 col-md-12  @error('phone_id') is-invalid @enderror">
                            <label class="form-label" for="phone_id">{{ __('qrcode_messages.used_phone') }}</label>
                            <select name="phone_id" id="phone_id" class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('whatsapp_phones.select') }}"
                                    data-ajax--cache="true"  required >
                                @isset($item->phoneSetting)
                                    <option value="{{ $item->phoneSetting->id }}" selected>{{ $item->phoneSetting->name }}</option>
                                @endisset
                            </select>
                            @error('phone_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
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

