<?php


require dirname(__DIR__) . '/vendor/autoload.php';



$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


$apiKey = $_ENV['OPENAI_API_KEY'];

$url = 'https://api.openai.com/v1/chat/completions';

$data = [
    "model" => "gpt-4o-mini",
    "store" => true,  // Note: `store` is not a valid OpenAI API parameter unless you have custom instructions to handle it.
    "messages" => [
        ["role" => "user", "content" => "generate a funny one-liner joke, without mentioning AI"]
    ]
];

function callAPI() {
// Initialize cURL

global $data;
global $apiKey;
global $url;

$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $apiKey
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Execute and get the response
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    // Decode and print the response
    $decoded = json_decode($response, true);
    echo $decoded['output'][0]['content'][0]['text'];
}

// Close cURL
curl_close($ch);
}

?>
