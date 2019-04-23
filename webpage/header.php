<?php

function showHeader($p) {
    echo "
        <div class='header'>
        <h2>Whitworth Undergraduate Research Hub -- ".$p."</h2>
        <div>
        <a href='https://www.whitworth.edu' class='whitworth-logo'>
        <svg version='1.1' id='whitworth_logo' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' viewBox='0 0 220 48' style='enable-background:new 0 0 220 48;' xml:space='preserve'>
            <style type='text/css'>
            .st0{fill:#C22033;}
            </style>
            <g>
            <polygon class='st0' style='fill: #C22033;' points='9.6,48 0,38.4 0,0 9.6,9.6 	'></polygon>
            <polygon class='st0' style='fill: #C22033;' points='48,38.4 38.4,48 38.4,9.6 48,0 	'></polygon>
            <polygon class='st0' style='fill: #C22033;' points='28.8,48 19.2,38.4 19.2,0 28.8,9.6 	'></polygon>
            <g>
                <path d='M63.1,39.3V33h1.7v6.3c0,1.6,0.8,2.5,2.1,2.5c1.3,0,2.1-0.8,2.1-2.4V33h1.7v6.2c0,2.7-1.5,4.1-3.8,4.1
                C64.6,43.3,63.1,41.9,63.1,39.3z'></path>
                <path d='M74.1,33h1.6l4.5,6.8V33h1.6v10.2h-1.4l-4.6-7v7h-1.7V33z'></path>
                <path d='M85.4,33h1.7v10.2h-1.7V33z'></path>
                <path d='M89.8,33h1.8l2.5,7.7l2.5-7.7h1.8l-3.5,10.2h-1.6L89.8,33z'></path>
                <path d='M101.1,33h6.4v1.5h-4.7v2.8h4.2v1.5h-4.2v2.8h4.8v1.5h-6.5V33z'></path>
                <path d='M110.6,33h3.7c1.2,0,2.1,0.3,2.7,1c0.5,0.5,0.8,1.3,0.8,2.2v0.1c0,1.6-0.9,2.5-2.1,3l2.4,3.9h-1.9l-2.2-3.6
                c0,0-0.1,0-0.1,0h-1.6v3.6h-1.7V33z M114.1,38.1c1.3,0,2-0.7,2-1.8v0c0-1.1-0.7-1.7-2-1.7h-1.8v3.5H114.1z'></path>
                <path d='M120.2,41.8l1-1.3c0.8,0.7,1.6,1.2,2.7,1.2c1,0,1.6-0.5,1.6-1.3v0c0-0.6-0.3-1.1-1.9-1.7c-1.9-0.7-2.9-1.4-2.9-3.1v0
                c0-1.7,1.3-2.8,3.2-2.8c1.2,0,2.3,0.4,3.2,1.2l-1,1.3c-0.7-0.6-1.5-1-2.3-1c-0.9,0-1.5,0.5-1.5,1.2v0c0,0.7,0.4,1.1,2.1,1.8
                c1.9,0.7,2.8,1.5,2.8,3v0c0,1.8-1.4,2.9-3.3,2.9C122.6,43.3,121.3,42.8,120.2,41.8z'></path>
                <path d='M130.2,33h1.7v10.2h-1.7V33z'></path>
                <path d='M137.4,34.6h-2.7V33h7v1.6h-2.7v8.6h-1.7V34.6z'></path>
                <path d='M146.7,39.1l-3.4-6.1h1.9l2.4,4.4l2.4-4.4h1.9l-3.4,6.1v4.1h-1.7V39.1z'></path>
            </g>
            <g>
                <path d='M59.9,4.9h3.4L67,18.8l3.9-14h2.7l3.9,14l3.8-13.9h3.3l-5.6,19.3h-2.9l-3.9-13.6l-3.9,13.6h-2.9L59.9,4.9z'></path>
                <path d='M87.3,4.9h3.2v8.1H98V4.9h3.2v19.2H98v-8.2h-7.5v8.2h-3.2V4.9z'></path>
                <path d='M105.5,4.9h3.2v19.2h-3.2V4.9z'></path>
                <path d='M116.5,7.8h-5v-3h13.3v3h-5v16.2h-3.2V7.8z'></path>
                <path d='M126.6,4.9h3.4l3.8,13.9l3.9-14h2.7l3.9,14l3.8-13.9h3.3l-5.6,19.3h-2.9L139,10.6l-3.9,13.6h-2.9L126.6,4.9z'></path>
                <path d='M152.6,14.6v-0.3c0-5.7,3.5-9.8,8.5-9.8c5,0,8.5,4.1,8.5,9.7v0.3c0,5.7-3.5,9.8-8.5,9.8C156,24.4,152.6,20.3,152.6,14.6z
                    M166.3,14.6v-0.2c0-4.1-2.2-6.9-5.2-6.9c-3,0-5.2,2.7-5.2,6.9v0.2c0,4.1,2.2,6.9,5.2,6.9C164.1,21.4,166.3,18.7,166.3,14.6z'></path>
                <path d='M172.8,4.9h6.9c2.2,0,4,0.7,5.1,1.8c1,1,1.6,2.5,1.6,4.2V11c0,3-1.6,4.8-4,5.6l4.5,7.4h-3.7l-4.1-6.8c-0.1,0-0.1,0-0.2,0
                H176v6.8h-3.2V4.9z M179.4,14.5c2.5,0,3.8-1.3,3.8-3.3v-0.1c0-2.2-1.4-3.3-3.8-3.3H176v6.7H179.4z'></path>
                <path d='M193.4,7.8h-5.1v-3h13.3v3h-5v16.2h-3.2V7.8z'></path>
                <path d='M204.1,4.9h3.2v8.1h7.5V4.9h3.2v19.2h-3.2v-8.2h-7.5v8.2h-3.2V4.9z'></path>
            </g>
            </g>
            </svg>
        </a>
        </div>

        </div>
        ";
}
?>