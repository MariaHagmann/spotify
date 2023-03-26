<?php

// Replace with your client ID and client secret
$clientID = '747c64ed25b24a1a896d61bc8c3a181f';
$clientSecret = '178f5fefe8ae4514a7503366ffeebdd2';
$redirectURI = 'http://localhost:8888/callback/';

// Start session to store state parameter
session_start();

// Generate random state parameter and store it in session
$state = bin2hex(random_bytes(16));
$_SESSION['spotify_state'] = $state;

// Redirect user to Spotify authorization page
header('Location: https://accounts.spotify.com/authorize' .
    '?response_type=code' .
    '&client_id=' . $clientID .
    '&scope=user-read-private user-read-email' .
    '&redirect_uri=' . urlencode($redirectURI) .
    '&state=' . $state
);
exit();

// After user authorizes your app, they will be redirected back to your callback URL with a code and state parameter

// Verify state parameter to prevent CSRF attacks
if ($_GET['state'] !== $_SESSION['spotify_state']) {
    die('State parameter does not match!');
}

// Exchange code for access token
$code = $_GET['code'];
$authorization = base64_encode($clientID . ':' . $clientSecret);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'grant_type' => 'authorization_code',
    'code' => $code,
    'redirect_uri' => $redirectURI
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Basic ' . $authorization,
    'Content-Type: application/x-www-form-urlencoded'
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$accessToken = $data['access_token'];
$refreshToken = $data['refresh_token'];

// Use access token to make API requests
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/me');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $accessToken,
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$userID = $data['id'];

// Get user's saved tracks
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/me/tracks');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $accessToken,
    'Content-Type: application/json'
]);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);
$savedTracks = $data['items'];

// Display user's saved tracks
foreach ($savedTracks as $track) {
    echo $track['track']['name'] . ' - ' . $track['track']['artists'][0]['name'] . '<br>';
}
