<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use App\Models\Project; // اضافه کردن مدل Project
use App\Models\Subtask; // اضافه کردن مدل Subtask
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\HasManyRepeater; // اضافه کردن HasManyRepeater

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('team_id')
                    ->label('Team')
                    ->relationship('team', 'name')
                    ->options(Team::pluck('name', 'id')->toArray())
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description'),
                DatePicker::make('due_date')
                    ->label('Due Date')
                    ->required(),
                Select::make('status')
                    ->options([
                        'in progress' => 'In Progress',
                        'completed' => 'Completed',
                        'needs review' => 'Needs Review',
                    ])
                    ->default('in progress')
                    ->required(),
                MultiSelect::make('users')
                    ->relationship('users', 'name')
                    ->options(User::pluck('name', 'id')->toArray())
                    ->label('Users'),
                Select::make('project_id')
                    ->label('Project')
                    ->relationship('project', 'name')
                    ->options(Project::pluck('name', 'id')->toArray())
                    ->nullable(), // پروژه می‌تواند null باشد
                HasManyRepeater::make('subtasks') // اضافه کردن بخش Subtasks
                    ->relationship('subtasks')
                    ->schema([
                        TextInput::make('name')
                            ->label('Subtask Name')
                            ->required(),
                        Select::make('user_id')
                            ->label('User')
                            ->relationship('user', 'name')
                            ->options(User::pluck('name', 'id')->toArray())
                            ->nullable(), // کاربر می‌تواند null باشد
                    ])
                    ->label('Subtasks')
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('team.name')->label('Team')->sortable()->searchable(),
                TextColumn::make('name')->sortable()->searchable(),
                TextColumn::make('description')->sortable()->searchable(),
                TextColumn::make('due_date')
                    ->label('Due Date')
                    ->sortable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable(),
                TextColumn::make('users.name')
                    ->label('Users')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('project.name')
                    ->label('Project')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Add any relation managers if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
