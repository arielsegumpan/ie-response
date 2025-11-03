<?php

namespace App\Traits;

use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Woenel\Prpcmblmts\Models\PhilippineCity;
use Woenel\Prpcmblmts\Models\PhilippineRegion;
use Woenel\Prpcmblmts\Models\PhilippineBarangay;
use Woenel\Prpcmblmts\Models\PhilippineProvince;

trait HandlesCascadingAddress
{
    /**
     * Update the full address field when any address component changes
     */
    public static function updateFullAddress(Set $set, Get $get): void
    {
        $regionId = $get('region_id');
        $provinceId = $get('province_id');
        $cityId = $get('city_id');
        $barangayId = $get('barangay_id');

        // Only generate full address if all required fields are filled
        if (!$regionId || !$provinceId || !$cityId || !$barangayId) {
            $set('full_address', null);
            return;
        }

        try {
            // Get the names of each location component with caching
            $addressComponents = static::getAddressComponents($regionId, $provinceId, $cityId, $barangayId);

            // Construct the full address
            if (array_filter($addressComponents)) {
                $fullAddress = implode(', ', array_filter([
                    "Brgy. {$addressComponents['barangay']}",
                    $addressComponents['city'],
                    $addressComponents['province'],
                    $addressComponents['region']
                ]));

                $set('full_address', $fullAddress);
            } else {
                $set('full_address', null);
            }
        } catch (\Exception $e) {
            // Handle any errors gracefully
            Log::error('Error updating full address: ' . $e->getMessage());
            $set('full_address', null);
        }
    }

    /**
     * Get address components with caching
     */
    protected static function getAddressComponents($regionId, $provinceId, $cityId, $barangayId): array
    {
        return [
            'region' => Cache::remember("region_name_{$regionId}", 1800, function () use ($regionId) {
                return PhilippineRegion::find($regionId)?->name;
            }),
            'province' => Cache::remember("province_name_{$provinceId}", 1800, function () use ($provinceId) {
                return PhilippineProvince::find($provinceId)?->name;
            }),
            'city' => Cache::remember("city_name_{$cityId}", 1800, function () use ($cityId) {
                return PhilippineCity::find($cityId)?->name;
            }),
            'barangay' => Cache::remember("barangay_name_{$barangayId}", 1800, function () use ($barangayId) {
                return PhilippineBarangay::find($barangayId)?->name;
            })
        ];
    }

    /**
     * Clear dependent address fields and full address
     */
    public static function clearDependentFields(Set $set, string $level): void
    {
        switch ($level) {
            case 'region':
                $set('province_id', null);
                $set('city_id', null);
                $set('barangay_id', null);
                $set('full_address', null);
                break;
            case 'province':
                $set('city_id', null);
                $set('barangay_id', null);
                $set('full_address', null);
                break;
            case 'city':
                $set('barangay_id', null);
                $set('full_address', null);
                break;
        }
    }

    /**
     * Alternative full address format (more detailed)
     */
    public static function updateDetailedFullAddress(Set $set, Get $get, ?string $streetAddress = null): void
    {
        $regionId = $get('region_id');
        $provinceId = $get('province_id');
        $cityId = $get('city_id');
        $barangayId = $get('barangay_id');
        $streetAddress = $streetAddress ?? $get('street_address');

        if (!$regionId || !$provinceId || !$cityId || !$barangayId) {
            $set('full_address', null);
            return;
        }

        try {
            $addressComponents = static::getAddressComponents($regionId, $provinceId, $cityId, $barangayId);

            if (array_filter($addressComponents)) {
                $parts = array_filter([
                    $streetAddress,
                    "Barangay {$addressComponents['barangay']}",
                    $addressComponents['city'],
                    $addressComponents['province'],
                    $addressComponents['region'],
                    'Philippines'
                ]);

                $fullAddress = implode(', ', $parts);
                $set('full_address', $fullAddress);
            }
        } catch (\Exception $e) {
            Log::error('Error updating detailed full address: ' . $e->getMessage());
            $set('full_address', null);
        }
    }
}
