<?php
header("Content-Type: application/json");
define("VERIFICATION_TOKEN", "your-verification-code");
define("SECRET", "your-secret");
// Set this to true to use the example body. IMPORTANT! Do NOT use this to true if you want to have the webhook verified, as this will overwrite the payload we send you for verification purposes.
define("USE_EXAMPLE_BODY", false);

if (SECRET) {
    if (! isset($_SERVER['HTTP_AUTHORIZATION']) || $_SERVER['HTTP_AUTHORIZATION'] !== "Bearer " . SECRET) {
        http_response_code(401);
        die('Not authorized.');
    }
}

// Read the request body
$request_body = file_get_contents('php://input');

// MessengerPeople Example Body
$example_body = '{"uuid":"abcdef12-1234-aaaa-4321-abcdef123456","sender":"491721234567","recipient":"ab654321-4321-abcd-4321-987654321abc","payload":{"timestamp":"1571385584","text":"Hello World","user":{"id":"491721234567","name":"Tappy Tester","image":""},"attachment":"","type":"text"},"outgoing":false,"processed":null,"sent":null,"received":null,"read":null,"created":null,"messenger":"WB","messenger_id":"ABEGSRYyNxVAAhD2YdoUOWfO9YXSOWmnigB8"}';

if (USE_EXAMPLE_BODY) {
    $request_body = $example_body;
}

$response = [
    "success" => true
];

// If request body is not empty
if ($request_body) {

    // Create associative array $payload from $request_body
    $payload = json_decode($request_body, true);

    // Check if MessengerPeople sent you a challenge, check the verification code. If both is correct, fine - if not - send a 403.
    if (isset($payload['challenge']) && isset($payload['verification_token'])) {

        $verification_token = $payload['verification_token'];

        // If verification code does not match the value set by you, send 403 - forbidden.
        if ($verification_token !== VERIFICATION_TOKEN) {
            http_response_code(403);
            die("Wrong verification code.");
        }

        // Add challenge to the response.
        $response['challenge'] = $payload['challenge'];
    }

    // At this point everything is fine, the challenge was set, the secret header was checked and you can process the message.
    processMessage($payload);

    // Send a 200 response, so the MessengerPeople servers know, that everything arrived.
    http_response_code(200);
    echo json_encode($response);
}


/**
 * Contains examples of what to do with the message and prints content to error log.
 * We strongly suggest to keep webhooks simple and fast and handle processing logic async.
 *
 * @param $message
 * @return bool
 */
function processMessage($message) {
    // Store in MessageQueue or Database
    saveToDatabase($message);
    return true;
}

function saveToDatabase($message) {
    return true;
}
