<?php
// Fetching JSON
$req_url = 'https://api.exchangerate-api.com/v4/latest/USD';
$response_json = file_get_contents($req_url);

// Continuing if we got a result
if(false !== $response_json) {

    // Try/catch for json_decode operation
    try {

    // Decoding
    $response_object = json_decode($response_json);

    // YOUR APPLICATION CODE HERE, e.g.
    $base_price = 1; // Your price in USD
    $KES_price = round(($base_price * $response_object->rates->KES), 2);

    echo $KES_price;

    }
    catch(Exception $e) {
        // Handle JSON parse error...
    }
}


?>