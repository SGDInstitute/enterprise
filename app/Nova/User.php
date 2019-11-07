<?php

namespace App\Nova;

use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Password;
use KABBOUCHI\NovaImpersonate\Impersonate;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class User extends Resource
{

    public static $model = \App\User::class;

    public static $title = 'name';

    public static $group = '';

    public static $search = [
        'id', 'name', 'email',
    ];

    public static $with = ['profile'];

    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),
            Gravatar::make(),
            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}'),
            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:6')
                ->updateRules('nullable', 'string', 'min:6'),
            Impersonate::make($this->id),
            HasOne::make('Profile'),
            HasMany::make('Orders'),
            HasMany::make('Tickets'),
            MorphToMany::make('Roles', 'roles', \Vyuldashev\NovaPermission\Role::class),
            MorphToMany::make('Permissions', 'permissions', \Vyuldashev\NovaPermission\Permission::class),
        ];
    }

    public function cards(Request $request)
    {
        return [];
    }

    public function filters(Request $request)
    {
        return [];
    }

    public function lenses(Request $request)
    {
        return [];
    }

    public function actions(Request $request)
    {
        return [
            (new DownloadExcel)->withHeadings('#', 'Name', 'E-mail'),
        ];
    }
}
