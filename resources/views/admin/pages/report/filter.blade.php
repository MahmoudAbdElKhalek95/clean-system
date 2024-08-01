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
                        <div class="mb-1 col-md-12"  >
                            <div class="form-group row">
                                <label for="time" class="col-sm-2 col-form-label">   من الوقت </label>
                                <div class="col-sm-10">
                                    <input type="time" name="from" id="from" class="form-control"   value="">
                                </div>
                            </div>
                        </div>
                        <div class="mb-1 col-md-12"  >
                            <div class="form-group row ">
                                <label for="time" class="col-sm-2 col-form-label">   الي الوقت </label>
                                <div class="col-sm-10">
                                    <input type="time"  name="to"  id="to" class="form-control"   value="">
                                </div>
                            </div>
                        </div>
                        <div class="mb-1 col-md-12  @error('category_id') is-invalid @enderror">
                            <label style="    float: inline-start;" class="form-label" for="category_id">{{ __('links.category') }}</label>
                            <select name="category_id[]" id="category_id" class="form-control ajax_select2 extra_field"
                            data-ajax--url="{{ route('categories.select') }}"
                            data-ajax--cache="true"  multiple >
                            </select>
                        </div>
                        <div class="mb-1 col-md-12  @error('project_id') is-invalid @enderror">
                            <label style="    float: inline-start;" class="form-label" for="project_id">{{ __('links.project') }}</label>
                            <select name="project_id" id="project_id" class="form-control ajax_select2 extra_field" data-ajax--cache="true"   >
                        </select>
                        </div>
                        <div class="mb-1 col-md-12  @error('project_id') is-invalid @enderror">
                            <label style="    float: inline-start;" class="form-label" for="">{{ __('links.date') }}</label>
                            <select class="form-control " id="filter_date">
                                <option value="day">يومى</option>
                                <option value="week">اسبوعى</option>
                                <option value="month">شهرى</option>
                                <option value="year">سنوى</option>
                            </select>
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

