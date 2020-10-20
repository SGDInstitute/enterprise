<?php

namespace App\Nova;

use DigitalCloud\NovaResourceNotes\Fields\Notes;
use Eminiarts\Tabs\Tabs;
use Illuminate\Http\Request;
use KABBOUCHI\NovaImpersonate\Impersonate;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\HasOne;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class User extends Resource
{
    public static $model = \App\Models\User::class;

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
            Text::make('Pronouns', function () {
                return $this->profile->pronouns;
            }),
            Text::make('Sexuality', function () {
                return $this->profile->sexulaity;
            })->onlyOnDetail(),
            Text::make('Gender', function () {
                return $this->profile->gender;
            })->onlyOnDetail(),
            Text::make('College', function () {
                return $this->profile->college;
            })->onlyOnDetail(),
            Text::make('Tshirt', function () {
                return $this->profile->tshirt;
            })->onlyOnDetail(),
            Text::make('Wants Program', function () {
                return $this->profile->wants_program ? 'Yes' : 'No';
            })->onlyOnDetail(),
            Text::make('Accepted Agreement', function () {
                return $this->profile->agreement ? 'Yes' : 'No';
            })->onlyOnDetail(),
            Text::make('Accessibility', function () {
                return $this->profile->accessibility;
            })->onlyOnDetail(),
            Text::make('Language', function () {
                return $this->profile->language;
            })->onlyOnDetail(),
            Password::make('Password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:6')
                ->updateRules('nullable', 'string', 'min:6'),
            Impersonate::make($this->id),

            (new Tabs('Registration Details', [
                HasMany::make('Orders'),
                HasMany::make('Tickets'),
                BelongsToMany::make('Discounts'),
            ])),

            HasMany::make('Donations'),

            HasMany::make('Responses'),

            (new Tabs('Access Details', [
                MorphToMany::make('Roles', 'roles', \Vyuldashev\NovaPermission\Role::class),
                MorphToMany::make('Permissions', 'permissions', \Vyuldashev\NovaPermission\Permission::class),
            ])),

            Notes::make('Notes', 'notes'),
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
