<?php

declare(strict_types=1);

namespace Cortex\Auth\B2B2C2\Http\Controllers\Managerarea;

use Illuminate\Http\Request;
use Cortex\Auth\Models\Manager;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\DataTables\ActivitiesDataTable;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Auth\B2B2C2\DataTables\Managerarea\ManagersDataTable;
use Cortex\Auth\B2B2C2\Http\Requests\Managerarea\ManagerFormRequest;
use Cortex\Auth\B2B2C2\Http\Requests\Managerarea\ManagerAttributesFormRequest;

class ManagersController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Manager::class;

    /**
     * List all managers.
     *
     * @param \Cortex\Auth\B2B2C2\DataTables\Managerarea\ManagersDataTable $managersDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(ManagersDataTable $managersDataTable)
    {
        return $managersDataTable->with([
            'id' => 'managerarea-managers-index-table',
            'phrase' => trans('cortex/auth::common.managers'),
        ])->render('cortex/foundation::managerarea.pages.datatable');
    }

    /**
     * List manager logs.
     *
     * @param \Cortex\Auth\Models\Manager                 $manager
     * @param \Cortex\Foundation\DataTables\LogsDataTable $logsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logs(Manager $manager, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'resource' => $manager,
            'tabs' => 'managerarea.managers.tabs',
            'phrase' => trans('cortex/auth::common.managers'),
            'id' => "managerarea-managers-{$manager->getKey()}-logs-table",
        ])->render('cortex/foundation::managerarea.pages.datatable-logs');
    }

    /**
     * Get a listing of the resource activities.
     *
     * @param \Cortex\Auth\Models\Manager                       $manager
     * @param \Cortex\Foundation\DataTables\ActivitiesDataTable $activitiesDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function activities(Manager $manager, ActivitiesDataTable $activitiesDataTable)
    {
        return $activitiesDataTable->with([
            'resource' => $manager,
            'tabs' => 'managerarea.managers.tabs',
            'phrase' => trans('cortex/auth::common.managers'),
            'id' => "managerarea-managers-{$manager->getKey()}-activities-table",
        ])->render('cortex/foundation::managerarea.pages.datatable-logs');
    }

    /**
     * Show the form for create/update of the given resource attributes.
     *
     * @param \Illuminate\Http\Request    $request
     * @param \Cortex\Auth\Models\Manager $manager
     *
     * @return \Illuminate\View\View
     */
    public function attributes(Request $request, Manager $manager)
    {
        return view('cortex/auth::managerarea.pages.manager-attributes', compact('manager'));
    }

    /**
     * Process the account update form.
     *
     * @param \Cortex\Auth\B2B2C2\Http\Requests\Managerarea\ManagerAttributesFormRequest $request
     * @param \Cortex\Auth\Models\Manager                                                $manager
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function updateAttributes(ManagerAttributesFormRequest $request, Manager $manager)
    {
        $data = $request->validated();

        // Update profile
        $manager->fill($data)->save();

        return intend([
            'back' => true,
            'with' => ['success' => trans('cortex/auth::messages.account.updated_attributes')],
        ]);
    }

    /**
     * Create new manager.
     *
     * @param \Illuminate\Http\Request    $request
     * @param \Cortex\Auth\Models\Manager $manager
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request, Manager $manager)
    {
        return $this->form($request, $manager);
    }

    /**
     * Edit given manager.
     *
     * @param \Illuminate\Http\Request    $request
     * @param \Cortex\Auth\Models\Manager $manager
     *
     * @return \Illuminate\View\View
     */
    public function edit(Request $request, Manager $manager)
    {
        return $this->form($request, $manager);
    }

    /**
     * Show manager create/edit form.
     *
     * @param \Illuminate\Http\Request    $request
     * @param \Cortex\Auth\Models\Manager $manager
     *
     * @return \Illuminate\View\View
     */
    protected function form(Request $request, Manager $manager)
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

        return view('cortex/auth::managerarea.pages.manager', compact('manager', 'abilities', 'roles', 'countries', 'languages', 'genders'));
    }

    /**
     * Store new manager.
     *
     * @param \Cortex\Auth\B2B2C2\Http\Requests\Managerarea\ManagerFormRequest $request
     * @param \Cortex\Auth\Models\Manager                                      $manager
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(ManagerFormRequest $request, Manager $manager)
    {
        return $this->process($request, $manager);
    }

    /**
     * Update given manager.
     *
     * @param \Cortex\Auth\B2B2C2\Http\Requests\Managerarea\ManagerFormRequest $request
     * @param \Cortex\Auth\Models\Manager                                      $manager
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(ManagerFormRequest $request, Manager $manager)
    {
        return $this->process($request, $manager);
    }

    /**
     * Process stored/updated manager.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Auth\Models\Manager             $manager
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function process(FormRequest $request, Manager $manager)
    {
        // Prepare required input fields
        $data = $request->validated();

        ! $request->hasFile('profile_picture')
        || $manager->addMediaFromRequest('profile_picture')
                ->sanitizingFileName(function ($fileName) {
                    return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
                })
                ->toMediaCollection('profile_picture', config('cortex.auth.media.disk'));

        ! $request->hasFile('cover_photo')
        || $manager->addMediaFromRequest('cover_photo')
                ->sanitizingFileName(function ($fileName) {
                    return md5($fileName).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
                })
                ->toMediaCollection('cover_photo', config('cortex.auth.media.disk'));

        // Save manager
        $manager->fill($data)->save();

        return intend([
            'url' => route('managerarea.managers.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => 'manager', 'id' => $manager->username])],
        ]);
    }

    /**
     * Destroy given manager.
     *
     * @param \Cortex\Auth\Models\Manager $manager
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Manager $manager)
    {
        $manager->delete();

        return intend([
            'url' => route('managerarea.managers.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => 'manager', 'id' => $manager->username])],
        ]);
    }
}
