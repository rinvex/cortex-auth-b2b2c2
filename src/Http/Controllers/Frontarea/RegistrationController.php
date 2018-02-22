<?php

declare(strict_types=1);

namespace Cortex\Auth\B2B2C2\Http\Controllers\Frontarea;

use Cortex\Auth\Models\Manager;
use Cortex\Tenants\Models\Tenant;
use Illuminate\Auth\Events\Registered;
use Cortex\Foundation\Http\Controllers\AbstractController;
use Cortex\Auth\B2B2C2\Http\Requests\Frontarea\RegistrationRequest;
use Cortex\Auth\B2B2C2\Http\Requests\Frontarea\RegistrationProcessRequest;

class RegistrationController extends AbstractController
{
    /**
     * Create a new registration controller instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware($this->getGuestMiddleware())->except($this->middlewareWhitelist);
    }

    /**
     * Show the registration form.
     *
     * @param \Cortex\Auth\B2B2C2\Http\Requests\Frontarea\RegistrationRequest $request
     *
     * @return \Illuminate\View\View
     */
    public function form(RegistrationRequest $request)
    {
        $countries = collect(countries())->map(function ($country, $code) {
            return [
                'id' => $code,
                'text' => $country['name'],
                'emoji' => $country['emoji'],
            ];
        })->values();
        $languages = collect(languages())->pluck('name', 'iso_639_1');

        return view('cortex/auth::frontarea.pages.registration', compact('countries', 'languages'));
    }

    /**
     * Process the registration form.
     *
     * @param \Cortex\Auth\B2B2C2\Http\Requests\Frontarea\RegistrationProcessRequest $request
     * @param \Cortex\Auth\Models\Manager                                            $manager
     * @param \Cortex\Tenants\Models\Tenant                                          $tenant
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function register(RegistrationProcessRequest $request, Manager $manager, Tenant $tenant)
    {
        // Prepare registration data
        $managerInput = $request->get('manager');

        $manager->fill($managerInput)->save();

        // Save tenant
        $tenantInput = $request->get('tenant') + [
            'user_id' => $manager->getKey(),
            'user_type' => $manager->getMorphClass(),
        ];
        $tenant->fill($tenantInput)->save();
        $manager->attachTenants($tenant);
        $manager->assign('owner');

        // Fire the register success event
        event(new Registered($manager));

        // Send verification if required
        ! config('cortex.auth.emails.verification')
        || app('rinvex.auth.emailverification')->broker($this->getBroker())->sendVerificationLink(['email' => $manager->email]);

        // Registration completed successfully
        return intend([
            'intended' => route('managerarea.home'),
            'with' => ['success' => trans('cortex/auth::messages.register.success')],
        ]);
    }
}
