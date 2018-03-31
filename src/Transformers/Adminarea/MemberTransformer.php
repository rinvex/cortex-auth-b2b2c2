<?php

declare(strict_types=1);

namespace Cortex\Auth\B2B2C2\Transformers\Adminarea;

use Cortex\Auth\Models\Member;
use League\Fractal\TransformerAbstract;

class MemberTransformer extends TransformerAbstract
{
    /**
     * @return array
     */
    public function transform(Member $member): array
    {
        $country = $member->country_code ? country($member->country_code) : null;
        $language = $member->language_code ? language($member->language_code) : null;

        return [
            'id' => (string) $member->getRouteKey(),
            'is_active' => (bool) $member->is_active,
            'full_name' => (string) $member->full_name,
            'username' => (string) $member->username,
            'email' => (string) $member->email,
            'phone' => (string) $member->phone,
            'country_code' => (string) optional($country)->getEmoji().' '.optional($country)->getName(),
            'language_code' => (string) optional($language)->getName(),
            'title' => (string) $member->title,
            'birthday' => (string) $member->birthday,
            'gender' => (string) $member->gender,
            'last_activity' => (string) $member->last_activity,
            'created_at' => (string) $member->created_at,
            'updated_at' => (string) $member->updated_at,
        ];
    }
}
