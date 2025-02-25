@extends('layouts.template')

@section('main')
    <h3 class="text-center my-5">403 | <span class="text-black-50">{{ $exception->getMessage() ?: 'Forbidden' }}</span></h3>
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
    </script>
@endsection
