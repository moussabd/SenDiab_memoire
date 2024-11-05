<?php

namespace App\Filament\Resources\Panel;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Panel\UserResource\Pages;
use App\Filament\Resources\Panel\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationGroup = 'Admin';

    public static function getModelLabel(): string
    {
        return __('crud.users.itemTitle');
    }

    public static function getPluralModelLabel(): string
    {
        return __('crud.users.collectionTitle');
    }

    public static function getNavigationLabel(): string
    {
        return __('crud.users.collectionTitle');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()->schema([
                Grid::make(['default' => 1])->schema([
                    Select::make('civility')
                        ->nullable()
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->options([
                            'Mme' => 'Mme',
                            'M.' => 'M',
                            'Mlle' => 'Mlle',
                        ]),

                    TextInput::make('firstname')
                        ->required()
                        ->string(),

                    TextInput::make('lastname')
                        ->required()
                        ->string(),

                    Select::make('gender')
                        ->nullable()
                        ->in(['male', 'female', 'other'])
                        ->searchable()
                        ->preload()
                        ->native(false)
                        ->options([
                            'male' => 'Male',
                            'female' => 'Female',
                            'other' => 'Other',
                        ]),

                    TextInput::make('phone_number')
                        ->required()
                        ->string(),

                    TextInput::make('email')
                        ->required()
                        ->string()
                        ->unique('users', 'email', ignoreRecord: true)
                        ->email()
                        ->autofocus(),

                    TextInput::make('password')
                        ->required(
                            fn(string $context): bool => $context === 'create'
                        )
                        ->dehydrated(fn($state) => filled($state))
                        ->string()
                        ->minLength(6)
                        ->password(),

                    DatePicker::make('date_of_birth')
                        ->rules(['date'])
                        ->nullable()
                        ->native(false),

                    TextInput::make('age')
                        ->nullable()
                        ->numeric()
                        ->step(1),

                    TextInput::make('place_of_birth')
                        ->nullable()
                        ->string(),

                    TextInput::make('cni')
                        ->nullable()
                        ->string(),

                    TextInput::make('address')
                        ->nullable()
                        ->string(),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
            ->columns([
                TextColumn::make('civility')
                ->searchable()
                ->sortable(),

                TextColumn::make('firstname')
                ->searchable()
                ->sortable(),

                TextColumn::make('lastname')
                ->searchable()
                ->sortable(),

                TextColumn::make('gender')
                ->searchable()
                ->sortable(),

                TextColumn::make('phone_number')
                ->searchable()
                ->sortable(),

                TextColumn::make('email')
                ->searchable()
                ->sortable(),

                TextColumn::make('date_of_birth')
                ->searchable()
                ->sortable(),

                TextColumn::make('age')
                ->searchable()
                ->sortable(),

                TextColumn::make('place_of_birth')
                ->searchable()
                ->sortable(),

                TextColumn::make('cni')
                ->searchable()
                ->sortable(),

                TextColumn::make('address'),
            ])
            ->searchable()
            ->filters([Tables\Filters\TrashedFilter::make()])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),

                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }
}
