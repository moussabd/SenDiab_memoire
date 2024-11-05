<?php

namespace App\Filament\Resources\Panel;

use Filament\Forms;
use Filament\Tables;
use App\Models\Doctor;
use Livewire\Component;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Panel\DoctorResource\Pages;
use App\Filament\Resources\Panel\DoctorResource\RelationManagers;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationGroup = 'Admin';

    public static function getModelLabel(): string
    {
        return __('crud.doctors.itemTitle');
    }

    public static function getPluralModelLabel(): string
    {
        return __('crud.doctors.collectionTitle');
    }

    public static function getNavigationLabel(): string
    {
        return __('crud.doctors.collectionTitle');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()->schema([
                Grid::make(['default' => 1])->schema([
                    TextInput::make('matricule')
                        ->required()
                        ->string()
                        ->unique('doctor', 'matricule', ignoreRecord: true)
                        ->autofocus(),

                    TextInput::make('num_ordre')
                        ->required()
                        ->string()
                        ->unique('doctor', 'num_ordre', ignoreRecord: true),

                    Select::make('user_id')
                        ->required()
                        ->relationship('user', 'email')
                        ->searchable()
                        ->preload()
                        ->native(false),

                    TextInput::make('speciality')
                        ->nullable()
                        ->string(),

                    Select::make('entity_id')
                        ->required()
                        ->relationship('entity', 'name')
                        ->searchable()
                        ->preload()
                        ->native(false),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')

            ->columns([
                TextColumn::make('matricule')
                ->searchable()
                ->sortable(),

                TextColumn::make('num_ordre')
                ->searchable()
                ->sortable(),

                TextColumn::make('user.email')
                ->searchable()
                ->sortable(),

                TextColumn::make('speciality')
                ->searchable()
                ->sortable(),

                TextColumn::make('entity.name')
                ->searchable()
                ->sortable(),
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
        return [RelationManagers\DoctorPatientsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'view' => Pages\ViewDoctor::route('/{record}'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }
}
