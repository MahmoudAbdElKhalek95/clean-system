<button type="button" class="btn btn-sm btn-outline-primary bg-white me-1 waves-effect border-0" type="button" data-bs-toggle="modal" data-bs-target="#filterModal">
    <i data-feather='zoom-in'></i>
    <span class="active-sorting text-primary">{{ __('links.advanced_filter') }}</span>
    <i data-feather='chevron-right'></i>
</button>
<div class="modal modal-slide-in fade" id="filterModal">
    <div class="modal-dialog sidebar-sm">
        <div class="add-new-record modal-content pt-0">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
            <div class="modal-header mb-1">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('links.advanced_filter') }}</h5>
            </div>
            <div class="modal-body flex-grow-1 text-start">
                     <form id="filterForm" class="" action=" {{ route('links.exportLink') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-1 col-md-12  @error('user_id') is-invalid @enderror">
                            <label class="form-label" for="user_id">{{ __('visit.supervisior_name') }}</label>
                            <select name="user_id" id="user_id" class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('users.selectClient') }}"
                                    data-ajax--cache="true"  >
                            </select>
                            @error('user_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    
                        <br>
                        <br>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary btn_filter">{{ __('links.search') }}</button>
                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">
                                {{ __('links.cancel') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

