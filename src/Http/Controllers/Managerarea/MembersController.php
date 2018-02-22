<?php

declare(strict_types=1);

namespace Cortex\Auth\B2B2C2\Http\Controllers\Managerarea;

use Illuminate\Http\Request;
use Cortex\Auth\Models\Member;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\DataTables\ActivitiesDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Auth\B2B2C2\DataTables\Managerarea\MembersDataTable;
use Cortex\Auth\B2B2C2\Http\Requests\Managerarea\MemberFormRequest;
use Cortex\Auth\B2B2C2\Http\Requests\Managerarea\MemberAttributesFormRequest;

class MembersController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Member::class;

    /**
     * List all members.
     *
     * @param \Cortex\Auth\B2B2C2\DataTables\Managerarea\MembersDataTable $membersDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(MembersDataTable $membersDataTable)
    {
        return $membersDataTable->with([
            'id' => 'managerarea-members-index-table',
            'phrase' => trans('cortex/auth::common.members'),
        ])->render('cortex/foundation::managerarea.pages.datatable');
    }

    /**
     * List member logs.
     *
     * @param \Cortex\Auth\Models\Member                  $member
     * @param \Cortex\Foundation\DataTables\LogsDataTable $logsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logs(Member $member, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'resource' => $member,
            'tabs' => 'managerarea.members.tabs',
            'phrase' => trans('cortex/auth::common.members'),
            'id' => "managerarea-members-{$member->getKey()}-logs-table",
        ])->render('cortex/foundation::managerarea.pages.datatable-logs');
    }

    /**
     * Get a listing of the resource activities.
     *
     * @param \Cortex\Auth\Models\Member                        $member
     * @param \Cortex\Foundation\DataTables\ActivitiesDataTable $activitiesDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function activities(Member $member, ActivitiesDataTable $activitiesDataTable)
    {
        return $activitiesDataTable->with([
            'resource' => $member,
            'tabs' => 'managerarea.members.tabs',
            'phrase' => trans('cortex/auth::common.members'),
            'id' => "managerarea-members-{$member->getKey()}-activities-table",
        ])->render('cortex/foundation::managerarea.pages.datatable-logs');
    }

    /**
     * Show the form for create/update of the given resource attributes.
     *
     * @param \Illuminate\Http\Request   $request
     * @param \Cortex\Auth\Models\Member $member
     *
     * @return \Illuminate\View\View
     */
    public function attributes(Request $request, Member $member)
    {
        return view('cortex/auth::managerarea.pages.member-attributes', compact('member'));
    }

    /**
     * Process the account update form.
     *
     * @param \Cortex\Auth\B2B2C2\Http\Requests\Managerarea\MemberAttributesFormRequest $request
     * @param \Cortex\Auth\Models\Member                                                $member
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function updateAttributes(MemberAttributesFormRequest $request, Member $member)
    {
        $data = $request->validated();

        // Update profile
        $member->fill($data)->save();

        return intend([
            'back' => true,
            'with' => ['success' => trans('cortex/auth::messages.account.updated_attributes')],
        ]);
    }

    /**
     * Create new member.
     *
     * @param \Illuminate\Http\Request   $request
     * @param \Cortex\Auth\Models\Member $member
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request, Member $member)
    {
        return $this->form($request, $member);
    }

    /**
     * Edit given member.
     *
     * @param \Illuminate\Http\Request   $request
     * @param \Cortex\Auth\Models\Member $member
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, Member $member)
    {
        return $this->form($request, $member);
    }

    /**
     * Show member create/edit form.
     *
     * @param \Illuminate\Http\Request   $request
     * @param \Cortex\Auth\Models\Member $member
     *
     * @return \Illuminate\View\View
     */
    protected function form(Request $request, Member $member)
    {
        $countries = collect(countries())->map(function ($country, $code) {
            return [
                'id' => $code,
                'text' => $country['name'],
                'emoji' => $country['emoji'],
            ];
        })->values();
        $currentUser = $request->user($this->getGuard());
        $languages = collect(languages())->pluck('name', 'iso_639_1');
        $genders = ['male' => trans('cortex/auth::common.male'), 'female' => trans('cortex/auth::common.female')];

        $roles = $currentUser->can('superadmin')
            ? app('cortex.auth.role')->all()->pluck('name', 'id')->toArray()
            : $currentUser->roles->pluck('name', 'id')->toArray();

        $abilities = $currentUser->can('superadmin')
            ? app('cortex.auth.ability')->all()->groupBy('entity_type')->map->pluck('title', 'id')->toArray()
            : $currentUser->getAbilities()->groupBy('entity_type')->map->pluck('title', 'id')->toArray();

        asort($roles);
        ksort($abilities);

        return view('cortex/auth::managerarea.pages.member', compact('member', 'abilities', 'roles', 'countries', 'languages', 'genders'));
    }

    /**
     * Store new member.
     *
     * @param \Cortex\Auth\B2B2C2\Http\Requests\Managerarea\MemberFormRequest $request
     * @param \Cortex\Auth\Models\Member                                      $member
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(MemberFormRequest $request, Member $member)
    {
        return $this->process($request, $member);
    }

    /**
     * Update given member.
     *
     * @param \Cortex\Auth\B2B2C2\Http\Requests\Managerarea\MemberFormRequest $request
     * @param \Cortex\Auth\Models\Member                                      $member
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(MemberFormRequest $request, Member $member)
    {
        return $this->process($request, $member);
    }

    /**
     * Process stored/updated member.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Auth\Models\Member              $member
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function process(FormRequest $request, Member $member)
    {
        // Prepare required input fields
        $data = $request->validated();

        ! $request->hasFile('profile_picture')
        || $member->addMediaFromRequest('profile_picture')
                ->sanitizingFileName(function ($fileName) {
                    return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
                })
                ->toMediaCollection('profile_picture', config('cortex.auth.media.disk'));

        ! $request->hasFile('cover_photo')
        || $member->addMediaFromRequest('cover_photo')
                ->sanitizingFileName(function ($fileName) {
                    return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
                })
                ->toMediaCollection('cover_photo', config('cortex.auth.media.disk'));

        // Save member
        $member->fill($data)->save();

        return intend([
            'url' => route('managerarea.members.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => 'member', 'id' => $member->username])],
        ]);
    }

    /**
     * Destroy given member.
     *
     * @param \Cortex\Auth\Models\Member $member
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return intend([
            'url' => route('managerarea.members.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => 'member', 'id' => $member->username])],
        ]);
    }
}
