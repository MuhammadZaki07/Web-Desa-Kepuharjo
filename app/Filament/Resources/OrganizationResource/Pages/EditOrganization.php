<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrganization extends EditRecord
{
    protected static string $resource = OrganizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Helper function to normalize array data
        $normalizeArrayData = function($fieldData) {
            // If null or empty, return empty array
            if (empty($fieldData)) {
                return [];
            }

            // If it's already an array, process it
            if (is_array($fieldData)) {
                return array_map(function($item) {
                    if (is_array($item)) {
                        return $item; // Already in correct format
                    } elseif (is_string($item)) {
                        return ['name' => $item];
                    } else {
                        return ['name' => (string) $item];
                    }
                }, $fieldData);
            }

            // If it's a string, try to decode as JSON
            if (is_string($fieldData)) {
                $decoded = json_decode($fieldData, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    // Successfully decoded JSON array
                    return array_map(function($item) {
                        if (is_array($item)) {
                            return $item;
                        } elseif (is_string($item)) {
                            return ['name' => $item];
                        } else {
                            return ['name' => (string) $item];
                        }
                    }, $decoded);
                } else {
                    // Not valid JSON, treat as single item
                    return [['name' => $fieldData]];
                }
            }

            // For any other type, convert to string and wrap in array
            return [['name' => (string) $fieldData]];
        };

        // Process programs
        if (isset($data['programs'])) {
            $data['programs'] = $normalizeArrayData($data['programs']);
        }

        // Process activities
        if (isset($data['activities'])) {
            $data['activities'] = $normalizeArrayData($data['activities']);
        }

        // Process structure (this might also need normalization)
        if (isset($data['structure'])) {
            if (is_string($data['structure'])) {
                $decoded = json_decode($data['structure'], true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $data['structure'] = $decoded;
                } else {
                    $data['structure'] = [];
                }
            } elseif (!is_array($data['structure'])) {
                $data['structure'] = [];
            }
        }

        return $data;
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Organisasi berhasil diperbarui';
    }
}
