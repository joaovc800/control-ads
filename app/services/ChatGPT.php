<?php

class ChatGPT {
    private $apiKey;
    private $model;
    private $apiUrl = 'https://api.openai.com/v1/chat/completions';

    public function __construct($config) {
        $this->apiKey = $config['apiKey'];
        $this->model = $config['model'];
    }

    public function sendMessage($message) {
        $postData = [
            'model' => $this->model,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $message
                ]
            ],
            'max_tokens' => 150
        ];

        $response = $this->makeRequest($postData);

        return [
            'firstResponse' => $response['choices'][0]['message']['content'],
            'all' => $response
        ];
    }

    private function makeRequest($postData) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json'
        ]);

        $response = curl_exec($ch);

        if(curl_errno($ch)) {
            throw new Exception('Curl error: ' . curl_error($ch));
        }

        curl_close($ch);

        return json_decode($response, true);
    }
}
