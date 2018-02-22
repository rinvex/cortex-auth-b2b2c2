<?php

declare(strict_types=1);

namespace Cortex\Auth\B2B2C2\Http\Requests\Frontarea;

use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\Exceptions\GenericException;

class RegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @throws \Cortex\Foundation\Exceptions\GenericException
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if (! config('cortex.auth.registration.enabled')) {
            throw new GenericException(trans('cortex/auth::messages.register.disabled'));
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
