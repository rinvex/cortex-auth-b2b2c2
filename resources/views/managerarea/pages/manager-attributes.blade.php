{{-- Master Layout --}}
@extends('cortex/foundation::managerarea.layouts.default')

{{-- Page Title --}}
@section('title')
    {{ $currentTenant->title }} » {{ trans('cortex/foundation::common.managerarea') }} » {{ trans('cortex/auth::common.managers') }} » {{ $manager->username }} » {{ trans('cortex/auth::common.attributes') }}
@endsection

@push('inline-scripts')
    {!! JsValidator::formRequest(Cortex\Auth\B2B2C2\Http\Requests\Managerarea\ManagerAttributesFormRequest::class)->selector("#managerarea-managers-create-form, #managerarea-managers-{$manager->getRouteKey()}-update-attributes-form") !!}
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
                {!! Menu::render('managerarea.managers.tabs', 'nav-tab') !!}

                <div class="tab-content">

                    <div class="tab-pane active" id="attributes-tab">
                        @attributes($manager)
                    </div>

                </div>

            </div>

        </section>

    </div>

@endsection
