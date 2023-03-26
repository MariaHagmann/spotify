<?php
class SpotifyAPI
{
    private $clientId;
    private $clientSecret;
    private $accessToken;

    public function __construct($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        
        if (isset($_POST['submit'])) {
            switch ($_POST['shortcode']) {
                case 'shortcode1':
                echo do_shortcode('[spotify]');
                break;
                case 'shortcode2':
                echo do_shortcode('[shortcode2]');
                break;
                case 'shortcode3':
                echo do_shortcode('[shortcode3]');
                break;
            }
        }
        add_shortcode('spotify', array($this, 'shortcode'));
    }

    public function getAccessToken()
    {
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

        $data = json_decode($response, true);
        //Funktionniert nicht
        $this->accessToken = $_POST['AT'];
    }
    

    public function getCurrentTrack()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.spotify.com/v1/me/player/currently-playing');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $this->accessToken,
            'Content-Type: application/x-www-form-urlencoded'
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($response);  
        
    return $data;
    }
    public function shortcode()
    {
    
   
    $this->getAccessToken();

    $data = $this->getCurrentTrack();

    
        $currentTrack = $data->item->name;
        $artist = $data->item->artists[0]->name; 
        $img = $data->item->album->images[0]->url; 
        $progress_ms = $data->progress_ms;
        $progress = $progress_ms /1000 ;
        

        echo 'Currently playing: ' . $currentTrack .  '<br>';
        echo $progress;
            echo '
            <!DOCTYPE html>
            <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Spotify Player Plugin</title>
                </head>
                <body>
                    <form action="" method="POST">
                        Access Token: <input type="text" name="AT" /><br />
                        <input type="Submit" value="Absenden" />                           
                    </form>
                    <div class="background" id="myHeader"> ' ;
                        if(!empty($data)){
                            echo '<div class="grid-container">
                            <div class="grid-item1"><img src="' . $img . '" alt="Cover" ></div>
                            <div class="grid-item2"><h4 class="text">' . $currentTrack . '</h4></div>
                            <div class="grid-item3"><p class="text">' . $artist . '</p></div>
                            <div class="grid-item4">qw</div>
                            <div class="grid-item9"><input type="range" min="1" max="100" value="' . $progress . '" class="slider" id="myRange"></div>
                        </div>';
                        }else{
                            echo '<div style="margin: 5%;">Play a Song!</div>';
                        }
                    echo '</div>
                    <style>
                    
                        .sticky {
                        position: fixed;
                        top: 0;
                        width: 100%;
                        }
                        .background{
                            background-color: #403E3E; 
                            margin-top: 120px;
                            margin-left: 1%;
                            width: 450px; 
                            height: 300px; 
                            border-radius: 20px;
                            position:fixed;
                        }
                        .grid-container {
                            display: grid;
                            grid-template-columns: 40% 60% ;
                            grid-template-rows: 50% 20% ;
                        }
                        .grid-item1 {
                            grid-row: 1 / 3;
                            border: 1px solid rgba(0, 0, 0, 0.8);
                            
        
                        }
                        .grid-item2 {
                            grid-row: 1 ;
                            border: 1px solid rgba(0, 0, 0, 0.8);
        
                        }
                        .grid-item3 {
                            grid-row: 2;
                            border: 1px solid rgba(0, 0, 0, 0.8);
        
                        }
                        .grid-item4 {
                            grid-row: 3;
                            border: 1px solid rgba(0, 0, 0, 0.8);
        
                        }
                        .grid-item9 {
                            grid-row: 3 ;
                            border: 1px solid rgba(0, 0, 0, 0.8);
                            text-align: center;
                            padding: 2px;
        
                        }
                        img{
                            padding: 20%; 
                            grid-row: 1 / 4;
                            width: 100px;
                            height: 100px;
                            border-radius: 25px;
                        }
                        .text{
                            margin-left: 20px;
                            margin-top: 20px;
                            color: white;
                            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                            
                        }
                        .slider {
                            -webkit-appearance: none;
                            width: 95%;
                            height: 5px;
                            border-radius: 5px;  
                            background: #d3d3d3;
                            outline: none;
                            opacity: 0.7;
                            -webkit-transition: .2s;
                            transition: opacity .2s;
                            margin:20px;
                        }
                        
                        .slider::-webkit-slider-thumb {
                            -webkit-appearance: none;
                            appearance: none;
                            width: 10px;
                            height: 10px;
                            border-radius: 50%; 
                            background: #ffffff;
                            cursor: pointer;
                        }
                        
                        .slider::-moz-range-thumb {
                            width: 25px;
                            height: 25px;
                            border-radius: 50%;
                            background: #ffffff;
                            cursor: pointer;
                        }
                    </style>
                </body>
            </html>
            ';
}
}



