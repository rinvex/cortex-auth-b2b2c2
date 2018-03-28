{{-- Master Layout --}}
@extends('cortex/foundation::tenantarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ $currentTenant->title }} » {{ trans('cortex/auth::common.account_attributes') }}
@endsection

@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\Auth\B2B2C2\Http\Requests\Tenantarea\AccountAttributesRequest::class)->selector('#tenantarea-account-attributes-form') !!}
@endpush

{{-- Main Content --}}
@section('content')

    <div class="container">
        <div class="row profile">
            <div class="col-md-3">
                @include('cortex/auth::tenantarea.partials.sidebar')
            </div>
            <div class="col-md-9">
                <div class="profile-content">

                    {{ Form::model($currentUser, ['url' => route('tenantarea.account.attributes.update'), 'id' => 'tenantarea-account-attributes-form']) }}

                        @attributes($currentUser)

                        @if($currentUser->getEntityAttributes()->isNotEmpty())
                            <div class="row">
                                <div class="col-md-12 text-center profile-buttons">
                                    {{ Form::button('<i class="fa fa-save"></i> '.trans('cortex/auth::common.update_attributes'), ['class' => 'btn btn-primary btn-flat', 'type' => 'submit']) }}
                                </div>
                            </div>
                        @endif

                    {{ Form::close() }}

                </div>
            </div>
        </div>
    </div>

@endsection
