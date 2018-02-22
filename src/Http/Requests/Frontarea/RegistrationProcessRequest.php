<?php

declare(strict_types=1);

namespace Cortex\Auth\B2B2C2\Http\Requests\Frontarea;

class RegistrationProcessRequest extends RegistrationRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $data = $this->all();

        $role = app('cortex.auth.role')->where('slug', 'manager')->first();
        $data['manager']['is_active'] = ! config('cortex.auth.registration.moderated');
        ! $role || $data['manager']['roles'] = [$role->getKey()];

        $this->replace($data);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $managerRules = app('cortex.auth.manager')->getRules();
        $managerRules['password'] = 'required|confirmed|min:'.config('cortex.auth.password_min_chars');
        $managerRules = array_combine(
            array_map(function ($key) {
                return 'manager.'.$key;
            }, array_keys($managerRules)), $managerRules
        );

        $tenantRules = app('rinvex.tenants.tenant')->getRules();
        $tenantRules = array_combine(
            array_map(function ($key) {
                return 'tenant.'.$key;
            }, array_keys($tenantRules)), $tenantRules
        );

        // We set user_id and user_type fields in the controller
        unset($tenantRules['tenant.user_id'], $tenantRules['tenant.user_type']);

        return array_merge($managerRules, $tenantRules);
    }
}
