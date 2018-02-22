<?php

declare(strict_types=1);

namespace Cortex\Auth\B2B2C2\Http\Requests\Tenantarea;

use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\Exceptions\GenericException;

class AccountTwoFactorPhoneRequest extends FormRequest
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
        $user = $this->user($this->route('guard'));

        if (! $user->phone || ! $user->phone_verified) {
            throw new GenericException(trans('cortex/auth::messages.account.'.(! $user->phone ? 'phone_field_required' : 'phone_verification_required')), route('tenantarea.account.settings'));
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
