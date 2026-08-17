<?php
/** Returns the Google Maps API key as JSON, for client-side map loading.
 *  Key is resolved (in order) from the GOOGLE_MAPS_API_KEY / GOOGLE_MAPS_KEY
 *  env vars, then from a local .env file so it works without mod_env. */
header('Content-Type: application/json');

function resolve_maps_key(): string {
    foreach (['GOOGLE_MAPS_API_KEY', 'GOOGLE_MAPS_KEY'] as $name) {
        $val = getenv($name);
        if ($val !== false && $val !== '') {
            return $val;
        }
    }

    $envPath = __DIR__ . '/.env';
    if (is_readable($envPath)) {
        foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#') {
                continue;
            }
            if (preg_match('/^\s*GOOGLE_MAPS_API_KEY\s*=\s*(.+)\s*$/', $line, $m)) {
                return trim($m[1]);
            }
            if (preg_match('/^\s*GOOGLE_MAPS_KEY\s*=\s*(.+)\s*$/', $line, $m)) {
                return trim($m[1]);
            }
        }
    }

    return '';
}

echo json_encode([
    'googleMapsKey' => resolve_maps_key(),
]);
