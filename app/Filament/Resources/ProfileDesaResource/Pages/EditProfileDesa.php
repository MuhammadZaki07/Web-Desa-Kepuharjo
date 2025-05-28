<?php

namespace App\Filament\Resources\ProfileDesaResource\Pages;

use App\Filament\Resources\ProfileDesaResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditProfileDesa extends EditRecord
{
    protected static string $resource = ProfileDesaResource::class;

    public static function getRoute(): string
    {
        return '/edit';
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $socialMedia = DB::table('sosial_media')->pluck('url', 'platform')->toArray();
        $prefixes = [
            'instagram' => 'https://instagram.com/',
            'facebook' => 'https://facebook.com/',
            'youtube' => 'https://youtube.com/',
            'whatsapp' => 'https://wa.me/',
            'tiktok' => 'https://tiktok.com/',
            'threeads' => 'https://threeads.com/',
        ];

        foreach ($prefixes as $platform => $prefix) {
            $data[$platform] = str_replace($prefix, '', $socialMedia[$platform] ?? '');
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        foreach ($data as $platform => $value) {
            if (in_array($platform, ['instagram', 'facebook', 'youtube', 'whatsapp', 'tiktok', 'threeads'])) {
                DB::table('sosial_media')->updateOrInsert(
                    ['platform' => $platform],
                    ['url' => $this->buildUrl($platform, $value), 'updated_at' => now()]
                );
                unset($data[$platform]);
            }
        }

        return $data;
    }

    private function buildUrl($platform, $value)
    {
        $prefixes = [
            'instagram' => 'https://instagram.com/',
            'facebook' => 'https://facebook.com/',
            'youtube' => 'https://youtube.com/',
            'whatsapp' => 'https://wa.me/',
            'tiktok' => 'https://tiktok.com/',
            'threeads' => 'https://threeads.com/',
        ];

        return $prefixes[$platform] . $value;
    }

    public function getRecord(): Model
    {
        return \App\Models\ProfileDesa::firstOrFail();
    }
}
