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

        if (!is_array($data)) {
            $this->jsonError('Invalid chat request payload.', 400);
        }

        $userPrompt = $data['prompt'] ?? '';
        $chatHistory = $data['history'] ?? [];

        if (empty($userPrompt)) {
            $this->jsonError('No prompt provided.', 400);
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
            $this->jsonError('AI service is not configured. Please set GEMINI_API_KEY on the server.', 500);
        }

        if (!function_exists('curl_init')) {
            $this->jsonError('PHP cURL extension is not available on this hosting account.', 500);
        }

        $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}";

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_USERAGENT, 'CraftWise-AI-Chat/1.0');

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            error_log('CraftWise AI cURL error: ' . $curlError);
            $this->jsonError('Failed to connect to AI service: ' . $curlError, 500);
        }

        $apiResponse = json_decode($response, true);

        if ($apiResponse === null && json_last_error() !== JSON_ERROR_NONE) {
            error_log('CraftWise AI invalid response: HTTP ' . $httpCode . ' body: ' . substr((string)$response, 0, 500));
            $this->jsonError('AI Service returned an invalid response.', 502);
        }

        if ($httpCode !== 200) {
            $errorMessage = $apiResponse['error']['message'] ?? 'Unknown API error.';
            error_log('CraftWise AI HTTP error ' . $httpCode . ': ' . $errorMessage);
            $this->jsonError('AI Service error: ' . $errorMessage, $httpCode);
        }

        $aiText = '';
        if (isset($apiResponse['candidates'][0]['content']['parts'][0]['text'])) {
            $aiText = $apiResponse['candidates'][0]['content']['parts'][0]['text'];
        } else {
            $this->jsonError('AI Service returned an unexpected response.', 500);
        }

        echo json_encode(['response' => $aiText]);
        exit();
    }

    private function jsonError(string $message, int $statusCode): void
    {
        http_response_code($statusCode);
        echo json_encode(['error' => $message]);
        exit();
    }
}