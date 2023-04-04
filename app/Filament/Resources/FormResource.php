<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResource\Pages;
use App\Models\Form as FormModel;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class FormResource extends Resource
{
    protected static ?string $model = FormModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Tabs::make('Heading')
                    ->tabs([
                        static::informationTabSchema(),
                        static::builderTabSchema(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('auth_required')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_internal')
                    ->boolean()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('responses')
                    ->formatStateUsing(fn ($state) => count($state))
                    ->label('# Responses'),
                TextColumn::make('start')
                    ->formatStateUsing(fn ($record) => $record->formattedStart)
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('end')
                    ->formatStateUsing(fn ($record) => $record->formattedEnd)
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('timezone')
                    ->formatStateUsing(fn ($record) => $record->formattedTimezone)
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('start', 'desc')
            ->filters([
                //
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'view' => Pages\ViewForm::route('/{record}'),
            'edit' => Pages\EditForm::route('/{record}/edit'),
        ];
    }

    public static function builderTabSchema()
    {
        return Tab::make('Builder')
            ->schema([
                Builder::make('form')
                    ->label('Form')
                    ->reactive()
                    ->cloneable()
                    ->collapsible()
                    ->blocks([
                        static::questionBlockSchema(),
                        static::collaboratorsBlockSchema(),
                        static::contentBlockSchema(),
                    ]),
            ]);
    }

    public static function informationTabSchema()
    {
        return Tab::make('Information')
            ->schema([
                Select::make('type')
                    ->options([
                        'workshop' => 'Workshop',
                        'survey' => 'Survey',
                        'form' => 'Form',
                    ])
                    ->columnSpan(2),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('event_id')
                    ->relationship('event', 'name'),
                DateTimePicker::make('start'),
                DateTimePicker::make('end'),
                Toggle::make('auth_required')
                    ->required(),
                Toggle::make('is_internal')
                    ->required(),
            ])
            ->columns(2);
    }

    public static function collaboratorsBlockSchema()
    {
        return Block::make('collaborators')
            ->schema([
                TextInput::make('id')
                    ->label('ID')
                    ->helperText('Short, unique identifier for collaborator section. Use dashes instead of spaces.'),
            ]);
    }

    public static function contentBlockSchema()
    {
        return Block::make('content')
            ->schema([
                TextInput::make('id')
                    ->label('ID')
                    ->helperText('Short, unique identifier for content section. Use dashes instead of spaces.'),
                RichEditor::make('content'),
            ]);
    }

    public static function questionBlockSchema()
    {
        return Block::make('question')
            ->columns(2)
            ->label(fn (array $state): ?string => isset($state['id']) ? str($state['id'])->replace('-', ' ')->title() : null)
            ->schema([
                TextInput::make('id')
                    ->label('ID')
                    ->helperText('Short, unique identifier for question. Use dashes instead of spaces.'),
                Select::make('type')
                    ->options([
                        'text' => 'Text',
                        'number' => 'Number',
                        'textarea' => 'Textarea',
                        'rich-editor' => 'Rich Editor',
                        'list' => 'List',
                        'matrix' => 'Matrix',
                        'opinion-scale' => 'Opinion Scale',
                    ])
                    ->reactive(),
                TextInput::make('question'),
                TextInput::make('help'),
                KeyValue::make('options')
                    ->hidden(fn ($get) => ! ($get('type') === 'list' || $get('type') === 'matrix')),
                Textarea::make('scale')
                    ->helperText('Put each option on a new line or separate by commas.')
                    ->hidden(fn ($get) => ! ($get('type') === 'matrix')),
                Radio::make('list-style')
                    ->helperText('Choose checkbox if multiple can be selected.')
                    ->hidden(fn ($get) => ! ($get('type') === 'list'))
                    ->options([
                        'checkbox' => 'Checkbox',
                        'radio' => 'Radio',
                        'dropdown' => 'Dropdown',
                    ]),
                Checkbox::make('other')
                    ->label('Enable Other Option')
                    ->helperText('Turn on if users are allowed to fill in their own option.')
                    ->hidden(fn ($get) => ! ($get('type') === 'list' || $get('type') === 'matrix')),
                Fieldset::make('Settings')
                    ->schema([
                        TextInput::make('rules')
                            ->label('Validation Rules')
                            ->helperText('Pipe delineated list of validation rules. Required is probably all that is needed, but if more specific validation is required see [all options available](https://laravel.com/docs/10.x/validation#available-validation-rules).'),
                        Select::make('visibility')
                            ->options([
                                'always' => 'Always show',
                                'conditional' => 'Show when',
                            ])
                            ->reactive(),
                        Select::make('visibility-andor')
                            ->label('Visible When')
                            ->options([
                                'and' => 'All of the following conditions pass',
                                'or' => 'Any of the following conditions pass',
                            ])
                            ->hidden(fn ($get) => $get('visibility') !== 'conditional'),
                        Repeater::make('conditions')
                            ->columnSpan(2)
                            ->hidden(fn ($get) => $get('visibility') !== 'conditional')
                            ->schema([
                                TextInput::make('field')
                                    ->helperText('Copy and paste the ID from the question this is reliant on.')
                                    ->required(),
                                Select::make('method')
                                    ->options([
                                        'equals' => 'equals',
                                        'not' => 'does not equal',
                                        '>' => '&gt;',
                                        '>=' => '&gt;=',
                                        '<' => '&lt;',
                                        '<=' => '&lt;=',
                                    ])
                                    ->required(),
                                TextInput::make('value')->required(),
                            ])->columns(3),
                    ]),
            ]);
    }
}
