<?php

namespace App\Services;

use App\Models\User;
use App\Models\Customer;

class ProviderBuffaloGameService
{
    // /
    //  * Site configuration - Updated for Production
    //  * IMPORTANT: Must match the site_url in config/buffalo_sites.php
    //  */
    private const SITE_NAME = 'https://shweshankan.com';
    private const SITE_PREFIX = 'shw';
    // No secret key needed - API provider uses UUID + token format

    // /
    //  * Generate UUID (32 characters) for Buffalo API
    //  * Format: prefix(3) + base64_encoded_username(variable) + padding to 32 chars
    //  */
    public static function generateUid(string $userName): string
    {
        // Encode username to base64 (URL-safe)
        $encoded = rtrim(strtr(base64_encode($userName), '+/', '-_'), '=');
        
        // Create a 32-character UID: prefix + encoded username + hash padding
        $prefix = self::SITE_PREFIX; // 3 chars: "gam"
        $remaining = 32 - strlen($prefix);
        
        // If encoded username is longer than available space, use hash instead
        if (strlen($encoded) > $remaining - 10) {
            $hash = md5($userName . self::SITE_NAME);
            return $prefix . substr($hash, 0, $remaining);
        }
        
        // Pad with hash to reach 32 characters total
        $padding = substr(md5($userName . self::SITE_NAME), 0, $remaining - strlen($encoded));
        return $prefix . $encoded . $padding;
    }

    // /
    //  * Generate token (64 characters) for Buffalo API
    //  */
    public static function generateToken(string $uid): string
    {
        // Generate a 64-character token using SHA256
        return hash('sha256', $uid . self::SITE_NAME . time());
    }

    // /
    //  * Generate persistent token for user (stored in database)
    //  * Note: Only uses username for consistency (no user_id to allow verification without full user object)
    //  */
    public static function generatePersistentToken(Customer $user): string
    {
        // Generate a persistent token that doesn't change with time
        // Only use username (not user_id) so we can verify with just the username
        return hash('sha256', $user->user_name . self::SITE_NAME . 'buffalo-persistent-token');
    }
}