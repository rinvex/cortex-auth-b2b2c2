<?php

declare(strict_types=1);

namespace Cortex\Auth\B2B2C2\Transformers\Adminarea;

use Cortex\Auth\Models\Member;
use Rinvex\Support\Traits\Escaper;
use League\Fractal\TransformerAbstract;

class MemberTransformer extends TransformerAbstract
{
    use Escaper;

    /**
     * @return array
     */
    public function transform(Member $member): array
    {
        $country = $member->country_code ? country($member->country_code) : null;
        $language = $member->language_code ? language($member->language_code) : null;

        return $this->escape([
            'id' => (string) $member->getRouteKey(),
            'is_active' => (bool) $member->is_active,
            'full_name' => (string) ($member->full_name ?? $member->username),
            'username' => (string) $member->username,
            'email' => (string) $member->email,
            'email_verified' => (bool) $member->email_verified,
            'email_verified_at' => (string) $member->email_verified_at,
            'phone' => (string) $member->phone,
            'phone_verified' => (bool) $member->phone_verified,
            'phone_verified_at' => (string) $member->phone_verified_at,
            'country_code' => (string) optional($country)->getName(),
            'country_emoji' => (string) optional($country)->getEmoji(),
            'language_code' => (string) optional($language)->getName(),
            'title' => (string) $member->title,
            'birthday' => (string) $member->birthday,
            'gender' => (string) $member->gender,
            'last_activity' => (string) $member->last_activity,
            'created_at' => (string) $member->created_at,
            'updated_at' => (string) $member->updated_at,
        ]);
    }
}
