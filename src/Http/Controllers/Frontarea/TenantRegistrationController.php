<?php

declare(strict_types=1);

namespace Cortex\Auth\B2B2C2\Http\Controllers\Frontarea;

use Cortex\Auth\Models\Manager;
use Cortex\Tenants\Models\Tenant;
use Illuminate\Auth\Events\Registered;
use Cortex\Auth\B2B2C2\Http\Requests\Frontarea\TenantRegistrationRequest;
use Cortex\Auth\B2B2C2\Http\Requests\Frontarea\TenantRegistrationProcessRequest;

class TenantRegistrationController extends RegistrationController
{
    /**
     * Show the registration form.
     *
     * @param \Cortex\Auth\B2B2C2\Http\Requests\Frontarea\TenantRegistrationRequest $request
     *
     * @return \Illuminate\View\View
     */
    public function form(TenantRegistrationRequest $request)
    {
        $countries = collect(countries())->map(function ($country, $code) {
            return [
                'id' => $code,
                'text' => $country['name'],
                'emoji' => $country['emoji'],
            ];
        })->values();
        $languages = collect(languages())->pluck('name', 'iso_639_1');

        return view('cortex/auth::frontarea.pages.registration-tenant', compact('countries', 'languages'));
    }

    /**
     * Process the registration form.
     *
     * @param \Cortex\Auth\B2B2C2\Http\Requests\Frontarea\TenantRegistrationProcessRequest $request
     * @param \Cortex\Auth\Models\Manager                                                  $owner
     * @param \Cortex\Tenants\Models\Tenant                                                $tenant
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function register(TenantRegistrationProcessRequest $request, Manager $owner, Tenant $tenant)
    {
        // Prepare registration data
        $ownerData = $request->validated()['owner'];
        $tenantData = $request->validated()['tenant'];

        $owner->fill($ownerData)->save();

        // Save tenant
        $tenantData['owner_id'] = $owner->getKey();
        $tenantData['owner_type'] = $owner->getMorphClass();
        $tenant->fill($tenantData)->save();
        $owner->attachTenants($tenant);
        $owner->assign('owner');

        // Fire the register success event
        event(new Registered($owner));

        // Send verification if required
        ! config('cortex.auth.emails.verification')
        || app('rinvex.auth.emailverification')->broker($this->getEmailVerificationBroker())->sendVerificationLink(['email' => $owner->email]);

        // Auto-login registered owner
        auth()->guard($this->getGuard())->login($owner);

        // Registration completed successfully
        return intend([
            'intended' => route('managerarea.home', ['subdomain' => $tenant->name]),
            'with' => ['success' => trans('cortex/auth::messages.register.success')],
        ]);
    }
}
