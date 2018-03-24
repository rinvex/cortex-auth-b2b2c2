<?php

declare(strict_types=1);

use Cortex\Auth\Models\Role;
use Cortex\Auth\Models\Member;
use Cortex\Auth\Models\Manager;
use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu, Member $member, Manager $manager) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.user'), null, 'fa fa-users', [], function (MenuItem $dropdown) use ($member, $manager) {
        $dropdown->route(['adminarea.members.index'], trans('cortex/auth::common.members'), null, 'fa fa-user')->ifCan('list', $member)->activateOnRoute('adminarea.members');
        $dropdown->route(['adminarea.managers.index'], trans('cortex/auth::common.managers'), null, 'fa fa-user')->ifCan('list', $manager)->activateOnRoute('adminarea.managers');
    });
});

Menu::register('adminarea.members.tabs', function (MenuGenerator $menu, Member $member) {
    $menu->route(['adminarea.members.create'], trans('cortex/auth::common.details'))->ifCan('create', $member)->if(Route::is('adminarea.members.create'));
    $menu->route(['adminarea.members.edit', ['member' => $member]], trans('cortex/auth::common.details'))->ifCan('update', $member)->if($member->exists);
    $menu->route(['adminarea.members.attributes', ['member' => $member]], trans('cortex/auth::common.attributes'))->ifCan('update', $member)->if($member->exists);
    $menu->route(['adminarea.members.logs', ['member' => $member]], trans('cortex/auth::common.logs'))->ifCan('audit', $member)->if($member->exists);
    $menu->route(['adminarea.members.activities', ['member' => $member]], trans('cortex/auth::common.activities'))->ifCan('audit', $member)->if($member->exists);
});

Menu::register('adminarea.managers.tabs', function (MenuGenerator $menu, Manager $manager) {
    $menu->route(['adminarea.managers.create'], trans('cortex/auth::common.details'))->ifCan('create', $manager)->if(Route::is('adminarea.managers.create'));
    $menu->route(['adminarea.managers.edit', ['manager' => $manager]], trans('cortex/auth::common.details'))->ifCan('update', $manager)->if($manager->exists);
    $menu->route(['adminarea.managers.attributes', ['manager' => $manager]], trans('cortex/auth::common.attributes'))->ifCan('update', $manager)->if($manager->exists);
    $menu->route(['adminarea.managers.logs', ['manager' => $manager]], trans('cortex/auth::common.logs'))->ifCan('audit', $manager)->if($manager->exists);
    $menu->route(['adminarea.managers.activities', ['manager' => $manager]], trans('cortex/auth::common.activities'))->ifCan('audit', $manager)->if($manager->exists);
});

Menu::register('managerarea.sidebar', function (MenuGenerator $menu, Role $role, Member $member, Manager $manager) {
    $menu->findByTitleOrAdd(trans('cortex/foundation::common.access'), 20, 'fa fa-user-circle-o', [], function (MenuItem $dropdown) use ($role) {
        $dropdown->route(['managerarea.roles.index'], trans('cortex/auth::common.roles'), null, 'fa fa-users')->ifCan('list', $role)->activateOnRoute('managerarea.roles');
    });

    $menu->findByTitleOrAdd(trans('cortex/foundation::common.user'), null, 'fa fa-users', [], function (MenuItem $dropdown) use ($manager, $member) {
        $dropdown->route(['managerarea.members.index'], trans('cortex/auth::common.members'), null, 'fa fa-user')->ifCan('list', $member)->activateOnRoute('managerarea.members');
        $dropdown->route(['managerarea.managers.index'], trans('cortex/auth::common.managers'), null, 'fa fa-user')->ifCan('list', $manager)->activateOnRoute('managerarea.managers');
    });
});

Menu::register('managerarea.roles.tabs', function (MenuGenerator $menu, Role $role) {
    $menu->route(['managerarea.roles.create'], trans('cortex/auth::common.details'))->ifCan('create', $role)->if(Route::is('managerarea.roles.create'));
    $menu->route(['managerarea.roles.edit', ['role' => $role]], trans('cortex/auth::common.details'))->ifCan('update', $role)->if($role->exists);
    $menu->route(['managerarea.roles.logs', ['role' => $role]], trans('cortex/auth::common.logs'))->ifCan('audit', $role)->if($role->exists);
});

Menu::register('managerarea.members.tabs', function (MenuGenerator $menu, Member $member) {
    $menu->route(['managerarea.members.create'], trans('cortex/auth::common.details'))->ifCan('create', $member)->if(Route::is('managerarea.members.create'));
    $menu->route(['managerarea.members.edit', ['member' => $member]], trans('cortex/auth::common.details'))->ifCan('update', $member)->if($member->exists);
    $menu->route(['managerarea.members.attributes', ['member' => $member]], trans('cortex/auth::common.attributes'))->ifCan('update', $member)->if($member->exists);
    $menu->route(['managerarea.members.logs', ['member' => $member]], trans('cortex/auth::common.logs'))->ifCan('audit', $member)->if($member->exists);
    $menu->route(['managerarea.members.activities', ['member' => $member]], trans('cortex/auth::common.activities'))->ifCan('audit', $member)->if($member->exists);
});

Menu::register('managerarea.managers.tabs', function (MenuGenerator $menu, Manager $manager) {
    $menu->route(['managerarea.managers.create'], trans('cortex/auth::common.details'))->ifCan('create', $manager)->if(Route::is('managerarea.managers.create'));
    $menu->route(['managerarea.managers.edit', ['manager' => $manager]], trans('cortex/auth::common.details'))->ifCan('update', $manager)->if($manager->exists);
    $menu->route(['managerarea.managers.attributes', ['manager' => $manager]], trans('cortex/auth::common.attributes'))->ifCan('update', $manager)->if($manager->exists);
    $menu->route(['managerarea.managers.logs', ['manager' => $manager]], trans('cortex/auth::common.logs'))->ifCan('audit', $manager)->if($manager->exists);
    $menu->route(['managerarea.managers.activities', ['manager' => $manager]], trans('cortex/auth::common.activities'))->ifCan('audit', $manager)->if($manager->exists);
});
