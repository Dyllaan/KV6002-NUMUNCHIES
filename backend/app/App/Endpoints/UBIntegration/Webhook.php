<?php
// Set your secret key. Remember to switch to your live secret key in production.
// See your keys here: https://dashboard.stripe.com/apikeys

namespace App\Endpoints\UBIntegration;

use Core\Endpoint\Endpoint;

class Webhook extends Endpoint {
    public function __construct() {
        parent::__construct('POST', 'webhook');
        $this->setRequiresAuth(true);
    }

    public function process($request) {

\Stripe\Stripe::setApiKey('sk_test_51Or2IsASBo9hqIyZ96FhWF5xklh2Vot683gopzF20SNFFK24aRGWYTTm3B2pALN7Q9dMsLNcW9ramM1K8c8oNUl30080MIhalR');
$endpoint_secret = 'whsec_62262e5cc5f088133339354dc3427c278ad5c736b8075332c21e133450f39e63';

$payload = @file_get_contents('php://input');
$event = null;

$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
try {
    $event = \Stripe\Webhook::constructEvent(
        $payload,
        $sig_header,
        $endpoint_secret
    );
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    // Invalid signature
    echo "Invalid signature";
    http_response_code(400);
    exit();
}

$userId = null;

// Handle the event
switch ($event->type) {
        case 'payment_intent.succeeded':
            $paymentIntent = $event->data->object;
            $userId = $paymentIntent->metadata['user_id'];
            break;
    default:
        error_log('Received unknown event type');
}
    }
}