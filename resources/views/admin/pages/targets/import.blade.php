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
                        action="{{ route('targets.import') }}">
                        @csrf
                        <div class="row">
                        <div class="mb-1 col-md-12  @error('type') is-invalid @enderror">
                            <label class="form-label" for="type">{{ __('targets.type') }}</label>
                            <select name="type" id="type" class="form-control" onchange="">
                                <option value="1"@isset($item)  {{ $item->type==1?'selected':'' }}  @endisset>{{__('targets.model_types.1') }}</option>
                                <option value="2"@isset($item)  {{ $item->type==2?'selected':'' }}  @endisset>{{__('targets.model_types.2') }}</option>
                                <option value="3"@isset($item)  {{ $item->type==3?'selected':'' }}  @endisset>{{__('targets.model_types.3') }}</option>
                                <option value="4"@isset($item)  {{ $item->type==4?'selected':'' }}  @endisset>{{__('targets.model_types.4') }}</option>
                                <option value="5"@isset($item)  {{ $item->type==5?'selected':'' }}  @endisset>{{__('targets.model_types.5') }}</option>
                            </select>
                        </div>
                        <div class="mb-1 col-md-12  @error('section_id') is-invalid @enderror">
                            <label class="form-label" for="section_id">{{ __('targets.target_type') }}</label>
                            <select name="section_id" id="section_id" class="form-control " required>
                            </select>
                            @error('section_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-12  @error('user_id') is-invalid @enderror">
                            <label class="form-label" for="user_id">{{ __('targets.users') }}</label>
                            <select name="user_id[]" id="user_id" class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('users.select') }}"
                                    data-ajax--cache="true" required  multiple>
                                @isset($item->users)
                                    @foreach ($item->users as $user)
                                    <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                            @error('user_id')
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

