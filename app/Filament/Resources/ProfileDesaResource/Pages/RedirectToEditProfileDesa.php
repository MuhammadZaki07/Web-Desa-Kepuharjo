<?php

namespace App\Filament\Resources\ProfileDesaResource\Pages;

use App\Models\ProfileDesa;
use Filament\Resources\Pages\Page;

class RedirectToEditProfileDesa extends Page
{
    protected static string $resource = \App\Filament\Resources\ProfileDesaResource::class;

    protected static string $view = 'filament.resources.profile-desa.pages.redirect-to-edit-profile-desa';

    public function mount()
    {
        $record = ProfileDesa::first();

        return redirect(EditProfileDesa::getUrl([$record->getKey()]));
    }
}
