<?php

declare(strict_types=1);

namespace Cortex\Auth\B2B2C2\Http\Controllers\Frontarea;

use Cortex\Foundation\Http\Controllers\AbstractController;

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
     * Redirect to member registration.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        return intend([
            'url' => route('frontarea.register.tenant'),
        ]);
    }
}
