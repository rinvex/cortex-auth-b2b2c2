<?php

declare(strict_types=1);

namespace Cortex\Auth\B2B2C2\Http\Controllers\Managerarea;

use Cortex\Auth\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\Foundation\DataTables\LogsDataTable;
use Cortex\Foundation\Importers\DefaultImporter;
use Cortex\Foundation\DataTables\ImportLogsDataTable;
use Cortex\Foundation\Http\Requests\ImportFormRequest;
use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Auth\B2B2C2\DataTables\Managerarea\RolesDataTable;
use Cortex\Auth\B2B2C2\Http\Requests\Managerarea\RoleFormRequest;
use Cortex\Auth\B2B2C2\Http\Requests\Managerarea\RoleFormProcessRequest;

class RolesController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = Role::class;

    /**
     * List all roles.
     *
     * @param \Cortex\Auth\B2B2C2\DataTables\Managerarea\RolesDataTable $rolesDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(RolesDataTable $rolesDataTable)
    {
        return $rolesDataTable->with([
            'id' => 'managerarea-roles-index-table',
            'phrase' => trans('cortex/auth::common.roles'),
        ])->render('cortex/foundation::managerarea.pages.datatable');
    }

    /**
     * List role logs.
     *
     * @param \Cortex\Auth\Models\Role                    $role
     * @param \Cortex\Foundation\DataTables\LogsDataTable $logsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function logs(Role $role, LogsDataTable $logsDataTable)
    {
        return $logsDataTable->with([
            'resource' => $role,
            'tabs' => 'managerarea.roles.tabs',
            'phrase' => trans('cortex/auth::common.roles'),
            'id' => "managerarea-roles-{$role->getKey()}-logs-table",
        ])->render('cortex/foundation::managerarea.pages.datatable-logs');
    }

    /**
     * Import roles.
     *
     * @return \Illuminate\View\View
     */
    public function import()
    {
        return view('cortex/foundation::adminarea.pages.import', [
            'id' => 'adminarea-roles-import',
            'tabs' => 'adminarea.roles.tabs',
            'url' => route('adminarea.roles.hoard'),
            'phrase' => trans('cortex/auth::common.roles'),
        ]);
    }

    /**
     * Hoard roles.
     *
     * @param \Cortex\Foundation\Http\Requests\ImportFormRequest $request
     * @param \Cortex\Foundation\Importers\DefaultImporter       $importer
     *
     * @return void
     */
    public function hoard(ImportFormRequest $request, DefaultImporter $importer)
    {
        // Handle the import
        $importer->config['resource'] = $this->resource;
        $importer->handleImport();
    }

    /**
     * List role import logs.
     *
     * @param \Cortex\Foundation\DataTables\ImportLogsDataTable $importLogsDatatable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function importLogs(ImportLogsDataTable $importLogsDatatable)
    {
        return $importLogsDatatable->with([
            'resource' => 'role',
            'tabs' => 'adminarea.roles.tabs',
            'id' => 'adminarea-roles-import-logs-table',
            'phrase' => trans('cortex/roles::common.roles'),
        ])->render('cortex/foundation::adminarea.pages.datatable-import-logs');
    }

    /**
     * Create new role.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Cortex\Auth\Models\Role $role
     *
     * @return \Illuminate\View\View
     */
    public function create(Request $request, Role $role)
    {
        return $this->form($request, $role);
    }

    /**
     * Edit given role.
     *
     * @param \Cortex\Auth\Http\Requests\Adminarea\RoleFormRequest $request
     * @param \Cortex\Auth\Models\Role                             $role
     *
     * @return \Illuminate\View\View
     */
    public function edit(RoleFormRequest $request, Role $role)
    {
        return $this->form($request, $role);
    }

    /**
     * Show role create/edit form.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Cortex\Auth\Models\Role $role
     *
     * @return \Illuminate\View\View
     */
    protected function form(Request $request, Role $role)
    {
        $currentUser = $request->user($this->getGuard());

        $abilities = $currentUser->can('superadmin')
            ? app('cortex.auth.ability')->all()->groupBy('entity_type')->map->pluck('title', 'id')->toArray()
            : $request->user($this->getGuard())->getAbilities()->groupBy('entity_type')->map->pluck('title', 'id')->toArray();

        ksort($abilities);

        return view('cortex/auth::managerarea.pages.role', compact('role', 'abilities'));
    }

    /**
     * Store new role.
     *
     * @param \Cortex\Auth\B2B2C2\Http\Requests\Managerarea\RoleFormProcessRequest $request
     * @param \Cortex\Auth\Models\Role                                             $role
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(RoleFormProcessRequest $request, Role $role)
    {
        return $this->process($request, $role);
    }

    /**
     * Update given role.
     *
     * @param \Cortex\Auth\B2B2C2\Http\Requests\Managerarea\RoleFormProcessRequest $request
     * @param \Cortex\Auth\Models\Role                                             $role
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(RoleFormProcessRequest $request, Role $role)
    {
        return $this->process($request, $role);
    }

    /**
     * Process stored/updated role.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\Auth\Models\Role                $role
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function process(FormRequest $request, Role $role)
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save role
        $role->fill($data)->save();

        return intend([
            'url' => route('managerarea.roles.index'),
            'with' => ['success' => trans('cortex/foundation::messages.resource_saved', ['resource' => 'role', 'id' => $role->name])],
        ]);
    }

    /**
     * Destroy given role.
     *
     * @param \Cortex\Auth\Models\Role $role
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return intend([
            'url' => route('managerarea.roles.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => 'role', 'id' => $role->name])],
        ]);
    }
}
