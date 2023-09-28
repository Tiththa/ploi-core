<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Site;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Builder;
use App\Actions\Site\SynchronizeSiteAction;
use App\Filament\Resources\SiteResource\Pages;
use App\Filament\Resources\SiteResource\RelationManagers;

class SiteResource extends Resource
{
    protected static ?string $model = Site::class;

    protected static ?string $navigationIcon = 'heroicon-o-code-bracket';

    protected static ?string $navigationGroup = 'Site management';

    protected static ?int $navigationSort = 0;

    protected static ?string $recordTitleAttribute = 'domain';

    public static function getLabel(): ?string
    {
        return __('Site');
    }

    public static function getPluralLabel(): ?string
    {
        return __('Sites');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('domain')
                    ->label(__('Domain'))
                    ->required()
                    ->hostname()
                    ->unique(Site::class, column: 'domain', ignoreRecord: true)
                    ->columnSpan(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('domain')
                    ->description(function (Site $record) {
                        return "PHP $record->php_version";
                    })
                    ->label(__('Name'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('server.name')
                    ->label(__('Server'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        Site::STATUS_BUSY => __('Busy'),
                        Site::STATUS_ACTIVE => __('Active'),
                    })
                    ->colors([
                        'warning' => Site::STATUS_BUSY,
                        'success' => Site::STATUS_ACTIVE,
                    ])
                    ->label(__('Status')),
                Tables\Columns\TextColumn::make('users')
                    ->label(__('Users'))
                    ->wrap()
                    ->formatStateUsing(function (Site $record) {
                        $state = $record
                            ->users
                            ->map(function (User $user) {
                                return '<a href="' . UserResource::getUrl('edit', ['record' => $user]) . '" class="text-primary-600" style="white-space: nowrap">' . $user->name . '</a>';
                            })
                            ->implode(', ') ?: '-';

                        return new HtmlString($state);
                    })
                    ->searchable(query: function (Builder $query, string $search) {
                        return $query->whereHas('users', function (Builder $query) use ($search) {
                            return $query
                                ->where('name', 'LIKE', "%{$search}%")
                                ->orWhere('email', 'LIKE', "%{$search}%");
                        });
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Date'))
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('synchronize_site')
                    ->label(__('Synchronize'))
                    ->tooltip(__('This will synchronize the latest data from this provider to your Ploi Core installation'))
                    ->icon('heroicon-o-arrow-path')
                    ->action(function (Site $record) {
                        app(SynchronizeSiteAction::class)->execute($record->server->ploi_id, $record->ploi_id);
                    })
                    ->visible(fn (Site $record) => $record->status === Site::STATUS_ACTIVE),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->defaultSort('sites.created_at', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['users', 'server']);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UsersRelationManager::class,
            RelationManagers\CertificatesRelationManager::class,
            RelationManagers\CronjobsRelationManager::class,
            RelationManagers\RedirectsRelationManager::class,
            RelationManagers\SystemUsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSites::route('/'),
            'edit' => Pages\EditSite::route('/{record}/edit'),
            'synchronize' => Pages\SynchronizeSites::route('/synchronize'),
        ];
    }
}
