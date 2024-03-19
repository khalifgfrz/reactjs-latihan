<?php

// Instagram API credentials
$clientId = '798433172312163';
$clientSecret = '6bb3ac493560dcf56ab76fca9bb65220';
$redirectUri = 'https://kozi.tokodizital.com';

// Path to the image you want to post
$imagePath = '/image/frame-kozi.jpg';

// Initialize a cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, 'https://api.instagram.com/oauth/access_token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'grant_type' => 'authorization_code',
    'redirect_uri' => $redirectUri,
    'code' => $_GET['code'] // The authorization code received after user authentication
]));

// Execute cURL session and decode the JSON response
$response = json_decode(curl_exec($ch));

// Close cURL session
curl_close($ch);

// Check if access token was successfully obtained
if (!isset($response->access_token)) {
    die('Failed to obtain access token.');
}

// Set the access token for future requests
$accessToken = $response->access_token;

// Initialize a new cURL session
$ch = curl_init();

// Set cURL options to upload the image
curl_setopt($ch, CURLOPT_URL, 'https://api.instagram.com/v1/media/upload');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'access_token' => $accessToken,
    'image' => '@' . realpath($imagePath) // Use '@' before the image path to indicate a file upload
]);

// Execute cURL session and decode the JSON response
$response = json_decode(curl_exec($ch));

// Close cURL session
curl_close($ch);

// Check if the image was successfully uploaded
if (!isset($response->data->id)) {
    die('Failed to upload image.');
}

// Get the media ID of the uploaded image
$mediaId = $response->data->id;

// Initialize a new cURL session
$ch = curl_init();

// Set cURL options to post the image
curl_setopt($ch, CURLOPT_URL, 'https://api.instagram.com/v1/media/' . $mediaId . '/media/upload');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'access_token' => $accessToken,
    'caption' => 'Your image caption here' // Caption for the image
]);

// Execute cURL session and decode the JSON response
$response = json_decode(curl_exec($ch));

// Close cURL session
curl_close($ch);

// Check if the image was successfully posted
if (!isset($response->data->id)) {
    die('Failed to post image.');
}

echo 'Image posted successfully.';
