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
                <form id="filterForm" class="">
                    <div class="row">

                        <div class="mb-1 col-md-12 ">
                            <label class="form-label" for="user_id"> المشرفين </label>
                           <select class="form-control" name="user_filter" id="user_filter" >

                           <option> اختر </option>
                            @foreach ( \App\Models\User::role('mshrf')->get()  as $item )
                            <option value="{{ $item->id }}">

                                {{ $item->first_name . ' '  .  $item->last_name  }}
                            </option>
                            @endforeach
                           </select>
                        </div>

                        <div class="mb-1 col-md-12 ">
                            <label class="form-label" for="first_name">{{ __('users.first_name') }}</label>
                           <input class="form-control" name="first_name" id="first_name" />
                        </div>
                        <div class="mb-1 col-md-12 ">
                            <label class="form-label" for="mid_name">{{ __('users.mid_name') }}</label>
                           <input class="form-control" name="mid_name" id="mid_name" />
                        </div>
                        <div class="mb-1 col-md-12 ">
                            <label class="form-label" for="last_name">{{ __('users.last_name') }}</label>
                           <input class="form-control" name="last_name" id="last_name" />
                        </div>


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

