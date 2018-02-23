{{-- Master Layout --}}
@extends('cortex/foundation::managerarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ $currentTenant->name }} » {{ trans('cortex/foundation::common.managerarea') }} » {{ trans('cortex/auth::common.members') }} » {{ $member->username }} » {{ trans('cortex/auth::common.attributes') }}
@endsection

@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\Auth\B2B2C2\Http\Requests\Managerarea\MemberAttributesFormRequest::class)->selector("#managerarea-members-create-form, #managerarea-members-{$member->getKey()}-update-attributes-form") !!}
@endpush

{{-- Main Content --}}
@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            <h1>{{ Breadcrumbs::render() }}</h1>
        </section>

        {{-- Main content --}}
        <section class="content">

            <div class="nav-tabs-custom">
                {!! Menu::render('managerarea.members.tabs', 'nav-tab') !!}

                <div class="tab-content">

                    <div class="tab-pane active" id="attributes-tab">
                        @attributes($member)
                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection
