<?php

namespace App\Filament\Resources\WisataResource\Pages;

use App\Filament\Resources\WisataResource;
use App\Models\Wisata;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWisata extends ViewRecord
{
    protected static string $resource = WisataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Edit')
                ->icon('heroicon-o-pencil'),

            Actions\Action::make('view_website')
                ->label('Lihat di Website')
                ->icon('heroicon-o-globe-alt')
                ->color('info')
                ->url(fn (Wisata $record): string => route('wisata.show', $record->slug))
                ->openUrlInNewTab(),

            Actions\Action::make('whatsapp')
                ->label('WhatsApp')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('success')
                ->visible(fn (Wisata $record): bool => !empty($record->whatsapp))
                ->url(fn (Wisata $record): string => $record->getWhatsAppBookingUrl())
                ->openUrlInNewTab(),

            Actions\Action::make('maps')
                ->label('Google Maps')
                ->icon('heroicon-o-map-pin')
                ->color('gray')
                ->visible(fn (Wisata $record): bool => !empty($record->latitude) && !empty($record->longitude))
                ->url(fn (Wisata $record): string => $record->getGoogleMapsUrl())
                ->openUrlInNewTab(),
        ];
    }
}
