<?php

namespace App\Filament\Resources\PackageResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\PackageResource;

class EditPackage extends EditRecord
{
    protected static string $resource = PackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    public function afterSave(): void
    {
        // Necessary to refresh, in order to load the updated saved relationships and
        // correctly show or hide the "manage provider plans" warning placeholder.
        $this->getRecord()->refresh();
    }
}
