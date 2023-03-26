<?php
class SpotifyAPI
{
    private $clientId;
    private $clientSecret;
    private $accessToken;

    public function __construct()
    {
        $this->clientId = get_option('spotifyplayer_clientID');
        $this->clientSecret = get_option('spotifyplayer_clientSecret');;

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
        //Code von Ricky
        public function RickyView($currentTrack,$artist,$img,$progress_ms,$duration,$data,$play)
        {
            echo '
            <!DOCTYPE html>
            <html>
            <head>
                <link rel="stylesheet" type="text/css" href="style.css">
                <title>Widget player</title>
                
                <meta charset="UTF-8" />
                    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                    <title>Spotify widget player</title>

                    <link
                        rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
                        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
                        crossorigin="anonymous"
                        referrerpolicy="no-referrer"
                    />
            </head>
            <body>      

                    <form action="" method="POST">
                        Access Token: <input type="text" name="AT" /><br />
                        <input type="Submit" value="Absenden" />                           
                    </form>

                    <div class="position">
                    <div class="music-player">
                        <div class="container">
                            <div class="song-bar">
                                <div class="song-infos">
                                    <div class="image-container">
                                        <img src="' . $img . '" alt="" />
                                    </div>
                                    <div class="song-description">
                                        <p class="title">
                                        ' . $currentTrack . '
                                        </p>
                                        <p class="artist">' . $artist . '</p>
                                    </div>
                                </div>
                            </div>
                            </div>
                        
                        

                            <div class="container">
                                <div class="control-buttons">                  
                                    <i class="fas fa-step-backward"></i>
                                    <i class="fas fa-play"></i>
                                    <i class="fas fa-step-forward"></i>   
                                </div>
                            </div>
                            <div class="progress-controller">
                                <div class="progress-container">
                                    
                                        <div class="progress-bar">
                                            <input type="range" min="0" max="' . $duration . '" value="' . $progress_ms . '" disabled style="width:345%";>
                                        </div>
                                
                                </div>
                            </div>  
                        </div>
                        
                    </div>
                    </div>


            </body> 
            <style>
            @import url(//db.onlinewebfonts.com/c/860c3ec7bbc5da3e97233ccecafe512e?family=Circular+Std+Book);

                i{
                    color: var(--secondary-color);
                }
                i:hover{
                    color: var(--primary-color);
                }
                .song-bar {        
                    display: flex;
                    flex-direction: column;
                    align-items: flex-start;
                    justify-content: flex-start;
                    gap: 1.5rem;
                    width: 100%;
                    margin: 3%;
                }
                
                .song-infos {
                    display: flex;
                    align-items: center;
                    gap: 1em;
                }
                .image-container {
                    --size: 6em;
                    flex-shrink: 0;
                    width: var(--size);
                    height: var(--size);
                }
                .image-container img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
                .song-description p {
                    margin: 0.2em;
                }
                .title,
                .artist {
                    display: -webkit-box;
                    -webkit-box-orient: vertical;
                    -webkit-line-clamp: 1;
                    overflow: hidden;
                }
                .title:hover,
                .artist:hover {
                    text-decoration: underline;
                }
                .artist{
                    color: var(--secondary-color);
                }
                
                
                .control-buttons{
                    display: flex;
                    align-items: center;
                    gap: 2em;
                    
                }
                .play-pause{
                    display: inline-block;
                    padding: 1em;
                    background-color: var(--primary-color);
                    color: #111;
                    border-radius: 50%;
                }
                .play-pause:hover{
                    transform: scale(1.1);
                    color: #111;
                }                
                .music-player {
                    --primary-color: #ddd;
                    --padding: 1.75em;
                    background-color: #111;
                    position: fixed; 
                    padding: var(--padding);
                    color: var(--primary-color);
                
                    display: flex;
                    justify-content: space-around;
                    align-items: flex-start;
                    margin: 1em;
                    flex-shrink: 0;
                    width: 25em;
                    height: 10em;
                    flex-direction: column;
                    gap: 9%;
                    border-radius: 25px;
                }
                
                .container {
                    display: flex;
                    justify-content: space-around;
                    flex-direction: column;
                    align-items: flex-start;
                }
                
                .position {
                    display: flex;
                    flex-direction: column;
                    margin-top: 3%;
                    position: sticky;
                    margin-right: 3%;
                        
                }
                }</style>
            </html>';
        }
        //Code von Maria
        public function MariaView($currentTrack,$artist,$img,$progress_ms,$duration,$data,$play)
        {
            echo '
            <!DOCTYPE html>
            <html>
            <head>
                <link rel="stylesheet" type="text/css" href="style.css">
                <title>Widget player</title>
                
                <meta charset="UTF-8" />
                    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                    <title>Spotify widget player</title>

                    <link
                        rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
                        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
                        crossorigin="anonymous"
                        referrerpolicy="no-referrer"
                    />
            </head>
            <body>     
                        <div class="token">
                        <form action="" method="POST">
                            Access Token: <input type="text" name="AT" /><br />
                            <input type="Submit" value="Absenden" />                           
                        </form>
                        </div>
                    

                    <div class="position">
                    <div class="music-player">
                        <div class="container">
                        <div class="song-bar">
                            <div class="song-infos">
                                <div class="image-container">
                                    <img src="' . $img . '" alt="" />
                                </div>
                                <div class="song-description">
                                    <p class="title">
                                    ' . $currentTrack . '
                                    </p>
                                    <p class="artist">' . $artist . '</p>
                                </div>
                            </div>
                        </div>
                        </div>
                        
                        <div class="progress-controller">
                                <div class="progress-container">
                                    
                                        <div class="progress-bar">
                                            <input type="range" min="0" max="' . $duration . '" value="' . $progress_ms . '" disabled style="width:100%";>
                                        </div>
                                
                                </div>
                            </div>  

                        <div class="container">
                            <div class="control-buttons">                  
                                <i class="fas fa-step-backward"></i>
                                <i class="play-pause fas fa-play"></i>
                                <i class="fas fa-step-forward"></i>   
                            </div>
                        </div>
                        </div>
                        
                    </div>
                    </div>


            </body> 
            <style>
            @import url(//db.onlinewebfonts.com/c/860c3ec7bbc5da3e97233ccecafe512e?family=Circular+Std+Book);

                * {
                    box-sizing: border-box;
                    font-family: "circular std book", sans-serif;
                }
                
                body {
                    margin: 0;
                    padding: 0;
                    background-color: #222;
                    font-size: 14px;
                }
                
                
                i{
                    color: var(--secondary-color);
                }
                i:hover{
                    color: var(--primary-color);
                }
                .song-bar {
                    position: sticky;
                    left: var(--padding);
                
                    display: flex;
                    flex-direction: column;
                    align-items: flex-start;
                    justify-content: flex-start;
                    gap: 1.5rem;
                    width: 90%;
                    margin: 3%;
                }
                
                .song-infos {
                    display: flex;
                    align-items: center;
                    gap: 1em;
                }
                .image-container {
                    --size: 4.5em;
                    flex-shrink: 0;
                    width: var(--size);
                    height: var(--size);
                }
                .image-container img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
                .song-description p {
                    margin: 0.2em;
                }
                .title,
                .artist {
                    display: -webkit-box;
                    -webkit-box-orient: vertical;
                    -webkit-line-clamp: 1;
                    overflow: hidden;
                }
                .title:hover,
                .artist:hover {
                    text-decoration: underline;
                }
                .artist{
                    color: var(--secondary-color);
                }
                .icons{
                    display: flex;
                    gap: 1em;
                }
                .progress-controller{
                    width: 100%;
                    display: flex;
                    justify-content: space-around;
                    flex-direction: column;
                    align-items: center;
                    color: var(--secondary-color);
                }
                .control-buttons{
                    display: flex;
                    align-items: center;
                    gap: 2em;
                    padding-left: 80%;
                }
                .play-pause{
                    display: inline-block;
                    padding: 1em;
                    background-color: var(--primary-color);
                    color: #111;
                    border-radius: 50%;
                }
                .play-pause:hover{
                    transform: scale(1.1);
                    color: #111;
                }
                .progress-container{
                    width: 100%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 1em;
                }
                .progress-bar{
                    height: 4px;
                    border-radius: 10px;
                    width: 70%;
                }
                .progress{
                    position: sticky;
                    height: 100%;
                    width: 30%;
                    border-radius: 10px;
                }
                
                
                .music-player {
                    --primary-color: #ddd;
                    --secondary-color: #999;
                    --green-color: #2d5;
                    --padding: 1em;
                    background-color: #111;
                    position: fixed; 
                
                    height: 7rem;
                    padding: var(--padding);
                    color: var(--primary-color);
                
                    display: flex;
                    justify-content: space-around;
                    align-items: flex-start;
                    margin: 1em;
                    flex-shrink: 0;
                    width: 25em;
                    height: 15em;
                    flex-direction: column;
                
                    border-radius: 25px;
                    border: 2px solid #000;
                }
                
                .container {
                    display: flex;
                    justify-content: space-around;
                    flex-direction: column;
                    align-items: flex-start;
                }
                
                .position {
                    display: flex;
                    flex-direction: column;
                    margin-top: 3%;
                    position: sticky;
                    margin-right: 3%;
                        
                }
                
                .token {
                    --primary-color: #ddd;
                    --secondary-color: #999;
                    --padding: 2em;
                    background-color: #111;
                    position: fixed;
                
                    height: 7rem;
                    padding: var(--padding);
                    color: var(--primary-color);
                
                    display: flex;
                    justify-content: flex-end;
                    align-items: flex-end;
                    margin-top: 1em;
                    margin-left: 45em;
                    flex-shrink: 0;
                    width: 20em;
                    height: 12em;
                    flex-direction: column;
                
                    border-radius: 25px;
                    border: 2px solid #000;
                }</style>
            </html>';
        }
        //Code von Timo
        public function TimoView($currentTrack,$artist,$img,$progress_ms,$duration,$data,$play)
        {
            echo '<!DOCTYPE html>
            <html>
            <head>
                <link rel="stylesheet" type="text/css" href="style.css">
                <title>Music Player</title>
                
                <meta charset="UTF-8" />
                    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
                    <title>Spotify music player</title>
                    <link rel="stylesheet" href="style.css" />
            
                    <link
                        rel="stylesheet"
                        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
                        integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
                        crossorigin="anonymous"
                        referrerpolicy="no-referrer"
                    />
            </head>
            <body>
                     <div class="music-player">
                        <div class="song-bar">
                            <div class="song-infos">
                                <div class="image-container">
                                    
                                    <img src="' . $img . '" width="100" height="100">
                                </div>
                                <div class="song-description">
                                    <p class="title">'
                                        
                                    . $currentTrack .
                                        
                                    '</p>
                                    <p class="artist">
                                       
                                      "'. $artist .'"
                                       
                                    </p>
                                </div>
                            </div>
                        </div>
            
                        <div class="progress-controller">
                            <div class="control-buttons">                  
                                <i class="fas fa-step-backward"></i>
                                <i class="play-pause fas fa-play"></i>
                                <i class="fas fa-step-forward"></i>   
                            </div>
                            <div class="progress-controller">
                                <div class="progress-container">
                                    
                                        <div class="progress-bar">
                                            <input type="range" min="0" max="' . $duration . '" value="' . $progress_ms . '" disabled style="width:100%";>
                                        </div>
                                
                                </div>
                            </div>  
                        </div>
                       
                    </div>
            </body> 
            <style>
            * {
                box-sizing: border-box;
                font-family: "circular std book", sans-serif;
            }
            
            body {
                margin: 0;
                padding: 0;
                background-color: #222;
                font-size: 14px;
            }
            
            .music-player {
                --primary-color: #ddd;
                --secondary-color: #999;
                --green-color: #2d5;
                --padding: 1em;
                background-color: #111;
                display: flex;
                justify-content: center;
                align-items: center;
                position: fixed;
                width: 100%;
                height: 7rem;
                padding: var(--padding);
                margin-top: 24em;
                color: var(--primary-color);
            }
            i{
                color: var(--secondary-color);
            }
            i:hover{
                color: var(--primary-color);
            }
            .song-bar {
                position: absolute;
                left: var(--padding);
            
                display: flex;
                flex-direction: row;
                align-items: center;
                justify-content: flex-start;
                gap: 1.5rem;
                width: 25%;
            }
            
            .song-infos {
                display: flex;
                align-items: center;
                gap: 1em;
            }
            .image-container {
                --size: 4.5em;
                flex-shrink: 0;
                width: var(--size);
                height: var(--size);
            }
            .image-container img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            .song-description p {
                margin: 0.2em;
            }
            .title,
            .artist {
                display: -webkit-box;
                -webkit-box-orient: vertical;
                -webkit-line-clamp: 1;
                overflow: hidden;
            }
            .title:hover,
            .artist:hover {
                text-decoration: underline;
            }
            .artist{
                color: var(--secondary-color);
            }
            
            .progress-controller{
                width: 100%;
                display: flex;
                justify-content: center;
                flex-direction: column;
                align-items: center;
                
                color: var(--secondary-color);
            }
            .control-buttons{
                display: flex;
                align-items: center;
                gap: 2em;
            }
            .play-pause{
                display: inline-block;
                padding: 1em;
                background-color: var(--primary-color);
                color: #111;
                border-radius: 50%;
            }
            .play-pause:hover{
                transform: scale(1.1);
                color: #111;
            }
            .progress-container{
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 1em;
            }
            .progress-bar{
                height: 4px;
                border-radius: 10px;
                width: 30%;
            }
            .progress{
                position: relative;
                height: 100%;
                width:  80%;
                border-radius: 10px;
                background-color: var(--secondary-color);
            }
            .progress-bar:hover .progress{
                background-color: var(--green-color);
            }
            .progress-bar:hover .progress::after{
                content: "";
                position: absolute;
                --size: 1em;
                width: var(--size);
                height: var(--size);
                right: 0;
                border-radius: 50%;
                background-color: var(--primary-color);
                transform: translate(50%, calc(2px - 50%));
            }
             </style>
            </html>';
        }

    public function shortcode()
    {   
        $this->getAccessToken();

        $data = $this->getCurrentTrack();

        $currentTrack = $data->item->name;
        $artist = $data->item->artists[0]->name; 
        $img = $data->item->album->images[0]->url; 
        $duration = $data->item->duration_ms;
        $play = $data->is_playing;
        $progress_ms = $data->progress_ms;


        $person = get_option('spotifyplayerselectPerson');
        if($person == 'Ricky'){
            $this->RickyView($currentTrack,$artist,$img,$progress_ms,$duration,$data,$play);
        } else if($person == 'Maria'){
            $this->MariaView($currentTrack,$artist,$img,$progress_ms,$duration,$data,$play);
        } else if($person == 'Timo'){
            $this->TimoView($currentTrack,$artist,$img,$progress_ms,$duration,$data,$play);
        }
    
}




}