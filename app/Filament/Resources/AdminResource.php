<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Admin;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AdminResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AdminResource\RelationManagers;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $navigationIcon = 'heroicon-m-user-group';

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('id', '!=', Auth::guard('admin')->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Full Name'),
                TextInput::make('phone')
                    ->required()
                    ->label('Phone Number'),
                TextInput::make('email')
                    ->required()
                    ->label('Email Address'),
                Select::make('type')
                    ->required()
                    ->options([
                        'super_admin' => 'Super Admin',
                        'admin' => 'Admin',
                    ]),
                Hidden::make('password')
                    ->default('password')
                    ->visibleOn('create')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('#')
                    ->rowIndex(),
                TextColumn::make('name')
                    ->label('Full Name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email copied')
                    ->icon('heroicon-m-envelope'),
                TextColumn::make('phone')
                    ->searchable()
                    ->icon('heroicon-m-phone'),
                TextColumn::make('type')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'super_admin' => 'sucess',
                        'admin' => 'primary',
                    }),
                ToggleColumn::make('is_active')
                    ->visible(fn() => Auth::guard('admin')->user()->type === 'super_admin'),
                TextColumn::make('created_at')
                    ->date()
                    ->sortable(),

            ])
            ->filters([
                SelectFilter::make('type')
                    ->options([
                        'super_admin' => 'Super Admin',
                        'admin' => 'Admin',
                    ]),
                Filter::make('is_active')
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
