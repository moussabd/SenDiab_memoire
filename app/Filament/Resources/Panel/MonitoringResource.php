<?php

namespace App\Filament\Resources\Panel;

use Filament\Forms;
use Filament\Tables;
use Livewire\Component;
use Filament\Forms\Form;
use App\Models\Monitoring;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Panel\MonitoringResource\Pages;
use App\Filament\Resources\Panel\MonitoringResource\RelationManagers;

class MonitoringResource extends Resource
{
    protected static ?string $model = Monitoring::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationGroup = 'Admin';

    public static function getModelLabel(): string
    {
        return __('crud.monitorings.itemTitle');
    }

    public static function getPluralModelLabel(): string
    {
        return __('crud.monitorings.collectionTitle');
    }

    public static function getNavigationLabel(): string
    {
        return __('crud.monitorings.collectionTitle');
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()->schema([
                Grid::make(['default' => 1])->schema([
                    Select::make('patient_id')
                        ->required()
                        ->relationship('patient', 'matricule')
                        ->searchable()
                        ->preload()
                        ->native(false),

                    DateTimePicker::make('dateofsample')
                        ->rules(['date'])
                        ->required()
                        ->native(false),

                    Select::make('parameter_id')
                        ->required()
                        ->relationship('parameter', 'name')
                        ->searchable()
                        ->preload()
                        ->native(false),

                    TextInput::make('value')
                        ->nullable()
                        ->numeric()
                        ->step(1),

                    Textarea::make('comments_patients')
                        ->nullable()
                        ->autosize(),

                    Textarea::make('comments_doctor')->nullable(),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
            ->columns([
                TextColumn::make('patient.matricule')
                ->searchable()
                ->sortable(),

                TextColumn::make('dateofsample')
                ->searchable()
                ->sortable(),

                TextColumn::make('parameter.name')
                ->searchable()
                ->sortable(),

                TextColumn::make('value')
                ->searchable()
                ->sortable(),

                TextColumn::make('comments_patients')->limit(255),

                TextColumn::make('comments_doctor')->limit(255),
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
            'index' => Pages\ListMonitorings::route('/'),
            'create' => Pages\CreateMonitoring::route('/create'),
            'view' => Pages\ViewMonitoring::route('/{record}'),
            'edit' => Pages\EditMonitoring::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([
            SoftDeletingScope::class,
        ]);
    }
}
