<?php

namespace App\Filament\Resources\ResourceResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;

class EquipmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'equipment';

    protected static ?string $recordTitleAttribute = 'name';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('total_quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('available_quantity')
                    ->required()
                    ->numeric(),
                Select::make('resource_id')
                    ->relationship('resource', 'name')
                    ->required(),
                    Select::make('resource_id')
                    ->relationship('resource', 'name')
                    ->required(),
            ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('total_quantity')->sortable(),
                TextColumn::make('available_quantity')->sortable(),
                TextColumn::make('resource.name')->label('Resource')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
