<?php $assetsPath = asset('assets/admin') ?>


    <link rel="apple-touch-icon" href="{{ $assetsPath }}/images/favicon.png">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $assetsPath }}/images/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600;700;900&amp;display=swap" rel="stylesheet">
    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/vendors/css/vendors-rtl.min.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/vendors/css/extensions/toastr.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/colors.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/components.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/pages/dashboard-ecommerce.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/plugins/charts/chart-apex.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/plugins/extensions/ext-component-toastr.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/vendors/css/forms/select/select2.min.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css-rtl/custom-rtl.css">
    <link rel="stylesheet" type="text/css" href="{{ $assetsPath }}/css/custom.css">
    <!-- END: Custom CSS-->

    @stack('styles')

<!-- END: Head-->

<!-- BEGIN: Body-->

<body style="background-color: #27b3c2;">


<div class="container-fluid">
    {{-- <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div> --}}



            {{-- @include('flash::message')
            @include('admin.partials.errors') --}}

            @yield('content')

</div>
<!-- END: Content-->

{{-- <div class="sidenav-overlay"></div>
<div class="drag-target"></div> --}}

<!-- BEGIN: Footer-->



<!-- BEGIN: Vendor JS-->
<script src="{{ $assetsPath }}/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
{{--<script src="{{ $assetsPath }}/vendors/js/charts/apexcharts.min.js"></script>--}}
<script src="{{ $assetsPath }}/vendors/js/extensions/toastr.min.js"></script>
<script src="{{ $assetsPath }}/js/scripts/extensions/ext-component-toastr.min.js"></script>
<script src="{{ $assetsPath }}/vendors/js/tables/datatable/jquery.dataTables.min.js"></script>
<script src="{{ $assetsPath }}/vendors/js/tables/datatable/dataTables.bootstrap5.min.js"></script>
<script src="{{ $assetsPath }}/vendors/js/forms/select/select2.full.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ $assetsPath }}/js/core/app-menu.js"></script>
<script src="{{ $assetsPath }}/js/core/app.js"></script>
<!-- END: Theme JS-->


<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
        $('.ajax_select2').select2({
            placeholder: "{{ __('admin.select') }}",
            ajax: {
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {results: data};
                },
                cache: true
            }
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('body').on('click', '.delete_item', function (){
            var url= $(this).attr('data-url');
            $('#deleteForm').attr('action', url)
            $('#modalDelete').modal('show')
            return false;
        })

    })
</script>
@stack('scripts')
</body>
<!-- END: Body-->

</html>
