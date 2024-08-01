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
                <form id="filterForm" class="" action=" {{ route('projects.exportProject') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-1 col-md-12"  >
                            <div class="form-group row">
                                <label for="from" class="col-sm-2 col-form-label"> القسم </label>
                                <div class="col-sm-10">
                                <select  id="category_id" name="category_id" class="form-control ajax_select2 extra_field"
                                                    data-ajax--url="{{ route('categories.select') }}"
                                                    data-ajax--cache="true"   >
                                </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="mb-1 col-md-12"  >
                            <div class="form-group row">
                                <label for="from" class="col-sm-2 col-form-label">   النسبة من </label>
                                <div class="col-sm-10">
                                    <input type="number" name="from" id="from" class="form-control"   value="">
                                </div>
                            </div>
                        </div>
                        <div class="mb-1 col-md-12"  >
                            <div class="form-group row ">
                                <label for="to" class="col-sm-2 col-form-label">   النسبة الى  </label>
                                <div class="col-sm-10">
                                    <input type="number"  name="to"  id="to" class="form-control"   value="">
                                </div>
                            </div>
                        </div>
                        <div class="mb-1 col-md-12"  >
                            <div class="form-group row ">
                                <label for="to" class="col-sm-2 col-form-label">   تاريخ اخر عملية   </label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="last_operation" id="last_operation">
                                        <option >اختر</option>
                                        <option value="1">قبل يوم</option>
                                        <option value="2">قبل يومين</option>
                                        <option value="3">قبل ثلاثة ايام</option>
                                        <option value="0">اكثر من ثلاثة ايام</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-1 text-right" style="margin-bottom: 20px">

                            <button type="submit" class="btn btn-success "> <i data-feather='file'></i>  {{ __('projects.export') }}</button>
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

