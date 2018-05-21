<?php

declare(strict_types=1);

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
    $menu->route(['adminarea.members.import'], trans('cortex/auth::common.records'))->ifCan('import', $member)->if(Route::is('adminarea.members.import*'));
    $menu->route(['adminarea.members.import.logs'], trans('cortex/auth::common.logs'))->ifCan('import', $member)->if(Route::is('adminarea.members.import*'));
    $menu->route(['adminarea.members.create'], trans('cortex/auth::common.details'))->ifCan('create', $member)->if(Route::is('adminarea.members.create'));
    $menu->route(['adminarea.members.edit', ['member' => $member]], trans('cortex/auth::common.details'))->ifCan('update', $member)->if($member->exists);
    //$menu->route(['adminarea.members.attributes', ['member' => $member]], trans('cortex/auth::common.attributes'))->ifCan('update', $member)->if($member->exists);
    $menu->route(['adminarea.members.logs', ['member' => $member]], trans('cortex/auth::common.logs'))->ifCan('audit', $member)->if($member->exists);
    $menu->route(['adminarea.members.activities', ['member' => $member]], trans('cortex/auth::common.activities'))->ifCan('audit', $member)->if($member->exists);
});

Menu::register('adminarea.managers.tabs', function (MenuGenerator $menu, Manager $manager) {
    $menu->route(['adminarea.managers.import'], trans('cortex/auth::common.records'))->ifCan('import', $manager)->if(Route::is('adminarea.managers.import*'));
    $menu->route(['adminarea.managers.import.logs'], trans('cortex/auth::common.logs'))->ifCan('import', $manager)->if(Route::is('adminarea.managers.import*'));
    $menu->route(['adminarea.managers.create'], trans('cortex/auth::common.details'))->ifCan('create', $manager)->if(Route::is('adminarea.managers.create'));
    $menu->route(['adminarea.managers.edit', ['manager' => $manager]], trans('cortex/auth::common.details'))->ifCan('update', $manager)->if($manager->exists);
    //$menu->route(['adminarea.managers.attributes', ['manager' => $manager]], trans('cortex/auth::common.attributes'))->ifCan('update', $manager)->if($manager->exists);
    $menu->route(['adminarea.managers.logs', ['manager' => $manager]], trans('cortex/auth::common.logs'))->ifCan('audit', $manager)->if($manager->exists);
    $menu->route(['adminarea.managers.activities', ['manager' => $manager]], trans('cortex/auth::common.activities'))->ifCan('audit', $manager)->if($manager->exists);
});
