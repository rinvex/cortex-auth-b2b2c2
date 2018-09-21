<?php

declare(strict_types=1);

namespace Cortex\Auth\B2B2C2\Http\Requests\Frontarea;

class TenantRegistrationProcessRequest extends TenantRegistrationRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $data = $this->all();

        $data['owner']['is_active'] = ! config('cortex.auth.registration.moderated');

        $this->replace($data);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $ownerRules = app('cortex.auth.manager')->getRules();
        $ownerRules['password'] = 'required|confirmed|min:'.config('cortex.auth.password_min_chars');
        $ownerRules = array_combine(
            array_map(function ($key) {
                return 'owner.'.$key;
            }, array_keys($ownerRules)), $ownerRules
        );

        $tenantRules = app('rinvex.tenants.tenant')->getRules();
        $tenantRules = array_combine(
            array_map(function ($key) {
                return 'tenant.'.$key;
            }, array_keys($tenantRules)), $tenantRules
        );

        // We set owner_id and owner_type fields in the controller
        unset($tenantRules['tenant.owner_id'], $tenantRules['tenant.owner_type']);

        return array_merge($ownerRules, $tenantRules);
    }
}
