<?php

require_once BASE_PATH . 'app/controllers/BaseController.php';
require_once BASE_PATH . 'config/env.php';

loadEnv();

class AiChatController extends BaseController
{
    public function index()
    {
        require_once BASE_PATH . 'app/views/ai_chat/index.php';
    }

    public function getChatContent() {
        header('Content-Type: text/html; charset=utf-8');
        require_once BASE_PATH . 'app/views/ai_chat/index.php';
        exit; 
    }

    public function chatApi()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }

        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        $userPrompt = $data['prompt'] ?? '';
        $chatHistory = $data['history'] ?? [];

        if (empty($userPrompt)) {
            echo json_encode(['error' => 'No prompt provided.']);
            http_response_code(400);
            exit();
        }

        $contents = [];
        foreach ($chatHistory as $message) {
            $contents[] = ['role' => $message['role'], 'parts' => [['text' => $message['text']]]];
        }

        $contents[] = ['role' => 'user', 'parts' => [['text' => $userPrompt]]];


        $payload = [
            'contents' => $contents,
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 2048,
            ],
        ];

        $apiKey = env('GEMINI_API_KEY', '');
        $model = env('GEMINI_MODEL', 'gemini-2.5-flash');

        if (empty($apiKey)) {
            echo json_encode(['error' => 'AI service is not configured.']);
            http_response_code(500);
            exit();
        }

        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            echo json_encode(['error' => 'Failed to connect to AI service: ' . $curlError]);
            http_response_code(500);
            exit();
        }

        $apiResponse = json_decode($response, true);

        if ($httpCode !== 200) {
            $errorMessage = $apiResponse['error']['message'] ?? 'Unknown API error.';
            echo json_encode(['error' => 'AI Service error: ' . $errorMessage]);
            http_response_code($httpCode);
            exit();
        }

        $aiText = '';
        if (isset($apiResponse['candidates'][0]['content']['parts'][0]['text'])) {
            $aiText = $apiResponse['candidates'][0]['content']['parts'][0]['text'];
        } else {
            echo json_encode(['error' => 'AI Service returned an unexpected response.']);
            http_response_code(500);
            exit();
        }

        echo json_encode(['response' => $aiText]);
        exit();
    }
}