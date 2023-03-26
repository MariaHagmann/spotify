<?php
class shortcode{
    function yee($currentTrack){
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
            <div class="background" id="myHeader">   
                <div class="grid-container">
                    <div class="grid-item1"><img src="kl.jpeg" alt="Cover" ></div>
                    <div class="grid-item2"><h4 class="text">' . $currentTrack . '</h4></div>
                    <div class="grid-item3"><p class="text">' . //print_r($img) 
                     '</p></div>
                    <div class="grid-item4">4</div>
                    <div class="grid-item5">5</div>
                    <div class="grid-item6">6</div>
                    <div class="grid-item7">7</div>
                    <div class="grid-item8">8</div>
                    <div class="grid-item9">
                        <div class="slidecontainer">
                            <input type="range" min="1" max="100" value="50" class="slider" id="myRange">
                        </div>
                    </div>
                </div>
            </div>
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
                    height: 200px; 
                    border-radius: 20px;
                    position:fixed;
                }
                .grid-container {
                    display: grid;
                    grid-template-columns: 40% 60% ;
                    grid-template-rows: 60% 10% ;
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
                    grid-row: 2;
                    border: 1px solid rgba(0, 0, 0, 0.8);

                }
                .grid-item5 {
                    grid-row: 3;
                    border: 1px solid rgba(0, 0, 0, 0.8);

                }
                .grid-item6 {
                    grid-row: 3;
                    border: 1px solid rgba(0, 0, 0, 0.8);

                }
                .grid-item7 {
                    grid-row: 3 ;
                    border: 1px solid rgba(0, 0, 0, 0.8);

                }
                .grid-item8 {
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
                    padding: 20px; 
                    grid-row: 1 / 4;
                    width: 120px;
                    height: 120px;
                    border-radius: 25px;
                }
                .text{
                    margin-left: 20px;
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