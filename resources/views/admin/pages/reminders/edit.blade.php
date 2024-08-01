@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('reminders.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('reminders.update', $item->id) : route('reminders.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('reminders.actions.edit') : __('reminders.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('reminders.actions.save') }}</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success me-1 waves-effect" id="addRow">
                            <i data-feather="plus"></i>
                            <span class="active-sorting text-success">{{ __('reminders.actions.add_row') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-1 col-md-4  @error('category_id') is-invalid @enderror">
                            <label class="form-label" for="category_id">{{ __('projects.category') }}</label>
                            <select name="category_id"  class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('categories.select') }}"
                                    data-ajax--cache="true"  required >
                                @isset($item->category)
                                    <option value="{{ $item->category->id }}" selected>{{ $item->category->name }}</option>
                                @endisset
                            </select>
                            @error('category_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('day_number') is-invalid @enderror">
                            <label class="form-label">{{ __('reminders.day_number') }}</label>
                            <input class="form-control" name="day_number" type="number" value="{{ $item->day_number ?? old('day_number') }}" required>
                            @error('day_number')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                         <div class="mb-1 col-md-4  @error('phone_id') is-invalid @enderror">
                            <label class="form-label" for="phone_id">{{ __('projects.phone') }}</label>
                            <select name="phone_id"  class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('whatsapp_phones.select') }}"
                                    data-ajax--cache="true"  required  >
                                @isset($item->phone)
                                    <option value="{{ $item->phone->id }}" selected>{{ $item->phone->name }}</option>
                                @endisset
                            </select>
                            @error('phone_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-12  @error('message') is-invalid @enderror">
                            <label class="form-label">{{ __('reminders.message') }}</label>
                            <textarea class="form-control" name="message" placeholder="وصل المشروع { project_name } الى {day_number} بفضل تبرعاتكم رابط المشروع {project_link}"  required>{{ $item->message ?? old('message') }}</textarea>
                            @error('message')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row new_row">

                    </div>
                </div>
            </div>
        </div>
    </form>
@stop
@push('scripts')
<script>
        // $(function() {
            $('.remove_row').click(function() {
                console.log('remove');
                $(this).parent().remove();
            });
        // });
        $(function() {
            $('#addRow').click(function () {
                var html=`
                 <div class="row">
                    <hr>
                    <div class="mb-1 col-md-4  @error('day_number') is-invalid @enderror">
                        <label class="form-label">{{ __('reminders.day_number') }}</label>
                        <input class="form-control" name="day_number[]" type="text" value="{{ $item->day_number ?? old('day_number') }}" required>
                        @error('day_number')
                        <span class="error">{{ $day_number }}</span>
                        @enderror
                        </div>
                        <div class="mb-1 col-md-3  @error('phone_id') is-invalid @enderror">
                            <label class="form-label" for="phone_id">{{ __('projects.phone') }}</label>
                            <select name="phone_id[]"  class="form-control  "
                                      required  >
                                @foreach($phones as $phone)
                                    <option value="{{ $phone->id }}" selected>{{ $phone->name }}</option>
                                @endforeach
                            </select>
                            @error('phone_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4 text-right">
                            <button class="btn btn-sm btn-outline-danger me-1 waves-effect remove_row"   type="button" style="float:left" >X</button>
                        </div>
                        <div class="mb-1 col-md-12  @error('message') is-invalid @enderror">
                            <label class="form-label">{{ __('reminders.message') }}</label>
                            <textarea class="form-control" name="message[]" placeholder="وصل المشروع { project_name } الى {day_number} بفضل تبرعاتكم رابط المشروع {project_link}"  required>{{ $item->message ?? old('message') }}</textarea>
                            @error('message')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>`;
                    $(".new_row").append(html)
            });
        });
</script>
@endpush
