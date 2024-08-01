@extends('admin.layouts.master')
@section('title')
    <title>{{ config('app.name') }} | {{ __('users.plural') }}</title>
@endsection
@section('content')
    <form method='post' enctype="multipart/form-data"  id="jquery-val-form"
          action="{{ isset($item) ? route('users.update', $item->id) : route('users.store') }}">
        <input type="hidden" name="_method" value="{{ isset($item) ? 'PUT' : 'POST' }}">
        @csrf
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h1 class="bold mb-0 mt-1 text-dark">
                            <i data-feather="box" class="font-medium-2"></i>
                            <span>{{ isset($item) ? __('users.actions.edit') : __('users.actions.create') }}</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block ">
                <div class="mb-1 breadcrumb-right">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary me-1 waves-effect">
                            <i data-feather="save"></i>
                            <span class="active-sorting text-primary">{{ __('users.actions.save') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-1 col-md-4  @error('first_name') is-invalid @enderror">
                            <label class="form-label">{{ __('users.first_name') }}</label>
                            <input class="form-control" name="first_name" type="text" value="{{ $item->first_name ?? old('first_name') }}">
                            @error('first_name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('mid_name') is-invalid @enderror">
                            <label class="form-label">{{ __('users.mid_name') }}</label>
                            <input class="form-control" name="mid_name" type="text" value="{{ $item->mid_name ?? old('mid_name') }}">
                            @error('mid_name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('last_name') is-invalid @enderror">
                            <label class="form-label">{{ __('users.last_name') }}</label>
                            <input class="form-control" name="last_name" type="text" value="{{ $item->last_name ?? old('last_name') }}">
                            @error('last_name')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                         <div class="mb-1 col-md-4  @error('target_type_id') is-invalid @enderror target_type_section" >
                            <label class="form-label" for="target_type_id">{{ __('archives.targettype') }}</label>
                            <select name="target_type_id" id="target_type_id" class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('target_types.select') }}"
                                    data-ajax--cache="true"   >
                                @isset($item->targettype)
                                    <option value="{{ $item->targettype->id }}" selected>{{ $item->targettype->name }}</option>
                                @endisset
                            </select>
                            @error('target_type_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('target_amount') is-invalid @enderror">
                            <label class="form-label">{{ __('users.target_amount') }}</label>
                            <input class="form-control" name="target_amount" type="number" value="{{ $item->target_amount ?? old('target_amount') }}">
                            @error('target_amount')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('phone') is-invalid @enderror">
                            <label class="form-label">{{ __('users.phone') }}</label>
                            <input class="form-control" name="phone" type="text" value="{{ $item->phone ?? old('phone') }}">
                            @error('phone')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('type') is-invalid @enderror">
                            <label class="form-label" for="type">{{ __('users.type') }}</label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="1" @isset($item) {{ $item->type == 1 ? 'selected' : '' }} @endisset>{{ __('users.types.1') }}</option>
                                <option value="2" @isset($item) {{ $item->type == 2 ? 'selected' : '' }} @endisset>{{ __('users.types.2') }}</option>
                                <option value="3" @isset($item) {{ $item->type == 3 ? 'selected' : '' }} @endisset>{{ __('users.types.3') }}</option>
                            </select>
                            @error('type')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('vip') is-invalid @enderror">
                            <label class="form-label" for="vip">{{ __('users.vip') }}</label>
                            <select name="vip" id="vip" class="form-control" required>
                                <option value="0" @isset($item) {{ $item->vip == 0 ? 'selected' : '' }} @endisset>{{ __('users.vips.0') }}</option>
                                <option value="1" @isset($item) {{ $item->vip == 1 ? 'selected' : '' }} @endisset>{{ __('users.vips.1') }}</option>
                            </select>
                            @error('vip')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4 users @error('user_id') is-invalid @enderror" >
                            <label class="form-label" for="user_id">{{ __('paths.users') }}</label>
                            <select name="user_id[]" id="user_id" class="form-control ajax_select2 extra_field"
                                    data-ajax--url="{{ route('users.select') }}"
                                    data-ajax--cache="true"   multiple>
                                @isset($item)
                                    @foreach ($users as $user)
                                    <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                                    @endforeach
                                @endisset
                            </select>
                            @error('user_id')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('role') is-invalid @enderror">
                            <label class="form-label">{{ __('users.role') }}</label>
                            <select class="form-control input" name="role_id">
                                <option value="">{{ __('users.select') }}</option>
                                @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                    <option value="{{ $role->id }}" {{ in_array($role->id, $userRoles) ? 'selected' : '' }}>{{ $role->display_name }}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('code') is-invalid @enderror">
                            <label class="form-label">{{ __('users.code') }}</label>
                            <input class="form-control" name="code" type="text" value="{{ $item->code ?? old('code') }}">
                            @error('code')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1 col-md-4  @error('password') is-invalid @enderror">
                            <label class="form-label">{{ __('users.password') }}</label>
                            <input class="form-control" name="password" type="password" value="">
                            @error('password')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">

                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@push('scripts')
    <script>
    $(window).on('load', function() {
        targetType();
    });
         $(function() {
            $('#type').change(function () {
                targetType();
            });
        });

        function targetType() {
                var type = $("#type").val();
                if(type==2){
                    $('.users').show(1000);
                }else{
                    $('.users').hide(1000);
                }
            }

    </script>
@endpush
