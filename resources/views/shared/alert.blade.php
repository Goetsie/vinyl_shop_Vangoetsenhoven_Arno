{{-- session key = success --}}
{{--Feedback message if form is submitted--}}
{{--Show the alert if the session has a variable 'success'--}}
@if (session()->has('success'))
    <div class="alert alert-success alert-dismissable">
{{--        <button type="button" class="close" data-dismiss="alert" aria-label="Close">--}}
{{--            <span aria-hidden="true">×</span>--}}
{{--        </button>--}}
        {{--Get the value of the session variable 'success' and show it inside the alert--}}
        <p>{!! session()->get('success') !!}</p>
    </div>
@endif

{{-- session key = danger --}}
@if (session()->has('danger'))
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <p>{!! session()->get('danger') !!}</p>
    </div>
@endif
