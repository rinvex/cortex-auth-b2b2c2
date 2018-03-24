<?php

declare(strict_types=1);

use Cortex\Auth\Models\Role;
use Cortex\Auth\Models\Member;
use Cortex\Auth\Models\Manager;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

// Adminarea breadcrumbs
Breadcrumbs::register('adminarea.managers.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.adminarea'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/auth::common.managers'), route('adminarea.managers.index'));
});

Breadcrumbs::register('adminarea.managers.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.managers.index');
    $breadcrumbs->push(trans('cortex/auth::common.import'), route('adminarea.managers.import'));
});

Breadcrumbs::register('adminarea.managers.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.managers.index');
    $breadcrumbs->push(trans('cortex/auth::common.import'), route('adminarea.managers.import'));
    $breadcrumbs->push(trans('cortex/auth::common.logs'), route('adminarea.managers.import.logs'));
});

Breadcrumbs::register('adminarea.managers.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.managers.index');
    $breadcrumbs->push(trans('cortex/auth::common.create_manager'), route('adminarea.managers.create'));
});

Breadcrumbs::register('adminarea.managers.edit', function (BreadcrumbsGenerator $breadcrumbs, Manager $manager) {
    $breadcrumbs->parent('adminarea.managers.index');
    $breadcrumbs->push($manager->username, route('adminarea.managers.edit', ['manager' => $manager]));
});

Breadcrumbs::register('adminarea.managers.logs', function (BreadcrumbsGenerator $breadcrumbs, Manager $manager) {
    $breadcrumbs->parent('adminarea.managers.index');
    $breadcrumbs->push($manager->username, route('adminarea.managers.edit', ['manager' => $manager]));
    $breadcrumbs->push(trans('cortex/auth::common.logs'), route('adminarea.managers.logs', ['manager' => $manager]));
});

Breadcrumbs::register('adminarea.managers.activities', function (BreadcrumbsGenerator $breadcrumbs, Manager $manager) {
    $breadcrumbs->parent('adminarea.managers.index');
    $breadcrumbs->push($manager->username, route('adminarea.managers.edit', ['manager' => $manager]));
    $breadcrumbs->push(trans('cortex/auth::common.activities'), route('adminarea.managers.activities', ['manager' => $manager]));
});

Breadcrumbs::register('adminarea.managers.attributes', function (BreadcrumbsGenerator $breadcrumbs, Manager $manager) {
    $breadcrumbs->parent('adminarea.managers.index');
    $breadcrumbs->push($manager->username, route('adminarea.managers.edit', ['manager' => $manager]));
    $breadcrumbs->push(trans('cortex/auth::common.attributes'), route('adminarea.managers.attributes', ['manager' => $manager]));
});

Breadcrumbs::register('adminarea.members.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.adminarea'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/auth::common.members'), route('adminarea.members.index'));
});

Breadcrumbs::register('adminarea.members.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.members.index');
    $breadcrumbs->push(trans('cortex/auth::common.import'), route('adminarea.members.import'));
});

Breadcrumbs::register('adminarea.members.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.members.index');
    $breadcrumbs->push(trans('cortex/auth::common.import'), route('adminarea.members.import'));
    $breadcrumbs->push(trans('cortex/auth::common.logs'), route('adminarea.members.import.logs'));
});

Breadcrumbs::register('adminarea.members.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.members.index');
    $breadcrumbs->push(trans('cortex/auth::common.create_member'), route('adminarea.members.create'));
});

Breadcrumbs::register('adminarea.members.edit', function (BreadcrumbsGenerator $breadcrumbs, Member $member) {
    $breadcrumbs->parent('adminarea.members.index');
    $breadcrumbs->push($member->username, route('adminarea.members.edit', ['member' => $member]));
});

Breadcrumbs::register('adminarea.members.logs', function (BreadcrumbsGenerator $breadcrumbs, Member $member) {
    $breadcrumbs->parent('adminarea.members.index');
    $breadcrumbs->push($member->username, route('adminarea.members.edit', ['member' => $member]));
    $breadcrumbs->push(trans('cortex/auth::common.logs'), route('adminarea.members.logs', ['member' => $member]));
});

Breadcrumbs::register('adminarea.members.activities', function (BreadcrumbsGenerator $breadcrumbs, Member $member) {
    $breadcrumbs->parent('adminarea.members.index');
    $breadcrumbs->push($member->username, route('adminarea.members.edit', ['member' => $member]));
    $breadcrumbs->push(trans('cortex/auth::common.activities'), route('adminarea.members.activities', ['member' => $member]));
});

Breadcrumbs::register('adminarea.members.attributes', function (BreadcrumbsGenerator $breadcrumbs, Member $member) {
    $breadcrumbs->parent('adminarea.members.index');
    $breadcrumbs->push($member->username, route('adminarea.members.edit', ['member' => $member]));
    $breadcrumbs->push(trans('cortex/auth::common.attributes'), route('adminarea.members.attributes', ['member' => $member]));
});

// Managerarea breadcrumbs
Breadcrumbs::register('managerarea.roles.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.managerarea'), route('managerarea.home'));
    $breadcrumbs->push(trans('cortex/auth::common.roles'), route('managerarea.roles.index'));
});

Breadcrumbs::register('managerarea.roles.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.roles.index');
    $breadcrumbs->push(trans('cortex/auth::common.import'), route('managerarea.roles.import'));
});

Breadcrumbs::register('managerarea.roles.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.roles.index');
    $breadcrumbs->push(trans('cortex/auth::common.import'), route('managerarea.roles.import'));
    $breadcrumbs->push(trans('cortex/auth::common.logs'), route('managerarea.roles.import.logs'));
});

Breadcrumbs::register('managerarea.roles.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.roles.index');
    $breadcrumbs->push(trans('cortex/auth::common.create_role'), route('managerarea.roles.create'));
});

Breadcrumbs::register('managerarea.roles.edit', function (BreadcrumbsGenerator $breadcrumbs, Role $role) {
    $breadcrumbs->parent('managerarea.roles.index');
    $breadcrumbs->push($role->name, route('managerarea.roles.edit', ['role' => $role]));
});

Breadcrumbs::register('managerarea.roles.logs', function (BreadcrumbsGenerator $breadcrumbs, Role $role) {
    $breadcrumbs->parent('managerarea.roles.index');
    $breadcrumbs->push($role->name, route('managerarea.roles.edit', ['role' => $role]));
    $breadcrumbs->push(trans('cortex/auth::common.logs'), route('managerarea.roles.logs', ['role' => $role]));
});

Breadcrumbs::register('managerarea.members.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.managerarea'), route('managerarea.home'));
    $breadcrumbs->push(trans('cortex/auth::common.members'), route('managerarea.members.index'));
});

Breadcrumbs::register('managerarea.members.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.members.index');
    $breadcrumbs->push(trans('cortex/auth::common.import'), route('managerarea.members.import'));
});

Breadcrumbs::register('managerarea.members.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.members.index');
    $breadcrumbs->push(trans('cortex/auth::common.import'), route('managerarea.members.import'));
    $breadcrumbs->push(trans('cortex/auth::common.logs'), route('managerarea.members.import.logs'));
});

Breadcrumbs::register('managerarea.members.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.members.index');
    $breadcrumbs->push(trans('cortex/auth::common.create_member'), route('managerarea.members.create'));
});

Breadcrumbs::register('managerarea.members.edit', function (BreadcrumbsGenerator $breadcrumbs, Member $member) {
    $breadcrumbs->parent('managerarea.members.index');
    $breadcrumbs->push($member->username, route('managerarea.members.edit', ['member' => $member]));
});

Breadcrumbs::register('managerarea.members.logs', function (BreadcrumbsGenerator $breadcrumbs, Member $member) {
    $breadcrumbs->parent('managerarea.members.index');
    $breadcrumbs->push($member->username, route('managerarea.members.edit', ['member' => $member]));
    $breadcrumbs->push(trans('cortex/auth::common.logs'), route('managerarea.members.logs', ['member' => $member]));
});

Breadcrumbs::register('managerarea.members.activities', function (BreadcrumbsGenerator $breadcrumbs, Member $member) {
    $breadcrumbs->parent('managerarea.members.index');
    $breadcrumbs->push($member->username, route('managerarea.members.edit', ['member' => $member]));
    $breadcrumbs->push(trans('cortex/auth::common.activities'), route('managerarea.members.activities', ['member' => $member]));
});

Breadcrumbs::register('managerarea.members.attributes', function (BreadcrumbsGenerator $breadcrumbs, Member $member) {
    $breadcrumbs->parent('managerarea.members.index');
    $breadcrumbs->push($member->username, route('managerarea.members.edit', ['member' => $member]));
    $breadcrumbs->push(trans('cortex/auth::common.attributes'), route('managerarea.members.attributes', ['member' => $member]));
});

Breadcrumbs::register('managerarea.managers.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.trans('cortex/foundation::common.managerarea'), route('managerarea.home'));
    $breadcrumbs->push(trans('cortex/auth::common.managers'), route('managerarea.managers.index'));
});

Breadcrumbs::register('managerarea.managers.import', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.managers.index');
    $breadcrumbs->push(trans('cortex/auth::common.import'), route('managerarea.managers.import'));
});

Breadcrumbs::register('managerarea.managers.import.logs', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.managers.index');
    $breadcrumbs->push(trans('cortex/auth::common.import'), route('managerarea.managers.import'));
    $breadcrumbs->push(trans('cortex/auth::common.logs'), route('managerarea.managers.import.logs'));
});

Breadcrumbs::register('managerarea.managers.create', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->parent('managerarea.managers.index');
    $breadcrumbs->push(trans('cortex/auth::common.create_manager'), route('managerarea.managers.create'));
});

Breadcrumbs::register('managerarea.managers.edit', function (BreadcrumbsGenerator $breadcrumbs, Manager $manager) {
    $breadcrumbs->parent('managerarea.managers.index');
    $breadcrumbs->push($manager->username, route('managerarea.managers.edit', ['manager' => $manager]));
});

Breadcrumbs::register('managerarea.managers.logs', function (BreadcrumbsGenerator $breadcrumbs, Manager $manager) {
    $breadcrumbs->parent('managerarea.managers.index');
    $breadcrumbs->push($manager->username, route('managerarea.managers.edit', ['manager' => $manager]));
    $breadcrumbs->push(trans('cortex/auth::common.logs'), route('managerarea.managers.logs', ['manager' => $manager]));
});

Breadcrumbs::register('managerarea.managers.activities', function (BreadcrumbsGenerator $breadcrumbs, Manager $manager) {
    $breadcrumbs->parent('managerarea.managers.index');
    $breadcrumbs->push($manager->username, route('managerarea.managers.edit', ['manager' => $manager]));
    $breadcrumbs->push(trans('cortex/auth::common.activities'), route('managerarea.managers.activities', ['manager' => $manager]));
});

Breadcrumbs::register('managerarea.managers.attributes', function (BreadcrumbsGenerator $breadcrumbs, Manager $manager) {
    $breadcrumbs->parent('managerarea.managers.index');
    $breadcrumbs->push($manager->username, route('managerarea.managers.edit', ['manager' => $manager]));
    $breadcrumbs->push(trans('cortex/auth::common.attributes'), route('managerarea.managers.attributes', ['manager' => $manager]));
});
