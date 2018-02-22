<?php

declare(strict_types=1);

namespace Cortex\Auth\B2B2C2\Http\Controllers\Managerarea;

use Cortex\Auth\Models\Manager;
use Illuminate\Auth\Events\Registered;
use Cortex\Foundation\Http\Controllers\AbstractController;
use Cortex\Auth\B2B2C2\Http\Requests\Managerarea\RegistrationRequest;
use Cortex\Auth\B2B2C2\Http\Requests\Managerarea\RegistrationProcessRequest;

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
     * @param \Cortex\Auth\B2B2C2\Http\Requests\Managerarea\RegistrationRequest $request
     *
     * @return \Illuminate\View\View
     */
    public function form(RegistrationRequest $request)
    {
        return view('cortex/auth::managerarea.pages.registration');
    }

    /**
     * Process the registration form.
     *
     * @param \Cortex\Auth\B2B2C2\Http\Requests\Managerarea\RegistrationProcessRequest $request
     * @param \Cortex\Auth\Models\Manager                                        $manager
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function register(RegistrationProcessRequest $request, Manager $manager)
    {
        // Prepare registration data
        $data = $request->validated();

        $manager->fill($data)->save();

        // Fire the register success event
        event(new Registered($manager));

        // Send verification if required
        ! config('cortex.auth.emails.verification')
        || app('rinvex.auth.emailverification')->broker($this->getBroker())->sendVerificationLink(['email' => $data['email']]);

        // Auto-login registered manager
        auth()->guard($this->getGuard())->login($manager);

        // Registration completed successfully
        return intend([
            'intended' => route('managerarea.home'),
            'with' => ['success' => trans('cortex/auth::messages.register.success')],
        ]);
    }
}
