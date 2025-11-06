<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin Secret Path
    |--------------------------------------------------------------------------
    |
    | This is the hidden path to access the admin panel. This should be kept
    | secret and only known to the owner. Change this to something unique.
    |
    */

    'secret_path' => env('ADMIN_SECRET_PATH', 'x-admin-9bcd'),

    /*
    |--------------------------------------------------------------------------
    | Admin Owner Email
    |--------------------------------------------------------------------------
    |
    | This email will receive notifications for admin login attempts and
    | security events. Leave empty to disable notifications.
    |
    */

    'owner_email' => env('ADMIN_OWNER_EMAIL', null),

    /*
    |--------------------------------------------------------------------------
    | Allowed IPs
    |--------------------------------------------------------------------------
    |
    | Comma-separated list of IP addresses allowed to access admin panel.
    | Leave empty to allow all IPs (not recommended for production).
    | Example: ADMIN_ALLOW_IPS=192.168.1.1,10.0.0.1
    |
    */

    'allow_ips' => array_filter(
        array_map('trim', explode(',', env('ADMIN_ALLOW_IPS', '')))
    ),

    /*
    |--------------------------------------------------------------------------
    | Device Tracking
    |--------------------------------------------------------------------------
    |
    | Configuration for device tracking system.
    |
    */

    'device_tracking' => [
        'enabled' => env('DEVICE_TRACKING_ENABLED', true),
        'active_minutes' => env('DEVICE_ACTIVE_MINUTES', 5),
        'cookie_lifetime' => 60 * 24 * 365, // 1 year in minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Monitoring
    |--------------------------------------------------------------------------
    |
    | Configuration for monitoring dashboard.
    |
    */

    'monitoring' => [
        'poll_interval' => env('MONITORING_POLL_INTERVAL', 3000), // milliseconds
        'active_devices_limit' => 50,
        'recent_visits_limit' => 200,
        'login_events_limit' => 50,
    ],

];
