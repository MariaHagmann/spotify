<?php
class SpotifyAPI {
    private $clientId;
    private $clientSecret;
    private $accessToken;

    public function __construct($clientId, $clientSecret) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function getAccessToken() {
        // Make a POST request to the API to get an access token
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://accounts.spotify.com/api/token');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret),
            'Content-Type: application/x-www-form-urlencoded'
        ));
        $response = curl_exec($ch);
        curl_close($ch);

        // Parse the access token from the response and store it
        $data = json_decode($response, true);
        $this->accessToken = "BQCXmAofM-qL-L_5_zaU1jawBRLStrDPUNd0TDx_ai7QgLNkTRiW2GSlzsZzg4DcswdDCzzDpCUNZp_n97rhUN37Vxou7GmQDzY9XncKMnXWSwHiuKS54ymNJfFr09qIYZEHj7s3oCWnwDklRRU07AK-QOOd0xFfMLJ_43stzUzcezkyjehelTWoYdjF7susEF9BSnQXrkP3Ep-uzWquZGAm";
    }

    public function getCurrentlyPlayingSong() {
        // Make a GET request to the API to get information about the currently playing song
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/me/player/currently-playing');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $this->accessToken,
            'Content-Type: application/json'
        ));
        $response = curl_exec($ch);
        var_dump($response);
        curl_close($ch);

        // Parse the response and extract information about the currently playing song
        $data = json_decode($response, true);
        if (isset($data['item'])) {
            $song = $data['item'];
            $artists = array();
            foreach ($song['artists'] as $artist) {
                $artists[] = $artist['name'];
            }
            $album = $song['album']['name'];
            $name = $song['name'];
            $duration = $song['duration_ms'];
            $progress = $data['progress_ms'];
            $isPlaying = $data['is_playing'];
            return array(
                'name' => $name,
                'artists' => implode(', ', $artists),
                'album' => $album,
                'duration' => $duration,
                'progress' => $progress,
                'isPlaying' => $isPlaying
            );
        } else {
            return false;
        }
    }
}
// Replace YOUR_CLIENT_ID and YOUR_CLIENT_SECRET with your actual Spotify API credentials
$spotify = new SpotifyAPI('747c64ed25b24a1a896d61bc8c3a181f', 'cbd30a870af4438ab9c2c43c820e06d0');
$spotify->getAccessToken();
$song = $spotify->getCurrentlyPlayingSong();

if ($song) {
    echo 'Currently playing: ' . $song['name'] . ' by ' . $song['artists'] . ' from the album ' . $song['album'];
} else {
    echo 'No song is currently playing.';
}

