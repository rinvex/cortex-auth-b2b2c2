<?php

declare(strict_types=1);

namespace Cortex\Auth\B2B2C2\Http\Controllers\Frontarea;

use Cortex\Auth\Models\Manager;
use Cortex\Tenants\Models\Tenant;
use Illuminate\Auth\Events\Registered;
use Cortex\Foundation\Http\Controllers\AbstractController;
use Cortex\Auth\B2B2C2\Http\Requests\Frontarea\TenantRegistrationRequest;
use Cortex\Auth\B2B2C2\Http\Requests\Frontarea\TenantRegistrationProcessRequest;

class TenantRegistrationController extends AbstractController
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
     * @param \Cortex\Auth\B2B2C2\Http\Requests\Frontarea\TenantRegistrationRequest $request
     *
     * @return \Illuminate\View\View
     */
    public function form(TenantRegistrationRequest $request)
    {
        return view('cortex/auth::frontarea.pages.registration');
    }

    /**
     * Process the registration form.
     *
     * @param \Cortex\Auth\B2B2C2\Http\Requests\Frontarea\TenantRegistrationProcessRequest $request
     * @param \Cortex\Auth\Models\Manager                                                    $manager
     * @param \Cortex\Tenants\Models\Tenant                                                $tenant
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function register(TenantRegistrationProcessRequest $request, Manager $manager, Tenant $tenant)
    {
        // Prepare registration data
        $managerData = $request->validated()['user'];
        $tenantData = $request->validated()['tenant'];

        $manager->fill($managerData)->save();

        // Save tenant
        $tenantData['owner_id'] = $manager->getKey();
        $tenantData['owner_type'] = $manager->getMorphClass();
        $tenant->fill($tenantData)->save();
        $manager->attachTenants($tenant);
        $manager->assign('owner');

        // Fire the register success event
        event(new Registered($manager));

        // Send verification if required
        ! config('cortex.auth.emails.verification')
        || app('rinvex.auth.emailverification')->broker($this->getBroker())->sendVerificationLink(['email' => $manager->email]);

        // Auto-login registered manager
        auth()->guard($this->getGuard())->login($manager);

        // Registration completed successfully
        return intend([
            'intended' => route('managerarea.home', ['subdomain' => $tenant->name]),
            'with' => ['success' => trans('cortex/auth::messages.register.success')],
        ]);
    }
}
