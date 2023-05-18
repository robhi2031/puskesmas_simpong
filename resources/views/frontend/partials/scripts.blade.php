<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(used by all pages)-->
@foreach ($data['js'] as $dt)
    <script src="{{ asset($dt) }}"></script>
@endforeach
<!--end::Global Javascript Bundle-->
<!--end::Javascript-->