@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('whatsapps.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('whatsapps.update', $item->id) : route('whatsapps.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('whatsapps.actions.edit') : __('whatsapps.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('whatsapps.actions.save') }}</span>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-success me-1 waves-effect" id="addRow">
                            <i data-feather="plus"></i>
                            <span class="active-sorting text-success">{{ __('whatsapps.actions.add_row') }}</span>
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
                            <select name="category_id"  class="form-control "  required >
                                    <option value="">اختر</option>

                                     @foreach ( \App\Models\Category::get() as $category )
                                         <option value="{{$category->id}}"> {{$category->name }} </option>
                                     @endforeach

                            </select>
                            @error('category_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('type') is-invalid @enderror">
                            <label class="form-label" for="type">{{ __('projects.type') }}</label>
                            <select name="type"  class="form-control percent_type"  required >
                                    <option value="zero">صفر</option>
                                    <option value="percent">نسبة</option>
                            </select>
                            @error('type')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('percent') is-invalid @enderror" id="percent_1" style="display: none">
                            <label class="form-label">{{ __('whatsapps.percent') }}</label>
                            <input class="form-control" name="percent[]" type="text" value="{{ $item->percent ?? old('percent') }}" >
                            @error('percent')
                            <span class="error">{{ $percent }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('percent2') is-invalid @enderror"  id="percent_2" style="display: none">
                            <label class="form-label">{{ __('whatsapps.percent2') }}</label>
                            <input class="form-control" name="percent2[]" type="text" value="{{ $item->percent2 ?? old('percent2')??100 }}">
                            @error('percent2')
                            <span class="error">{{ $percent2 }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('message') is-invalid @enderror">
                            <label class="form-label" for="message">{{ __('whatsapps.message') }}</label>
                            <select name="message"  class="form-control "
                                     required >
                                     <option value="">اختر</option>
                                     @foreach ( \App\Models\SendingTemplate::get() as $item )
                                         <option value="{{$item->id}}"> {{$item->template_name }} </option>
                                     @endforeach

                            </select>
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
    $(window).on('load', function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('body').on('change', '.percent_type', function (){
            var type= $(this).val();
            if(type=='percent'){
                $("#percent_1").show();
                $("#percent_2").show();
                return;
            }else{
                $("#percent_1").hide();
                $("#percent_2").hide();
                return;
            }
            return;
        });
    });
    </script>
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
                        <div class="mb-1 col-md-4  @error('category_id') is-invalid @enderror">
                            <label class="form-label" for="category_id">{{ __('projects.category') }}</label>
                            <select name="category_id"  class="form-control "  required >
                                    <option value="">اختر</option>
                                     @foreach ( \App\Models\Category::get() as $category )
                                         <option value="{{$category->id}}"> {{$category->name }} </option>
                                     @endforeach
                            </select>
                            @error('category_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('percent') is-invalid @enderror">
                            <label class="form-label">{{ __('whatsapps.percent') }}</label>
                            <input class="form-control" name="percent[]" type="text" value="{{ $item->percent ?? old('percent') }}" required>
                            @error('percent')
                            <span class="error">{{ $percent }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('percent2') is-invalid @enderror">
                            <label class="form-label">{{ __('whatsapps.percent2') }}</label>
                            <input class="form-control" name="percent2[]" type="text" value="{{ $item->percent2 ?? old('percent2')??100 }}">
                            @error('percent2')
                            <span class="error">{{ $percent2 }}</span>
                            @enderror
                        </div>

                        <div class="mb-1 col-md-4  @error('message') is-invalid @enderror">
                            <label class="form-label" for="message">{{ __('whatsapps.message') }}</label>
                            <select name="message[]"  class="form-control "
                                     required >
                                     <option value="">اختر</option>
                                     @foreach ( \App\Models\SendingTemplate::get() as $item )
                                         <option value="{{$item->id}}"> {{$item->template_name }} </option>
                                     @endforeach

                            </select>
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
