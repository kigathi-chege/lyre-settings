<?php

namespace Lyre\Settings\Filament\Resources;

use Lyre\Settings\Filament\Resources\SettingResource\Pages;
use Lyre\Settings\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'gmdi-settings';

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
            ->columns([
                Tables\Columns\Layout\Stack::make([
                    Tables\Columns\TextColumn::make('label')
                        ->searchable()
                        ->formatStateUsing(fn(string $state): HtmlString => new HtmlString('<strong>' . $state . '</strong>')),
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
                            default => [
                                Forms\Components\TextInput::make('value')
                                    ->label($record->label)
                            ]
                        };
                    }),
            ])
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
