<?php

namespace Lyre\Settings\Filament\Resources;

use Lyre\Settings\Filament\Resources\SettingResource\Pages;
use Lyre\Settings\Models\Setting;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Model;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'gmdi-settings';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function ($query) {
                // If not super-admin, hide hidden settings
                if (!auth()->user()->hasRole(config('lyre.super-admin'))) {
                    $query->whereIn('status', ['editable', 'locked']);
                }
            })
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('label')
                        ->searchable()
                        ->formatStateUsing(function (string $state, $record): HtmlString {
                            $associatedTenants = $record->associatedTenants;
                            $tenantNamesString = "";
                            if ($associatedTenants->isNotEmpty()) {
                                $tenantNames = $associatedTenants->pluck('name')->implode(', ');
                                $tenantNamesString .= " {$tenantNames}";
                            }
                            $htmlString = "<strong>{$state}</strong>" . (auth()->user()->hasRole(config('lyre.super-admin')) && $tenantNamesString ? "<span class='text-xs text-gray-500'> - <i>{$tenantNamesString}</i></span>" : '');
                            return new HtmlString($htmlString);
                        }),
                    // Tables\Columns\TextColumn::make('key')
                    //     ->searchable()
                    //     ->color('primary')
                    //     ->lineClamp(2),
                    Tables\Columns\TextColumn::make('value')
                        ->formatStateUsing(fn($state) => $state === null ? 'Empty' : $state)
                        ->searchable()
                        ->color('primary')
                        ->lineClamp(2),
                    Tables\Columns\TextColumn::make('description')
                        ->searchable()
                        ->formatStateUsing(fn(string $state): HtmlString => new HtmlString('<small>' . $state . '</small>')),
                ]),

            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->visible(function (Setting $record) {
                        // Super admin → always editable
                        if (auth()->user()->hasRole(config('lyre.super-admin'))) {
                            return true;
                        }

                        // Tenant user → only editable if status is "editable"
                        return $record->status === 'editable';
                    })
                    ->form(function (Setting $record) {
                        return match ($record->type) {
                            'select' => [
                                Forms\Components\Select::make('value')
                                    ->label($record->label)
                                    ->options($record->attributes['options'])
                            ],
                            'number' => [
                                Forms\Components\TextInput::make('value')
                                    ->label($record->label)
                                    ->type('number')
                            ],
                            'text' => [
                                Forms\Components\MarkdownEditor::make('value')
                                    ->label($record->label)
                            ],
                            'generated' => [
                                Forms\Components\TextInput::make('value')
                                    ->label($record->label)
                                    ->disabled()
                                    ->suffixAction(
                                        Forms\Components\Actions\Action::make('generate')
                                            ->icon('gmdi-refresh-o')
                                            ->label('Generate')
                                            ->action(function ($action, $livewire) use ($record) {
                                                $value = $record->generateValue();
                                                $livewire->mountedTableActionsData[0]['value'] = $value;
                                            })
                                    )
                            ],
                            default => [
                                Forms\Components\TextInput::make('value')
                                    ->label($record->label)
                            ]
                        };
                    }),
            ])
            ->striped()
            ->deferLoading()
            ->defaultSort('created_at', 'asc')
            ->paginated(false);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSettings::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
