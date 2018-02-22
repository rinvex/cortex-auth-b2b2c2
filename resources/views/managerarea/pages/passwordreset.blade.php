{{-- Master Layout --}}
@extends('cortex/foundation::managerarea.layouts.auth')

{{-- Page Title --}}
@section('title')
    {{ config('app.name') }} » {{ trans('cortex/auth::common.password_reset') }}
@endsection

{{-- Scripts --}}
@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\Auth\B2B2C2\Http\Requests\Managerarea\PasswordResetPostProcessRequest::class)->selector('#managerarea-passwordreset-form') !!}
@endpush

{{-- Main Content --}}
@section('content')

    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('frontarea.home') }}"><b>{{ config('app.name') }}</b></a>
        </div>

        <div class="login-box-body">
            <p class="login-box-msg">{{ trans('cortex/auth::common.account_reset_password') }}</p>

            {{ Form::open(['url' => route('managerarea.passwordreset.process'), 'id' => 'managerarea-passwordreset-form', 'role' => 'auth']) }}

                {{ Form::hidden('expiration', old('expiration', $expiration)) }}
                {{ Form::hidden('token', old('token', $token)) }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    {{ Form::email('email', old('email', $email), ['class' => 'form-control input-lg', 'placeholder' => trans('cortex/auth::common.email'), 'required' => 'required', 'readonly' => 'readonly']) }}

                    @if ($errors->has('email'))
                        <span class="help-block">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    {{ Form::password('password', ['class' => 'form-control input-lg', 'placeholder' => trans('cortex/auth::common.new_password'), 'required' => 'required', 'autofocus' => 'autofocus']) }}

                    @if ($errors->has('password'))
                        <span class="help-block">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    {{ Form::password('password_confirmation', ['class' => 'form-control input-lg', 'placeholder' => trans('cortex/auth::common.new_password_confirmation'), 'required' => 'required']) }}

                    @if ($errors->has('password_confirmation'))
                        <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                    @endif
                </div>

                {{ Form::button('<i class="fa fa-envelope"></i> '.trans('cortex/auth::common.password_reset'), ['class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit']) }}

            {{ Form::close() }}

            {{ Html::link(route('managerarea.login'), trans('cortex/auth::common.account_login')) }}

        </div>

    </div>

@endsection
