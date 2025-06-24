<?php
function api_get($endpoint) {
    $url = 'https://teclab.uct.cl/~gabriel.alonso/api/' . ltrim($endpoint, '/');

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $json = curl_exec($ch);
    curl_close($ch);

    $json = trim($json);
    $data = json_decode($json, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo '<p style="color:red;">Error al decodificar JSON desde la API: ' . json_last_error_msg() . '</p>';
        echo '<pre>' . htmlspecialchars($json) . '</pre>';
        return null;
    }

    return $data;
}
