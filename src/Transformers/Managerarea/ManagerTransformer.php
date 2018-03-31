<?php

declare(strict_types=1);

namespace Cortex\Auth\B2B2C2\Transformers\Managerarea;

use Cortex\Auth\Models\Manager;
use Rinvex\Support\Traits\Escaper;
use League\Fractal\TransformerAbstract;

class ManagerTransformer extends TransformerAbstract
{
    use Escaper;

    /**
     * @return array
     */
    public function transform(Manager $manager): array
    {
        return $this->escapeRow([
            'id' => (string) $manager->getRouteKey(),
            'is_active' => (bool) $manager->is_active,
            'full_name' => (string) $manager->full_name,
            'username' => (string) $manager->username,
            'email' => (string) $manager->email,
            'phone' => (string) $manager->phone,
            'country_code' => (string) $manager->country_code ? country($manager->country_code)->getName() : null,
            'language_code' => (string) $manager->language_code ? language($manager->language_code)->getName() : null,
            'title' => (string) $manager->title,
            'birthday' => (string) $manager->birthday,
            'gender' => (string) $manager->gender,
            'last_activity' => (string) $manager->last_activity,
            'created_at' => (string) $manager->created_at,
            'updated_at' => (string) $manager->updated_at,
        ]);
    }
}
