<?php

require_once __DIR__ . '/../src/WordCounter.php';

$counter = new WordCounter(__DIR__ . '/../storage/data.json');

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

try {

    // GET /words
    if ($path === '/words' && $method === 'GET') {
        echo json_encode($counter->getAll());
        exit;
    }

    // POST /words
    if ($path === '/words' && $method === 'POST') {

        $rawInput = file_get_contents('php://input');
        $input = json_decode($rawInput, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode([
                'error' => 'Invalid JSON payload'
            ]);
            exit;
        }

        if (
            !isset($input['text']) ||
            !is_string($input['text']) ||
            trim($input['text']) === ''
        ) {
            http_response_code(400);
            echo json_encode([
                'error' => 'Text must not be empty'
            ]);
            exit;
        }

        $counter->addText($input['text']);

        http_response_code(200);
        echo json_encode([
            'status' => 'ok'
        ]);
        exit;
    }

    // GET /words/{word}
    if ($method === 'GET' && preg_match('#^/words/([^/]+)$#', $path, $matches)) {

        $word = mb_strtolower(urldecode($matches[1]));

        echo json_encode([
            'word' => $word,
            'count' => $counter->getCount($word)
        ]);
        exit;
    }

    // Method not allowed on /words
    if ($path === '/words') {
        http_response_code(405);
        echo json_encode([
            'error' => 'Method not allowed'
        ]);
        exit;
    }

    http_response_code(404);
    echo json_encode([
        'error' => 'Not found'
    ]);

} catch (Throwable $e) {

    http_response_code(500);

    echo json_encode([
        'error' => 'Internal server error'
    ]);
}
