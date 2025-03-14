<?php
namespace App\Helpers;

class RetentionHelper {
    public static function formatRetention($active, $activeUnit, $storage, $storageUnit) {
        if ($activeUnit === 'Permanent' || $storageUnit === 'Permanent') {
            return 'Permanent';
        }

        $activeMonths = self::convertToMonths($active, $activeUnit);
        $storageMonths = self::convertToMonths($storage, $storageUnit);
        $totalMonths = $activeMonths + $storageMonths;

        $years = floor($totalMonths / 12);
        $months = $totalMonths % 12;

        return ($years > 0 ? "{$years} year(s) " : "") . ($months > 0 ? "{$months} month(s)" : "");
    }

    private static function convertToMonths($value, $unit) {
        return ($unit === "years") ? $value * 12 : $value;
    }
}

?>