{{-- Master Layout --}}
@extends('cortex/foundation::frontarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ config('app.name') }} » {{ trans('cortex/auth::common.register') }}
@endsection

{{-- Scripts --}}
@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\Auth\B2B2C2\Http\Requests\Frontarea\TenantRegistrationProcessRequest::class)->selector("#frontarea-tenant-registration-form") !!}

    <script>
        window.countries = {!! $countries !!};
        window.selectedCountry = '{{ old('tenant.country_code') }}';
    </script>
@endpush

@section('body-attributes')class="auth-page"@endsection

{{-- Main Content --}}
@section('content')

    <div class="container">

        <div class="row">

            <div class="col-md-6 col-md-offset-3">

                <section class="auth-form">

                    {{ Form::open(['url' => route('frontarea.register.tenant.process'), 'id' => 'frontarea-tenant-registration-form', 'role' => 'auth']) }}

                        <div class="centered"><strong>{{ trans('cortex/auth::common.account_register') }}</strong></div>

                        <div id="accordion" class="wizard">
                            <div class="panel wizard-step">
                                <div>
                                    <h4 class="wizard-step-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">{{ trans('cortex/auth::common.owner_account') }}</a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="collapse in">
                                    <div class="wizard-step-body">

                                        <div class="form-group has-feedback{{ $errors->has('owner.full_name') ? ' has-error' : '' }}">
                                            {{ Form::text('owner[full_name]', old('owner.full_name'), ['class' => 'form-control input-lg', 'placeholder' => trans('cortex/auth::common.full_name'), 'required' => 'required', 'autofocus' => 'autofocus']) }}

                                            @if ($errors->has('owner.full_name'))
                                                <span class="help-block">{{ $errors->first('owner.full_name') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('owner.username') ? ' has-error' : '' }}">
                                            {{ Form::text('owner[username]', old('owner.username'), ['class' => 'form-control input-lg', 'placeholder' => trans('cortex/auth::common.username'), 'required' => 'required']) }}

                                            @if ($errors->has('owner.username'))
                                                <span class="help-block">{{ $errors->first('owner.username') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('owner.email') ? ' has-error' : '' }}">
                                            {{ Form::email('owner[email]', old('owner.email'), ['class' => 'form-control input-lg', 'placeholder' => trans('cortex/auth::common.email'), 'required' => 'required']) }}

                                            @if ($errors->has('owner.email'))
                                                <span class="help-block">{{ $errors->first('owner.email') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('owner.password') ? ' has-error' : '' }}">
                                            {{ Form::password('owner[password]', ['class' => 'form-control input-lg', 'placeholder' => trans('cortex/auth::common.password'), 'required' => 'required']) }}

                                            @if ($errors->has('owner.password'))
                                                <span class="help-block">{{ $errors->first('owner.password') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('owner.password_confirmation') ? ' has-error' : '' }}">
                                            {{ Form::password('owner[password_confirmation]', ['class' => 'form-control input-lg', 'placeholder' => trans('cortex/auth::common.password_confirmation'), 'required' => 'required']) }}

                                            @if ($errors->has('owner.password_confirmation'))
                                                <span class="help-block">{{ $errors->first('owner.password_confirmation') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="panel wizard-step">
                                <div role="tab" id="headingTwo">
                                    <h4 class="wizard-step-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">{{ trans('cortex/auth::common.tenant_details') }}</a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="wizard-step-body">

                                        <div class="form-group has-feedback{{ $errors->has('tenant.title') ? ' has-error' : '' }}">
                                            {{ Form::text('tenant[title]', old('tenant.title'), ['class' => 'form-control input-lg', 'placeholder' => trans('cortex/auth::common.title'), 'data-slugify' => '[name="tenant\[name\]"]', 'required' => 'required']) }}

                                            @if ($errors->has('tenant.title'))
                                                <span class="help-block">{{ $errors->first('tenant.title') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('tenant.name') ? ' has-error' : '' }}">
                                            {{ Form::text('tenant[name]', old('tenant.name'), ['class' => 'form-control input-lg', 'placeholder' => trans('cortex/auth::common.name'), 'required' => 'required']) }}

                                            @if ($errors->has('tenant.name'))
                                                <span class="help-block">{{ $errors->first('tenant.name') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('tenant.email') ? ' has-error' : '' }}">
                                            {{ Form::text('tenant[email]', old('tenant.email'), ['class' => 'form-control input-lg', 'placeholder' => trans('cortex/auth::common.email'), 'required' => 'required']) }}

                                            @if ($errors->has('tenant.email'))
                                                <span class="help-block">{{ $errors->first('tenant.email') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('tenant.country_code') ? ' has-error' : '' }}">
                                            {{ Form::hidden('tenant[country_code]', '') }}
                                            {{ Form::select('tenant[country_code]', [], null, ['class' => 'form-control select2 input-lg', 'placeholder' => trans('cortex/auth::common.select_country'), 'required' => 'required', 'data-allow-clear' => 'true', 'data-width' => '100%']) }}

                                            @if ($errors->has('tenant.country_code'))
                                                <span class="help-block">{{ $errors->first('tenant.country_code') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group{{ $errors->has('tenant.language_code') ? ' has-error' : '' }}">
                                            {{ Form::hidden('tenant[language_code]', '') }}
                                            {{ Form::select('tenant[language_code]', $languages, null, ['class' => 'form-control select2', 'placeholder' => trans('cortex/auth::common.select_language'), 'data-allow-clear' => 'true', 'data-width' => '100%']) }}

                                            @if ($errors->has('tenant.language_code'))
                                                <span class="help-block">{{ $errors->first('tenant.language_code') }}</span>
                                            @endif
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        {{ Form::button('<i class="fa fa-user-plus"></i> '.trans('cortex/auth::common.register'), ['class' => 'btn btn-lg btn-primary btn-block', 'type' => 'submit']) }}

                        <div>
                            {{ Html::link(route('frontarea.login'), trans('cortex/auth::common.account_login')) }}
                            {{ trans('cortex/foundation::common.or') }}
                            {{ Html::link(route('frontarea.passwordreset.request'), trans('cortex/auth::common.password_reset')) }}
                        </div>

                    {{ Form::close() }}

                </section>

            </div>

        </div>

    </div>

@endsection
