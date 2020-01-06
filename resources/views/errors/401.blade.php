@extends('errors::minimal')


{{--@section('code', '401')--}}
{{--@section('message', __('Unauthorized'))--}}


@extends('layouts.template')
{{--@section('title', __('Unauthorized'))--}}
{{--@section('code', '401')--}}
{{--@section('message', __('Unauthorized'))--}}
@section('main')
    <h3 class="text-center my-5">401 | <span class="text-black-50">{{ $exception->getMessage() ?: 'Unauthorized' }}</span></h3>
{{--    <p class="text-center my-5">--}}
    <p class="text-center my-5">
        @include('errors.buttons')
    </p>
@endsection

@section('script_after')
    <script>
        // Go back to the previous page
        $('#back').click(function () {
            window.history.back();
        });
        // Remove the right navigation
        $('nav .ml-auto').hide();
    </script>
@endsection
