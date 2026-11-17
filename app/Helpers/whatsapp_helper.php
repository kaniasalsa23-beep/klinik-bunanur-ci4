<?php

/**
 * WhatsApp Helper Functions for Klinik Bunanur CI4
 *
 * Provides centralized WhatsApp normalization, validation, masking, and formatting.
 */

if (!function_exists('normalize_whatsapp')) {
    /**
     * Normalizes any Indonesian phone/WhatsApp input into the standard international format (628xxxxxxxxxx).
     *
     * Handles:
     * - '0812-2484-1377' -> '6281224841377'
     * - '+62 812 2484 1377' -> '6281224841377'
     * - '81224841377' -> '6281224841377'
     * - '62081224841377' -> '6281224841377'
     * - ' 085894349793' -> '6285894349793'
     */
    function normalize_whatsapp(?string $phone): string
    {
        if ($phone === null) {
            return '';
        }

        // Strip non-numeric characters (spaces, dashes, plus, parentheses)
        $digits = preg_replace('/\D+/', '', $phone);
        if ($digits === '') {
            return '';
        }

        // 6208... -> 628...
        if (str_starts_with($digits, '6208')) {
            $digits = '628' . substr($digits, 4);
        }
        // 08... -> 628...
        elseif (str_starts_with($digits, '08')) {
            $digits = '628' . substr($digits, 2);
        }
        // 8... -> 628... (standard 9 to 13 digits)
        elseif (str_starts_with($digits, '8') && strlen($digits) >= 9 && strlen($digits) <= 13) {
            $digits = '62' . $digits;
        }
        // 0062... -> 62...
        elseif (str_starts_with($digits, '0062')) {
            $digits = substr($digits, 2);
        }

        return $digits;
    }
}

if (!function_exists('is_valid_whatsapp')) {
    /**
     * Checks if a phone number matches standard Indonesian cellular numbering (10-15 digits starting with 628).
     */
    function is_valid_whatsapp(?string $phone): bool
    {
        $norm = normalize_whatsapp($phone);
        return (bool)preg_match('/^628\d{8,12}$/', $norm);
    }
}

if (!function_exists('mask_whatsapp')) {
    /**
     * Safely masks a WhatsApp number for public/OTP displays (e.g. +62 812-****-1377).
     */
    function mask_whatsapp(?string $phone): string
    {
        $norm = normalize_whatsapp($phone);
        if (strlen($norm) < 9) {
            return '+62 8**-****-****';
        }

        $prefix = substr($norm, 0, 5); // e.g. 62812
        $suffix = substr($norm, -4);    // e.g. 1377
        $formattedPrefix = '+' . substr($prefix, 0, 2) . ' ' . substr($prefix, 2);
        return "{$formattedPrefix}-****-{$suffix}";
    }
}

if (!function_exists('format_whatsapp_display')) {
    /**
     * Formats normalized number for clean human-readable UI display (e.g. +62 812-2484-1377).
     */
    function format_whatsapp_display(?string $phone): string
    {
        $norm = normalize_whatsapp($phone);
        if (strlen($norm) < 9) {
            return $phone ?? '';
        }

        $country = substr($norm, 0, 2);
        $operator = substr($norm, 2, 3);
        $mid = substr($norm, 5, 4);
        $rest = substr($norm, 9);
        return "+{$country} {$operator}-{$mid}-{$rest}";
    }
}

if (!function_exists('wa_url')) {
    /**
     * Generates a clean wa.me direct link with optional pre-filled message.
     */
    function wa_url(?string $phone, string $message = ''): string
    {
        $norm = normalize_whatsapp($phone);
        $url = 'https://wa.me/' . $norm;
        if (!empty($message)) {
            $url .= '?text=' . rawurlencode($message);
        }
        return $url;
    }
}
