<?php

declare(strict_types=1);

use Cortex\Auth\Models\Member;
use Cortex\Auth\Models\Manager;
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::register('adminarea.home', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
});

Breadcrumbs::register('adminarea.managers.index', function (BreadcrumbsGenerator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
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
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
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
