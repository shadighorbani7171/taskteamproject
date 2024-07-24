<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AllocationResource\Pages;
use App\Models\Allocation;
use App\Models\Resource;
use App\Models\Project;
use App\Models\Task;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource as FilamentResource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class AllocationResource extends FilamentResource
{
    protected static ?string $model = Allocation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('resource_id')
                    ->label('Resource')
                    ->options(function () {
                        return Resource::all()->mapWithKeys(function ($resource) {
                            return [$resource->id => "{$resource->name} (Available: {$resource->available_quantity})"];
                        })->toArray();
                    })
                    ->required(),
                Select::make('project_id')
                    ->label('Project')
                    ->options(Project::all()->pluck('name', 'id'))
                    ->required(),
                Select::make('task_id')
                    ->label('Task')
                    ->options(Task::all()->pluck('name', 'id'))
                    ->nullable(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                   
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('resource.name')
                    ->label('Resource Name')
                    ->sortable()
                    ->searchable(),
                
                TextColumn::make('project.name')
                    ->label('Project Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('task.name')
                    ->label('Task Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('quantity')
                    ->label('Quantity')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Created At')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // اضافه کردن Relation Managers
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAllocations::route('/'),
            'create' => Pages\CreateAllocation::route('/create'),
            'edit' => Pages\EditAllocation::route('/{record}/edit'),
        ];
    }
}

