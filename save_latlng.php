<?php
    require_once __DIR__ . '/config.php';

    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['lat'], $data['lng'])) {
        $_SESSION['latlng'] = [
            'lat' => (float) $data['lat'],
            'lng' => (float) $data['lng'],
        ];
        echo json_encode(['success' => true, 'latlng' => $_SESSION['latlng']]);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Missing lat/lng']);
    }