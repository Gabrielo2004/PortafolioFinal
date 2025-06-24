<?php
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');
include 'config.php';

// Detectar método real con simulación de _method en POST
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $inputJSON = file_get_contents("php://input");
    $input = json_decode($inputJSON, true);
    $post_method = $_POST['_method'] ?? null;

    if (($input && isset($input['_method'])) || $post_method) {
        $method = strtoupper($input['_method'] ?? $post_method);
    }
}

$request = explode('/', trim($_SERVER['PATH_INFO'] ?? '', '/'));
$id = isset($request[0]) ? intval($request[0]) : null;

function getInput() {
    $inputJSON = file_get_contents("php://input");
    return json_decode($inputJSON, true);
}

switch ($method) {
    case 'GET':
        if ($id) {
            $res = $conn->query("SELECT * FROM proyectos WHERE id=$id");
            echo json_encode($res->fetch_assoc());
        } else {
            $res = $conn->query("SELECT * FROM proyectos ORDER BY created_at DESC");
            $out = [];
            while ($row = $res->fetch_assoc()) {
                $out[] = $row;
            }
            echo json_encode($out, JSON_UNESCAPED_UNICODE);
        }
        break;

    case 'POST':
        $d = getInput();
        if (!isset($d['titulo'], $d['descripcion'], $d['url_github'], $d['url_produccion'], $d['imagen']) ||
            empty($d['titulo']) || empty($d['descripcion']) || empty($d['url_github']) || empty($d['url_produccion']) || empty($d['imagen'])) {
            http_response_code(400);
            echo json_encode(["error" => "Faltan datos requeridos para crear el proyecto"]);
            break;
        }
        $stmt = $conn->prepare("INSERT INTO proyectos (titulo, descripcion, url_github, url_produccion, imagen) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $d['titulo'], $d['descripcion'], $d['url_github'], $d['url_produccion'], $d['imagen']);
        $stmt->execute();
        echo json_encode(["success" => true, "id" => $stmt->insert_id]);
        break;

    case 'PATCH':
        $d = getInput();
        $sets = [];
        foreach ($d as $k => $v) {
            if ($k !== '_method') {  // Ignorar _method
                $sets[] = "$k='" . $conn->real_escape_string($v) . "'";
            }
        }
        if ($id) {
            $conn->query("UPDATE proyectos SET " . implode(",", $sets) . " WHERE id=$id");
            echo json_encode(["success" => true]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "ID no proporcionado para actualizar"]);
        }
        break;

    case 'DELETE':
        if ($id) {
            $conn->query("DELETE FROM proyectos WHERE id=$id");
            echo json_encode(["success" => true]);
        } else {
            http_response_code(400);
            echo json_encode(["error" => "ID no proporcionado para eliminar"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>
