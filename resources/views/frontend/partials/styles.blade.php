<!--begin::Global Stylesheets Bundle(used by all pages)-->
@foreach ($data['css'] as $dt)
    <link rel="stylesheet" href="{{ asset($dt) }}">
@endforeach
<!--end::Global Stylesheets Bundle-->
<!-- Base Route JS -->
<script src="{{ asset('dist/js/base_route.js') }}"></script>