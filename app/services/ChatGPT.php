<?php

class ChatGPT {
    private string $apiKey;
    private string $model;
    private string $apiUrl = 'https://api.openai.com/v1/chat/completions';

    public function __construct(array $config) {
        if (empty($config['apiKey']) || empty($config['model'])) {
            throw new InvalidArgumentException('API Key and Model are required.');
        }

        $this->apiKey = $config['apiKey'];
        $this->model = $config['model'];
    }

    /**
     * Envia uma mensagem ao modelo e retorna a resposta.
     * 
     * @param string $message Mensagem a ser enviada.
     * @param string|null $note Observação opcional a ser incluída na solicitação.
     * @return array Resposta da API como um array.
     * @throws RuntimeException Se ocorrer um erro na solicitação ou resposta.
     */
    public function sendMessage(string $message, ?string $note = null): array {
        $messages = [
            [
                'role' => 'user',
                'content' => $message
            ]
        ];

        if ($note !== null) {
            // Adiciona a observação (nota) como uma mensagem adicional.
            $messages[] = [
                'role' => 'system',
                'content' => $note
            ];
        }

        $postData = [
            'model' => $this->model,
            'messages' => $messages,
            'max_tokens' => 1000
        ];

        $response = $this->makeRequest($postData);

        if (!isset($response['choices'][0]['message']['content'])) {
            throw new RuntimeException('Invalid response format.');
        }

        return [
            'firstResponse' => $response['choices'][0]['message']['content'],
            'all' => $response
        ];
    }

    /**
     * Faz a solicitação para a API do OpenAI.
     * 
     * @param array $postData Dados para enviar na solicitação.
     * @return array Resposta decodificada da API.
     * @throws RuntimeException Se ocorrer um erro na solicitação ou resposta.
     */
    private function makeRequest(array $postData): array {
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

        if (curl_errno($ch)) {
            throw new RuntimeException('Curl error: ' . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new RuntimeException('API request failed with status code ' . $httpCode);
        }

        $decodedResponse = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException('Failed to decode JSON response: ' . json_last_error_msg());
        }

        if (!is_array($decodedResponse)) {
            throw new RuntimeException('API response is not an array.');
        }

        return $decodedResponse;
    }
}
