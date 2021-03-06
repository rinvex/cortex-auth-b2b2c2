<?php

declare(strict_types=1);

namespace Cortex\Auth\B2B2C2\Http\Controllers\Managerarea;

use Cortex\Foundation\Http\Controllers\AbstractController;

class RedirectionController extends AbstractController
{
    /**
     * Redirect to passwordreset.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function passwordreset()
    {
        return intend([
            'url' => route('frontarea.passwordreset.request'),
        ]);
    }

    /**
     * Redirect to homepage.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function verification()
    {
        return intend([
            'url' => route('frontarea.home'),
        ]);
    }
}
