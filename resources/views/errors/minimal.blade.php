<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
{{--        <link rel="dns-prefetch" href="//fonts.gstatic.com">--}}
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body, a {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            /*.full-height {*/
            /*    height: 100vh;*/
            /*}*/

            .height-50 {
                height: 50vh;
            }

            /*.flex-center {*/
            /*    align-items: center;*/
            /*    display: flex;*/
            /*    justify-content: center;*/
            /*}*/

            .flex-bottom {
                align-items: end;
                display: flex;
                justify-content: center;
            }

            /*.flex-top {*/
            /*    align-items: start;*/
            /*    display: flex;*/
            /*    justify-content: center;*/
            /*}*/

            .position-ref {
                position: relative;
            }

            /*.code {*/
            /*    border-right: 2px solid;*/
            /*    font-size: 26px;*/
            /*    padding: 0 15px 0 15px;*/
            /*    text-align: center;*/
            /*}*/

            .message {
                font-size: 18px;
                text-align: center;
            }

            .link1 {
                /*border-right: 2px solid;*/
                margin-top: 15px;
                font-size: 22px;
                padding: 0 15px 0 15px;
                text-align: center;
            }

        </style>
    </head>
    <body>
        <div class="flex-bottom position-ref height-50">
            <div class="message" style="padding: 10px;">
                @yield('message')
                <div class="link1">
                    <a href="/" style="text-decoration: none">Inicio</a>
                </div>
            </div>
        </div>
    </body>
</html>
